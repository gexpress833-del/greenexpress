<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 5px;
        }
        .company-info {
            font-size: 12px;
            color: #666;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .client-info, .invoice-info {
            width: 45%;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #4CAF50;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-row {
            font-size: 14px;
            margin-bottom: 5px;
        }
        .grand-total {
            font-size: 16px;
            font-weight: bold;
            color: #4CAF50;
            border-top: 2px solid #4CAF50;
            padding-top: 10px;
        }
        .secure-code {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 20px;
            text-align: center;
        }
        .secure-code-title {
            font-weight: bold;
            color: #4CAF50;
            margin-bottom: 5px;
        }
        .secure-code-value {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="text-align: center; margin-bottom: 10px;">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" alt="Green Express Logo" style="height: 50px; width: auto;">
            @endif
        </div>
        <div class="company-name">GREEN EXPRESS</div>
        <div class="company-info">
            Service de livraison de repas sains<br>
            Tél: <a href="https://wa.me/243972545000" target="_blank" style="color: #333; text-decoration: none;">+243972545000</a><br>
            Email: <a href="mailto:gexpress833@gmail.com" style="color: #333; text-decoration: none;">gexpress833@gmail.com</a>
        </div>
    </div>

    <div class="invoice-details">
        <div class="client-info">
            <div class="section-title">INFORMATIONS CLIENT</div>
            @if($profilePhotoBase64)
                <img src="{{ $profilePhotoBase64 }}" alt="Photo de profil" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;"><br>
            @endif
            <strong>{{ $user->name }}</strong><br>
            {{ $user->address }}<br>
            Tél: <a href="https://wa.me/{{ preg_replace('/^0|\D/', '', $user->phone) }}" target="_blank" style="color: #333; text-decoration: none;">{{ $user->phone }}</a><br>
            Email: <a href="mailto:{{ $user->email }}" style="color: #333; text-decoration: none;">{{ $user->email }}</a>
        </div>
        
        <div class="invoice-info">
            <div class="section-title">DÉTAILS DE LA FACTURE</div>
            <strong>Numéro de facture:</strong> {{ $invoice->invoice_number }}<br>
            <strong>Date:</strong> {{ $invoice->created_at->format('d/m/Y') }}<br>
            <strong>Numéro de commande:</strong> #{{ $order->id }}<br>
            <strong>Type:</strong> {{ $order->type === 'a_l_unite' ? 'À l\'unité' : 'Abonnement' }}<br>
            @if($order->type === 'subscription' && $subscription)
                <strong>Formule:</strong> {{ $subscription->name }} ({{ ucfirst($subscription->category_type) }} - {{ match($subscription->duration_type) { 'weekly' => 'Semaine', 'monthly' => 'Mois', default => ucfirst($subscription->duration_type), } }})<br>
                <strong>Repas inclus:</strong> {{ $subscription->meal_count }}<br>
                <strong>Bénéfices:</strong> {{ $subscription->benefits }}<br>
            @endif
        </div>
    </div>

    @if($order->type === 'a_l_unite')
    <table class="table">
        <thead>
            <tr>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderItems as $item)
            <tr>
                <td>{{ $item->meal->name ?? 'Repas supprimé' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }} CDF</td>
                <td>{{ number_format($item->total_price, 2) }} CDF</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @elseif($order->type === 'subscription' && $subscription)
    <table class="table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Forfait</th>
                <th>Économies</th>
                <th>Prix Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $subscription->name }} ({{ match($subscription->category_type) { 'basic' => 'Séculier/Basic', 'professional' => 'Professionnel', 'premium' => 'Premium Entreprise', default => ucfirst($subscription->category_type), } }} - {{ match($subscription->duration_type) { 'weekly' => 'Semaine', 'monthly' => 'Mois', default => ucfirst($subscription->duration_type), } }})</td>
                <td>{{ number_format($subscription->package_price_cdf, 2) }} CDF</td>
                <td>{{ number_format($subscription->unit_price_per_meal_cdf * $subscription->meal_count - $subscription->package_price_cdf, 2) }} CDF</td>
                <td>{{ number_format($subscription->package_price_cdf, 2) }} CDF</td>
            </tr>
            @if($subscription->description)
            <tr>
                <td colspan="4">
                    <strong>Détails des repas du plan:</strong><br>
                    {!! nl2br($subscription->description) !!}
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif

    <div class="total-section">
        <div class="total-row">
            <strong>Total: {{ number_format($invoice->amount, 2) }} CDF</strong>
        </div>
        @if($exchangeRate && $exchangeRate->rate > 0)
        <div class="total-row">
            <strong>Total (USD): $ {{ number_format($invoice->amount * $exchangeRate->rate, 2) }}</strong>
        </div>
        @endif
    </div>

    <div class="secure-code">
        <div class="secure-code-title">CODE SÉCURISÉ POUR LA LIVRAISON</div>
        <div class="secure-code-value">{{ $invoice->secure_code }}</div>
        <div style="margin-top: 10px; font-size: 11px;">
            Présentez ce code au livreur pour valider votre livraison
        </div>
    </div>

    <div class="footer">
        <p>Merci de votre confiance !</p>
        <p>Green Express - Service de livraison de repas sains</p>
        <p>Cette facture a été générée automatiquement le {{ $invoice->created_at->format('d/m/Y à H:i') }}</p>
    </div>
</body>
</html>
