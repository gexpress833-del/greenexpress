<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class WhatsAppService
{
    protected $token;
    protected $phoneNumberId;
    protected $baseUrl = 'https://graph.facebook.com/v18.0';

    public function __construct()
    {
        $this->token = config('services.whatsapp.token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
    }

    public function sendMessage($phoneNumber, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/' . $this->phoneNumberId . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $phoneNumber,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'phone' => $phoneNumber,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('WhatsApp message failed', [
                    'phone' => $phoneNumber,
                    'response' => $response->json()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp service error', [
                'message' => $e->getMessage(),
                'phone' => $phoneNumber
            ]);
            return false;
        }
    }

    public function sendInvoice($phoneNumber, $invoice, $pdfPath)
    {
        try {
            // Envoyer le message avec le code sécurisé
            $message = "Votre commande a été validée !\n\n";
            $message .= "Code sécurisé: " . $invoice->secure_code . "\n";
            $message .= "Montant: " . number_format($invoice->amount, 2) . " $\n"; // Change € to $
            $message .= "Numéro de facture: " . $invoice->invoice_number . "\n\n";
            $message .= "Présentez ce code au livreur pour valider votre livraison.";

            $this->sendMessage($phoneNumber, $message);

            // Générer une URL signée temporaire pour le PDF
            $signedUrl = URL::temporarySignedRoute(
                'invoice.download.signed',
                now()->addMinutes(30), // L'URL sera valide pendant 30 minutes
                ['invoice' => $invoice->id]
            );

            // Envoyer le PDF de la facture via l'URL signée
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/' . $this->phoneNumberId . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $phoneNumber,
                'type' => 'document',
                'document' => [
                    'link' => $signedUrl,
                    'caption' => 'Facture - ' . $invoice->invoice_number
                ]
            ]);

            if ($response->successful()) {
                $invoice->markAsSent();
                return true;
            }

            Log::error('WhatsApp document message failed', [
                'phone' => $phoneNumber,
                'response' => $response->json()
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp invoice error', [
                'message' => $e->getMessage(),
                'invoice_id' => $invoice->id
            ]);
            return false;
        }
    }

    public function sendDeliveryNotification($phoneNumber, $order)
    {
        $message = "Votre commande est en cours de livraison !\n\n";
        $message .= "Numéro de commande: #" . $order->id . "\n";
        $message .= "Adresse: " . $order->delivery_address . "\n\n";
        $message .= "Préparez votre code sécurisé pour la validation.";

        return $this->sendMessage($phoneNumber, $message);
    }

    public function sendDeliveryCompleted($phoneNumber, $order)
    {
        $message = "Livraison terminée avec succès !\n\n";
        $message .= "Numéro de commande: #" . $order->id . "\n";
        $message .= "Merci de votre confiance !";

        return $this->sendMessage($phoneNumber, $message);
    }
}
