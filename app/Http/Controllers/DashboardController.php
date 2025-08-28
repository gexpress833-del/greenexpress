<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Meal;
use App\Models\Subscription;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Add this line
use App\Models\Category; // Add this line
use Illuminate\Support\Facades\Log; // Add this line

class DashboardController extends Controller
{
    public function admin()
    {
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $exchangeRate = \App\Models\ExchangeRate::getCurrentRate();
        $totalRevenueUsd = $totalRevenue;
        $totalRevenueCdf = null;

        if ($exchangeRate) {
            // Assuming total_amount in orders is in USD for now, convert to CDF
            // This logic might need adjustment based on how total_amount is actually stored (CDF or USD)
            $totalRevenueCdf = $totalRevenue * $exchangeRate->inverse_rate;
        }

        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'validated_orders' => Order::validated()->count(),
            'in_delivery_orders' => Order::inDelivery()->count(),
            'delivered_orders' => Order::delivered()->count(),
            'total_revenue_usd' => $totalRevenueUsd,
            'total_revenue_cdf' => $totalRevenueCdf,
            'active_subscriptions' => Subscription::active()->count(),
            'total_drivers' => User::drivers()->count(),
            'total_clients' => User::clients()->count(),
            'total_deliveries' => Delivery::where('code_validated', true)->count(), // Total validated deliveries
        ];

        $recentOrders = Order::with(['user', 'driver'])
            ->latest()
            ->take(10)
            ->get();

        $monthlyRevenue = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
            ->whereYear('created_at', date('Y'))
            ->where('status', '!=', 'cancelled')
            ->groupBy('month')
            ->get();

