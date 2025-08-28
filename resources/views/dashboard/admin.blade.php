@extends('layouts.app')

@section('title', 'Dashboard Admin - Green Express')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Administrateur</h1>
        <div class="text-sm text-gray-500">
            {{ now()->format('d/m/Y H:i') }}
        </div>
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
                    <p class="text-sm font-medium text-gray-600">En Attente</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-euro-sign text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Revenus Totaux</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        @if($stats['total_revenue_cdf'])
                            {{ number_format($stats['total_revenue_cdf'], 2) }} CDF
                            @if($exchangeRate)
                                <span class="text-sm text-gray-500">($ {{ number_format($stats['total_revenue_usd'], 2) }})</span>
                            @endif
                        @else
                            $ {{ number_format($stats['total_revenue_usd'], 2) }}
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-truck text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Livraisons Validées</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_deliveries'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats & Monthly Revenue Chart -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6 col-span-2">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Revenus Mensuels ({{ date('Y') }})</h3>
            <div class="space-y-3">
                @forelse($monthlyRevenue as $revenue)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">{{ Carbon\Carbon::createFromDate(null, $revenue->month)->locale('fr')->monthName }}</span>
                        <span class="text-sm font-medium text-gray-900">$ {{ number_format($revenue->revenue, 2) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Aucun revenu pour cette année.</p>
                @endforelse
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statut des Commandes</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Validées</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['validated_orders'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">En Livraison</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['in_delivery_orders'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Livrées</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['delivered_orders'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriptions & Team Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Abonnements</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Actifs</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['active_subscriptions'] }}</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Équipe</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Livreurs</span>
                    <span class="text-sm font-medium text-gray-900">{{ $stats['total_drivers'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Commandes Récentes</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $order->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $order->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $order->type === 'subscription' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($order->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @if($exchangeRate)
                                {{ number_format($order->total_amount * $exchangeRate->inverse_rate, 2) }} CDF
                                <span class="text-xs text-gray-500">($ {{ number_format($order->total_amount, 2) }})</span>
                            @else
                                $ {{ number_format($order->total_amount, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($order->status === 'validated' ? 'bg-blue-100 text-blue-800' : 
                                   ($order->status === 'in_delivery' ? 'bg-orange-100 text-orange-800' : 
                                   ($order->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))) }}">
                                {{ $order->translated_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Actions Rapides</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('orders.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-shopping-cart text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Gérer les Commandes</p>
                    <p class="text-sm text-gray-500">Voir et traiter toutes les commandes</p>
                </div>
            </a>
            <a href="{{ route('admin.meals') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-utensils text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Gérer le Menu</p>
                    <p class="text-sm text-gray-500">Ajouter ou modifier les plats</p>
                </div>
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-users text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Gérer les Utilisateurs</p>
                    <p class="text-sm text-gray-500">Voir tous les utilisateurs</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
