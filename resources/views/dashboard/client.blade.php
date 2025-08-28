@extends('layouts.app')

@section('title', 'Dashboard Client - Green Express')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ Auth::user()->name }} !</h1>
            <p class="text-gray-600">Bienvenue sur votre espace client</p>
        </div>
        <a href="{{ route('orders.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i>Nouvelle Commande
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Commandes</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Commandes En Attente</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Abonnements En Attente</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_subscriptions_count'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Commandes Livrées</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['delivered_orders'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Subscriptions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Commandes Récentes</h3>
                    <a href="{{ route('orders.index') }}" class="text-green-600 hover:text-green-700 text-sm">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">Commande #{{ $order->id }}</p>
                                <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-gray-600">
                                    @if($exchangeRate)
                                        {{ number_format($order->total_amount * $exchangeRate->inverse_rate, 2) }} CDF
                                        <span class="text-xs text-gray-500">($ {{ number_format($order->total_amount, 2) }})</span>
                                    @else
                                        $ {{ number_format($order->total_amount, 2) }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($order->status === 'validated' ? 'bg-blue-100 text-blue-800' : 
                                       ($order->status === 'in_delivery' ? 'bg-orange-100 text-orange-800' : 
                                       ($order->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))) }}">
                                    {{ $order->translated_status }}
                                </span>
                                <div class="mt-2">
                                    <a href="{{ route('orders.show', $order) }}" class="text-green-600 hover:text-green-700 text-sm">
                                        <i class="fas fa-eye mr-1"></i>Voir
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Aucune commande récente</p>
                        <a href="{{ route('orders.create') }}" class="text-green-600 hover:text-green-700 text-sm">
                            Passer votre première commande
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Active Subscriptions -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Abonnements Actifs</h3>
            </div>
            <div class="p-6">
                @if($activeSubscriptions->count() > 0)
                    <div class="space-y-4">
                        @foreach($activeSubscriptions as $subscription)
                        <div class="p-4 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-medium text-gray-900">{{ $subscription->name }} ({{ match($subscription->category_type) { 'basic' => 'Séculier/Basic', 'professional' => 'Professionnel', 'premium' => 'Premium Entreprise', default => ucfirst($subscription->category_type), } }} - {{ match($subscription->duration_type) { 'weekly' => 'Semaine', 'monthly' => 'Mois', default => ucfirst($subscription->duration_type), } }})</h4>
                                <span class="text-lg font-semibold text-green-600">
                                    {{ number_format($subscription->package_price_cdf, 2) }} CDF
                                    @if($exchangeRate)
                                        <span class="text-sm text-gray-500">($ {{ number_format($subscription->package_price_usd, 2) }})</span>
                                    @endif
                                </span>
                            </div>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p>Prix normal: {{ number_format($subscription->unit_price_per_meal_cdf * $subscription->meal_count, 2) }} CDF
                                    @if($exchangeRate)
                                        <span class="text-xs text-gray-500">($ {{ number_format($subscription->unit_price_per_meal_usd * $subscription->meal_count, 2) }})</span>
                                    @endif
                                </p>
                                <p>Économies: {{ number_format($subscription->savings_cdf, 2) }} CDF
                                    @if($exchangeRate)
                                        <span class="text-xs text-gray-500">($ {{ number_format($subscription->savings_usd, 2) }})</span>
                                    @endif
                                </p>
                                <p>Du {{ $subscription->start_date->format('d/m/Y') }} au {{ $subscription->end_date->format('d/m/Y') }}</p>
                                <p>Statut: 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $subscription->isActive() ? 'bg-green-100 text-green-800' : 
                                           ($subscription->isExpiringSoon() ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        @if($subscription->isActive())
                                            Actif ({{ $subscription->days_remaining }} jours restants)
                                        @elseif($subscription->isExpiringSoon())
                                            Expire bientôt ({{ $subscription->days_remaining }} jours restants)
                                        @else
                                            Expiré
                                        @endif
                                    </span>
                                </p>
                                @if($subscription->isExpired() || $subscription->isExpiringSoon())
                                    <div class="mt-3 flex space-x-2">
                                        <a href="{{ route('client.subscription-plans', ['action' => 'renew', 'subscription_id' => $subscription->id]) }}" class="bg-green-500 text-white px-3 py-1 rounded-md text-xs hover:bg-green-600">Reconduire</a>
                                        <a href="{{ route('client.subscription-plans') }}" class="bg-blue-500 text-white px-3 py-1 rounded-md text-xs hover:bg-blue-600">Changer d'abonnement</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Aucun abonnement actif</p>
                        <p class="text-sm text-gray-400">Souscrivez à un abonnement pour bénéficier d'avantages</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pending Subscriptions -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Abonnements en attente de validation</h3>
            </div>
            <div class="p-6">
                @if($pendingSubscriptions->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingSubscriptions as $subscription)
                        <div class="p-4 border border-gray-200 rounded-lg bg-blue-50">
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="font-medium text-blue-900">{{ $subscription->name }} ({{ match($subscription->category_type) { 'basic' => 'Séculier/Basic', 'professional' => 'Professionnel', 'premium' => 'Premium Entreprise', default => ucfirst($subscription->category_type), } }} - {{ match($subscription->duration_type) { 'weekly' => 'Semaine', 'monthly' => 'Mois', default => ucfirst($subscription->duration_type), } }})</h4>
                                <span class="text-lg font-semibold text-blue-600">
                                    {{ number_format($subscription->package_price_cdf, 2) }} CDF
                                    @if($exchangeRate)
                                        <span class="text-sm text-blue-500">($ {{ number_format($subscription->package_price_usd, 2) }})</span>
                                    @endif
                                </span>
                            </div>
                            <div class="text-sm text-blue-800 space-y-1">
                                <p>Prix normal: {{ number_format($subscription->unit_price_per_meal_cdf * $subscription->meal_count, 2) }} CDF
                                    @if($exchangeRate)
                                        <span class="text-xs text-blue-500">($ {{ number_format($subscription->unit_price_per_meal_usd * $subscription->meal_count, 2) }})</span>
                                    @endif
                                </p>
                                <p>Économies: {{ number_format($subscription->savings_cdf, 2) }} CDF
                                    @if($exchangeRate)
                                        <span class="text-xs text-blue-500">($ {{ number_format($subscription->savings_usd, 2) }})</span>
                                    @endif
                                </p>
                                <p>Date de demande: {{ $subscription->created_at->format('d/m/Y') }}</p>
                                <p>Statut: 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-200 text-blue-900">
                                        En attente de validation
                                    </span>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-file-invoice text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Aucune demande d'abonnement en attente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Actions Rapides</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('orders.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-plus text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Nouvelle Commande</p>
                    <p class="text-sm text-gray-500">Commander des plats</p>
                </div>
            </a>
            <a href="{{ route('orders.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-list text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Mes Commandes</p>
                    <p class="text-sm text-gray-500">Voir l'historique</p>
                </div>
            </a>
            <a href="{{ route('client.subscription-plans') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-sync text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Changer d'abonnement</p>
                    <p class="text-sm text-gray-500">Modifier ou souscrire à un plan</p>
                </div>
            </a>
            <a href="{{ route('client.profile') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-user text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Mon Profil</p>
                    <p class="text-sm text-gray-500">Gérer mes informations</p>
                </div>
            </a>
            <a href="{{ route('client.exchange-rate') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-dollar-sign text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Taux de change</p>
                    <p class="text-sm text-gray-500">Voir le taux USD/CDF</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Order Status Guide -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Guide des Statuts</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="flex items-center space-x-3">
                <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                <div>
                    <p class="text-sm font-medium text-gray-900">En attente (commande)</p>
                    <p class="text-xs text-gray-500">Commande en cours de validation</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                <div>
                    <p class="text-sm font-medium text-gray-900">Validée (commande)</p>
                    <p class="text-xs text-gray-500">Commande confirmée par l'admin</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                <div>
                    <p class="text-sm font-medium text-gray-900">En livraison</p>
                    <p class="text-xs text-gray-500">Le livreur est en route</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                <div>
                    <p class="text-sm font-medium text-gray-900">Livrée</p>
                    <p class="text-xs text-gray-500">Commande reçue</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="w-3 h-3 bg-blue-200 rounded-full"></span>
                <div>
                    <p class="text-sm font-medium text-gray-900">En attente (abonnement)</p>
                    <p class="text-xs text-gray-500">Demande d'abonnement en cours de validation par l'administrateur</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