        return view('dashboard.admin', compact('stats', 'recentOrders', 'monthlyRevenue', 'exchangeRate'));
    }

    public function client()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $totalSavingsCdf = $user->subscriptions->sum(function($subscription) {
            // Calculer les économies basées sur les nouveaux noms de colonnes et la logique
            return ($subscription->unit_price_per_meal_cdf * $subscription->meal_count) - $subscription->package_price_cdf;
        });
        
        $exchangeRate = \App\Models\ExchangeRate::getCurrentRate();

        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->pending()->count(),
            'delivered_orders' => $user->orders()->delivered()->count(),
            'active_subscriptions_count' => $user->subscriptions()->active()->count(), // Updated key
            'pending_subscriptions_count' => $user->subscriptions()->where('status', 'pending_validation')->count(), // New stat
            'total_savings_cdf' => $totalSavingsCdf,
        ];

        $recentOrders = $user->orders()
            ->with(['driver', 'subscription', 'orderItems.meal']) // Eager load meal for images
            ->latest()
            ->take(5)
            ->get();

        $activeSubscriptions = $user->subscriptions()
            ->active()
            ->get();

        $pendingSubscriptions = $user->subscriptions()
            ->where('status', 'pending_validation')
            ->get();

        return view('dashboard.client', compact('stats', 'recentOrders', 'activeSubscriptions', 'pendingSubscriptions', 'exchangeRate'));
    }

    public function driver()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $exchangeRate = \App\Models\ExchangeRate::getCurrentRate();

        $stats = [
            'assigned_orders' => $user->assignedOrders()->whereIn('status', ['validated', 'in_delivery'])->count(),
            'completed_deliveries' => $user->deliveries()->where('code_validated', true)->count(),
            'pending_deliveries' => $user->deliveries()->where('code_validated', false)->count(),
        ];

        $assignedOrders = $user->assignedOrders()
            ->with(['user', 'subscription'])
            ->whereIn('status', ['validated', 'in_delivery'])
            ->latest()
            ->get();

        $recentDeliveries = $user->deliveries()
            ->with(['order.user'])
            ->where('code_validated', true)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.driver', compact('stats', 'assignedOrders', 'recentDeliveries', 'exchangeRate'));
    }

    public function meals()
    {
        $meals = Meal::withCount('orderItems')->paginate(15);
        $exchangeRate = \App\Models\ExchangeRate::getCurrentRate();
        $categories = \App\Models\Category::all(); // Récupérer toutes les catégories
        return view('admin.meals.index', compact('meals', 'exchangeRate', 'categories')); // Passer les catégories
    }

    public function subscriptions()
    {
        $subscriptions = Subscription::with(['user'])->paginate(15);
        $users = User::all(); // Fetch all users
        return view('admin.subscriptions.index', compact('subscriptions', 'users')); // Pass users to the view
    }

    public function showSubscription(Subscription $subscription)
    {
        return response()->json($subscription);
    }

    public function storeSubscription(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'category_type' => 'required|in:basic,professional,premium',
            'duration_type' => 'required|in:weekly,monthly',
            'unit_price_per_meal_cdf' => 'required|numeric|min:0',
            'package_price_cdf' => 'required|numeric|min:0|lte:unit_price_per_meal_cdf',
            'meal_count' => 'required|integer|min:1',
            'plan_description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,expired,cancelled,pending_validation',
        ]);

        Subscription::create($request->all());

        return redirect()->route('admin.subscriptions')->with('success', 'Abonnement créé avec succès !');
    }

    public function updateSubscription(Request $request, Subscription $subscription)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'category_type' => 'required|in:basic,professional,premium',
            'duration_type' => 'required|in:weekly,monthly',
            'unit_price_per_meal_cdf' => 'required|numeric|min:0',
            'package_price_cdf' => 'required|numeric|min:0|lte:unit_price_per_meal_cdf',
            'meal_count' => 'required|integer|min:1',
            'plan_description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,expired,cancelled,pending_validation',
            'reason' => 'nullable|string',
        ]);

        $subscription->update($request->all());

        return redirect()->route('admin.subscriptions')->with('success', 'Abonnement mis à jour avec succès !');
    }

    public function deleteSubscription(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('admin.subscriptions')->with('success', 'Abonnement supprimé avec succès !');
    }

    // Méthodes pour la gestion des formules d'abonnement (Subscription Plans)
    public function subscriptionPlans()
    {
        $subscriptionPlans = \App\Models\SubscriptionPlan::paginate(15);
        return view('admin.subscription-plans.index', compact('subscriptionPlans'));
    }

    public function storeSubscriptionPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_type' => 'required|in:basic,professional,premium',
            'duration_type' => 'required|in:weekly,monthly',
            'unit_price_per_meal_cdf' => 'required|numeric|min:0',
            'package_price_cdf' => 'required|numeric|min:0|lte:unit_price_per_meal_cdf',
            'meal_count' => 'required|integer|min:1',
            'benefits' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        \App\Models\SubscriptionPlan::create($request->all());

        return redirect()->route('admin.subscription-plans')->with('success', 'Formule d\'abonnement créée avec succès !');
    }

    public function updateSubscriptionPlan(Request $request, \App\Models\SubscriptionPlan $subscriptionPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_type' => 'required|in:basic,professional,premium',
            'duration_type' => 'required|in:weekly,monthly',
            'unit_price_per_meal_cdf' => 'required|numeric|min:0',
            'package_price_cdf' => 'required|numeric|min:0|lte:unit_price_per_meal_cdf',
            'meal_count' => 'required|integer|min:1',
            'benefits' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $subscriptionPlan->update($request->all());

        return redirect()->route('admin.subscription-plans')->with('success', 'Formule d\'abonnement mise à jour avec succès !');
    }

    public function deleteSubscriptionPlan(\App\Models\SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();
        return redirect()->route('admin.subscription-plans')->with('success', 'Formule d\'abonnement supprimée avec succès !');
    }

    public function showSubscriptionPlan(\App\Models\SubscriptionPlan $subscriptionPlan)
    {
        return response()->json($subscriptionPlan);
    }

    public function validateSubscription(Request $request, Subscription $subscription)
    {
        $request->validate([
            'status' => 'required|in:active',
        ]);

        $subscription->update(['status' => $request->status, 'reason' => null]);

        return redirect()->route('admin.subscriptions')->with('success', 'Abonnement validé avec succès !');
    }

    public function rejectSubscription(Request $request, Subscription $subscription)
    {
        $request->validate([
            'status' => 'required|in:cancelled',
            'reason' => 'required|string|min:10',
        ]);

        $subscription->update(['status' => $request->status, 'reason' => $request->reason]);

        return redirect()->route('admin.subscriptions')->with('success', 'Abonnement rejeté avec succès !');
    }

    // Méthodes pour la gestion des utilisateurs
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'role' => 'driver', // Seuls les livreurs peuvent être créés par l'admin
        ]);

        return redirect()->route('admin.users')->with('success', 'Livreur créé avec succès !');
    }

    public function deleteUser(User $user)
    {
        // Empêcher la suppression de l'admin et de l'utilisateur connecté
        if ($user->isAdmin() || $user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Vous ne pouvez pas supprimer un administrateur ou votre propre compte.'], 403);
        }

        $user->delete();
        return response()->json(['success' => true]);
    }

    public function users()
    {
        $users = User::withCount(['orders', 'subscriptions'])->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function profile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('client.profile', compact('user'));
    }

    public function deliveries()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $deliveries = $user->deliveries()
            ->with(['order.user'])
            ->latest()
            ->paginate(15);
        
        return view('driver.deliveries', compact('deliveries'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        Log::info('Client Profile Update Attempt for user: ' . $user->id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|max:2048', // Validation pour la photo de profil (max 2MB)
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('profile_photo')) {
            Log::info('Profile photo file found in request.');
            // Supprimer l'ancienne photo si elle n'est pas l'avatar par défaut
            if ($user->profile_photo_path && $user->profile_photo_path !== 'default-avatar.png') {
                Storage::disk('public')->delete($user->profile_photo_path);
                Log::info('Old profile photo deleted: ' . $user->profile_photo_path);
            }
            // Stocker la nouvelle photo
            $data['profile_photo_path'] = $request->file('profile_photo')->store('profile-photos', 'public');
            Log::info('New profile photo stored at: ' . $data['profile_photo_path']);
        } else {
            Log::info('No profile photo file in request.');
        }

        $user->update($data);
        Log::info('User profile updated for user: ' . $user->id);

        return redirect()->route('client.profile')->with('success', 'Profil mis à jour avec succès !');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('client.profile')->with('success', 'Mot de passe mis à jour avec succès !');
    }

    // Méthodes pour le profil admin
    public function adminProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateAdminProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profil mis à jour avec succès !');
    }

    public function updateAdminPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.profile')->with('success', 'Mot de passe mis à jour avec succès !');
    }

    // Méthodes pour le profil driver
    public function driverProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('driver.profile', compact('user'));
    }

    public function updateDriverProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('driver.profile')->with('success', 'Profil mis à jour avec succès !');
    }

    public function updateDriverPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('driver.profile')->with('success', 'Mot de passe mis à jour avec succès !');
    }

    // Méthodes pour la gestion des repas
    public function storeMeal(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_cdf' => 'required|numeric|min:0',
            'price_usd' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Changer de 'category' à 'category_id'
            'is_available' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('meals', 'public');
        }

        Meal::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_cdf' => $request->price_cdf,
            'price_usd' => $request->price_usd,
            'category_id' => $request->category_id, // Utiliser category_id
            'is_available' => $request->has('is_available'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.meals')->with('success', 'Repas créé avec succès !');
    }

    public function updateMeal(Request $request, Meal $meal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_cdf' => 'required|numeric|min:0',
            'price_usd' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Changer de 'category' à 'category_id'
            'is_available' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $meal->image;
        if ($request->hasFile('image')) {
            if ($meal->image) {
                Storage::disk('public')->delete($meal->image);
            }
            $imagePath = $request->file('image')->store('meals', 'public');
        }

        $meal->update([
            'name' => $request->name,
            'description' => $request->description,
            'price_cdf' => $request->price_cdf,
            'price_usd' => $request->price_usd,
            'category_id' => $request->category_id, // Utiliser category_id
            'is_available' => $request->has('is_available'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.meals')->with('success', 'Repas mis à jour avec succès !');
    }

    public function deleteMeal(Meal $meal)
    {
        // Delete associated image
        if ($meal->image) {
            Storage::disk('public')->delete($meal->image);
        }
        $meal->delete();
        return response()->json(['success' => true]);
    }

    public function showMeal(Meal $meal)
    {
        return response()->json($meal);
    }

    // Méthodes pour la gestion du taux de change
    public function exchangeRates()
    {
        $currentRate = \App\Models\ExchangeRate::getCurrentRate();
        $exchangeRates = \App\Models\ExchangeRate::orderBy('created_at', 'desc')->get();
        
        return view('admin.exchange-rates', compact('currentRate', 'exchangeRates'));
    }

    public function updateExchangeRate(Request $request)
    {
        $request->validate([
            'usd_to_cdf_rate' => 'required|numeric|min:1|max:10000',
        ]);

        // Désactiver l'ancien taux
        \App\Models\ExchangeRate::where('is_active', true)->update(['is_active' => false]);

        // Créer le nouveau taux
        $usdToCdfRate = $request->usd_to_cdf_rate;
        $cdfToUsdRate = 1 / $usdToCdfRate;

        \App\Models\ExchangeRate::create([
            'from_currency' => 'CDF',
            'to_currency' => 'USD',
            'rate' => $cdfToUsdRate,
            'inverse_rate' => $usdToCdfRate,
            'is_active' => true,
            'last_updated' => now(),
        ]);

        return redirect()->route('admin.exchange-rates')->with('success', 'Taux de change mis à jour avec succès !');
    }

    // Méthodes pour afficher le taux de change en lecture seule
    public function clientExchangeRate()
    {
        return view('client.exchange-rate');
    }

    public function driverExchangeRate()
    {
        return view('driver.exchange-rate');
    }

    public function clientSubscriptionPlans()
    {
        $subscriptionPlans = \App\Models\SubscriptionPlan::all();
        return view('client.subscription-plans', compact('subscriptionPlans'));
    }

    public function subscribeToPlan(Request $request)
    {
        $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Vérifier si le client a déjà un abonnement actif
        if ($user->subscriptions()->active()->exists()) {
            return redirect()->route('client.subscription-plans')
                             ->with('error', 'Vous avez déjà un abonnement actif. Veuillez contacter l\'administrateur pour modifier votre abonnement.');
        }

        $plan = \App\Models\SubscriptionPlan::findOrFail($request->subscription_plan_id);

        // Créer un nouvel abonnement pour le client avec le statut en attente de validation
        Subscription::create([
            'user_id' => $user->id,
            'name' => $plan->name,
            'category_type' => $plan->category_type,
            'duration_type' => $plan->duration_type,
            'unit_price_per_meal_cdf' => $plan->unit_price_per_meal_cdf,
            'package_price_cdf' => $plan->package_price_cdf,
            'meal_count' => $plan->meal_count,
            'plan_description' => $plan->description,
            'start_date' => now(), // Date de début à la souscription
            'end_date' => now()->addMonths(1), // Exemple: 1 mois par défaut, l'admin pourra ajuster
            'status' => 'pending_validation',
            'reason' => null, // Aucune raison initiale
        ]);

        return redirect()->route('client.dashboard')
                         ->with('success', 'Votre demande d\'abonnement a été soumise avec succès et est en attente de validation par l\'administrateur.');
    }

    // Méthodes pour la gestion des catégories de repas
    public function categories()
    {
        $categories = Category::withCount('meals')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories')->with('success', 'Catégorie créée avec succès !');
    }

    public function showCategory(Category $category)
    {
        return response()->json($category);
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories')->with('success', 'Catégorie mise à jour avec succès !');
    }

    public function deleteCategory(Category $category)
    {
        // Empêcher la suppression si la catégorie a des repas associés
        if ($category->meals()->count() > 0) {
            return back()->withErrors(['error' => 'Impossible de supprimer la catégorie car elle contient des repas.']);
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Catégorie supprimée avec succès !');
    }
}
