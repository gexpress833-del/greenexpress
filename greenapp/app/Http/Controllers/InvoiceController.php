<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF; // Assuming you are using a facade for DOMPDF

class InvoiceController extends Controller
{
    public function generateInvoice($orderId)
    {
        $order = Order::findOrFail($orderId);
        $invoice = new Invoice();
        
        // Generate a unique code for the invoice
        $invoice->code = (string) \Str::uuid();
        $invoice->client_name = $order->user->name;
        $invoice->order_details = $order->details; // Assuming details is a property of Order
        $invoice->amount = $order->total; // Assuming total is a property of Order
        $invoice->subscription_type = $order->subscription ? $order->subscription->type : null; // Assuming subscription is a relation
        $invoice->save();

        // Generate PDF
        $pdf = PDF::loadView('invoices.invoice', compact('invoice'));
        $pdfPath = 'invoices/invoice_' . $invoice->code . '.pdf';
        Storage::put($pdfPath, $pdf->output());

        // Send invoice via WhatsApp (pseudo code)
        // $this->sendInvoiceToClient($order->user->whatsapp_number, $pdfPath, $invoice->code);

        return response()->json(['message' => 'Invoice generated successfully', 'invoice_code' => $invoice->code]);
    }

    public function sendInvoiceToClient($whatsappNumber, $pdfPath, $invoiceCode)
    {
        // Logic to send the invoice PDF and code via WhatsApp API
    }
}