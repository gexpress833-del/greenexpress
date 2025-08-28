<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Order;
use App\Models\Meal;
use App\Models\Subscription;
use App\Models\Delivery;
use App\Models\User;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL; // Add this line
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    use AuthorizesRequests;

    protected $invoiceService;
    protected $whatsappService;

    public function __construct(InvoiceService $invoiceService, WhatsAppService $whatsappService)
    {
        $this->invoiceService = $invoiceService;
        $this->whatsappService = $whatsappService;
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $orders = Order::with(['user', 'driver', 'subscription'])->latest()->paginate(15);
        } elseif ($user->isDriver()) {
            $orders = Order::with(['user', 'subscription'])
                ->where('driver_id', $user->id)
                ->whereIn('status', ['validated', 'in_delivery'])
                ->latest()
                ->paginate(15);
        } else {
            $orders = Order::with(['driver', 'subscription'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(15);
        }

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $meals = Meal::available()->get();
        $subscriptionPlans = \App\Models\SubscriptionPlan::all(); // Utiliser SubscriptionPlan
        $exchangeRate = \App\Models\ExchangeRate::getCurrentRate(); // Passer le taux de change
        
        return view('orders.create', compact('meals', 'subscriptionPlans', 'exchangeRate')); // Passer exchangeRate
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:a_l_unite,subscription',
            'subscription_plan_id' => 'required_if:type,subscription|exists:subscription_plans,id', // Changer pour subscription_plan_id
            'meals' => 'required_if:type,a_l_unite|array',
            'meals.*.meal_id' => 'required_if:type,a_l_unite|exists:meals,id',
            'meals.*.quantity' => 'required_if:type,a_l_unite|integer|min:1',
            'delivery_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Vérifier si le client a déjà un abonnement actif
            if ($request->type === 'subscription' && $user->subscriptions()->active()->exists()) {
                return back()->withErrors([
                    'subscription' => 'Vous avez déjà un abonnement actif. Veuillez contacter l\'administrateur pour modifier votre abonnement.'
                ])->withInput();
            }

            $totalAmount = 0;
            $subscriptionId = null;

            if ($request->type === 'subscription') {
                $plan = \App\Models\SubscriptionPlan::findOrFail($request->subscription_plan_id);
                $totalAmount = $plan->package_price_cdf;

                // Créer l'abonnement pour le client (en attente de validation par l'admin)
                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'name' => $plan->name,
                    'category_type' => $plan->category_type,
                    'duration_type' => $plan->duration_type,
                    'unit_price_per_meal_cdf' => $plan->unit_price_per_meal_cdf,
                    'package_price_cdf' => $plan->package_price_cdf,
                    'meal_count' => $plan->meal_count,
                    'plan_description' => $plan->description,
                    'start_date' => now(),
                    'end_date' => ($plan->duration_type === 'monthly') ? now()->addMonths(1) : now()->addWeeks(1),
                    'status' => 'pending_validation',
                    'reason' => null,
                ]);
                $subscriptionId = $subscription->id;

            } else {
                foreach ($request->meals as $mealData) {
                    $meal = Meal::findOrFail($mealData['meal_id']);
                    // Utiliser price_cdf pour le calcul du total de la commande
                    $totalAmount += $meal->price_cdf * $mealData['quantity'];
                }
            }

            $order = Order::create([
                'user_id' => $user->id,
                'subscription_id' => $subscriptionId, // Utiliser l'ID de l'abonnement créé
                'type' => $request->type,
                'total_amount' => $totalAmount,
                'delivery_address' => $request->delivery_address,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            if ($request->type === 'a_l_unite') {
                foreach ($request->meals as $mealData) {
                    $meal = Meal::findOrFail($mealData['meal_id']);
                    $order->orderItems()->create([
                        'meal_id' => $meal->id,
                        'quantity' => $mealData['quantity'],
                        'unit_price' => $meal->price_cdf, // Utiliser price_cdf ici aussi
                        'total_price' => $meal->price_cdf * $mealData['quantity'], // Et ici
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Commande créée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la création de la commande.']);
        }
    }

    public function show(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! Gate::allows('view', $order)) {
            abort(403, 'Unauthorized action.');
        }
        
        $order->load(['user', 'driver', 'subscription', 'orderItems.meal', 'invoice', 'delivery']);
        
        return view('orders.show', compact('order'));
    }

    public function validateOrder(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (! Gate::allows('validate', $order)) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();

            // Générer la facture
            $invoice = $this->invoiceService->generateInvoice($order);

            // Envoyer par WhatsApp
            if ($order->user->phone) {
                $this->whatsappService->sendInvoice($order->user->phone, $invoice, $invoice->pdf_path);
            }

            // Mettre à jour le statut
            $order->update(['status' => 'validated']);

            DB::commit();

            return back()->with('success', 'Commande validée et facture envoyée !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la validation de la commande.']);
        }
    }

    public function assignDriver(Request $request, Order $order)
    {
        $request->validate([
            'driver_id' => 'required|exists:users,id'
        ]);

        $order->update(['driver_id' => $request->driver_id]);

        return back()->with('success', 'Livreur assigné avec succès !');
    }

    public function startDelivery(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        Log::info('Attempting to start delivery', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'order_id' => $order->id,
            'order_driver_id' => $order->driver_id,
            'order_status' => $order->status,
        ]);

        if (! Gate::allows('deliver', $user, $order)) {
            Log::warning('Delivery authorization failed', [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'policy_check_result' => false,
            ]);
            abort(403, 'Unauthorized action.');
        }

        $order->update(['status' => 'in_delivery']);

        // Créer l'enregistrement de livraison
        Delivery::create([
            'order_id' => $order->id,
            'driver_id' => Auth::id(),
        ]);

        // Notifier le client
        if ($order->user->phone) {
            $this->whatsappService->sendDeliveryNotification($order->user->phone, $order);
        }

        return back()->with('success', 'Livraison démarrée !');
    }

    public function validateDelivery(Request $request, Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'secure_code' => 'required|string'
        ]);

        $delivery = $order->delivery;
        
        if (!$delivery) {
            return back()->withErrors(['error' => 'Aucune livraison trouvée pour cette commande.']);
        }

        if ($delivery->validateCode($request->secure_code)) {
            // Notifier le client
            if ($order->user->phone) {
                $this->whatsappService->sendDeliveryCompleted($order->user->phone, $order);
            }

            return back()->with('success', 'Livraison validée avec succès !');
        } else {
            return back()->withErrors(['error' => 'Code sécurisé incorrect.']);
        }
    }

    public function downloadInvoice(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Seuls l'admin et le client propriétaire de la commande peuvent télécharger la facture
        if (!($user->isAdmin() || ($user->isClient() && $order->user_id === $user->id))) {
            abort(403, 'Action non autorisée. Vous n\'êtes pas autorisé à télécharger cette facture.');
        }

        // Obtenez le chemin complet du PDF via InvoiceService
        $invoicePath = $this->invoiceService->downloadInvoice($order->invoice); // Assurez-vous que l'invoice existe

        if (! $order->invoice) {
            abort(404, 'Facture non trouvée pour cette commande.');
        }

        if (file_exists($invoicePath)) {
            return response()->download($invoicePath, 'facture_' . $order->invoice->invoice_number . '.pdf');
        }

        abort(404, 'Facture non trouvée.');
    }

    public function downloadSignedInvoice(Request $request, \App\Models\Invoice $invoice) // Correct type-hint
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'Signature invalide.');
        }

        $invoicePath = $this->invoiceService->downloadInvoice($invoice);

        if (file_exists($invoicePath)) {
            return response()->download($invoicePath, 'facture_' . $invoice->invoice_number . '.pdf');
        }

        abort(404, 'Facture non trouvée.');
    }
}
