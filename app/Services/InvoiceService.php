<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; // Add this line
use Illuminate\Support\Facades\Log; // Add this line

class InvoiceService
{
    public function generateInvoice(Order $order)
    {
        // Générer un numéro de facture unique
        $invoiceNumber = 'INV-' . date('Y') . '-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
        
        // Générer un code sécurisé unique
        $secureCode = $this->generateSecureCode();
        
        // Créer la facture
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => $invoiceNumber,
            'secure_code' => $secureCode,
            'amount' => $order->total_amount,
        ]);

        // Générer le PDF
        $pdfPath = $this->generatePDF($invoice);
        
        // Mettre à jour le chemin du PDF
        $invoice->update(['pdf_path' => $pdfPath]);

        return $invoice;
    }

    protected function generateSecureCode()
    {
        do {
            $code = strtoupper(Str::random(8)) . '-' . strtoupper(Str::random(4));
        } while (Invoice::where('secure_code', $code)->exists());

        return $code;
    }

    protected function generatePDF(Invoice $invoice)
    {
        $order = $invoice->order;
        $user = $order->user;
        $orderItems = $order->orderItems; // Sera vide pour les commandes d'abonnement
        $subscription = null;
        if ($order->type === 'subscription' && $order->subscription) {
            $subscription = $order->subscription;
        }
        $exchangeRate = \App\Models\ExchangeRate::active()->first();

        // Encoder le logo en Base64
        $logoBase64 = $this->getImageBase64(public_path('images/logo.jpg'));

        // Encoder la photo de profil de l'utilisateur en Base64
        $profilePhotoBase64 = null;
        if ($user->profile_photo_path) {
            // Assurez-vous que le chemin est correct pour le stockage public
            $profilePhotoPath = Storage::disk('public')->path($user->profile_photo_path);
            $profilePhotoBase64 = $this->getImageBase64($profilePhotoPath);
        }

        $data = [
            'invoice' => $invoice,
            'order' => $order,
            'user' => $user,
            'orderItems' => $orderItems,
            'subscription' => $subscription, // Passer l'objet abonnement à la vue
            'exchangeRate' => $exchangeRate,
            'logoBase64' => $logoBase64, // Passer l'image Base64
            'profilePhotoBase64' => $profilePhotoBase64, // Passer la photo de profil Base64
        ];

        $pdf = PDF::loadView('pdfs.invoice', $data);
        
        $filename = 'invoices/' . $invoice->invoice_number . '.pdf';
        Storage::disk('invoices')->put($filename, $pdf->output()); // Store in 'invoices' disk

        return $filename;
    }

    public function downloadInvoice(Invoice $invoice)
    {
        if (!$invoice->pdf_path || !Storage::disk('invoices')->exists($invoice->pdf_path)) {
            // Regenerate if not found or path is missing
            $this->generatePDF($invoice);
        }

        // Get the full path for download
        return Storage::disk('invoices')->path($invoice->pdf_path);
    }

    /**
     * Encode une image en Base64 pour l'intégration dans le PDF.
     */
    public function getImageBase64(string $path): ?string
    {
        Log::info('Attempting to get image Base64 for path: ' . $path);
        if (!file_exists($path)) {
            Log::error('Image file not found: ' . $path);
            return null;
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        if ($data === false) {
            Log::error('Failed to read image file contents: ' . $path);
            return null;
        }

        $base64 = base64_encode($data);
        Log::info('Image Base64 generated. Length: ' . strlen($base64));

        return 'data:image/' . $type . ';base64,' . $base64;
    }
}
