@extends('layouts.app')

@section('title', 'Dashboard Livreur - Green Express')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ Auth::user()->name }} !</h1>
            <p class="text-gray-600">Espace livreur - Gestion des livraisons</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">{{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-truck text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Livraisons Assignées</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['assigned_orders'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Livraisons Terminées</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['completed_deliveries'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">En Cours</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['pending_deliveries'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Livraisons Assignées</h3>
        </div>
        <div class="p-6">
            @if($assignedOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($assignedOrders as $order)
                    <div class="border border-gray-200 rounded-lg p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">Commande #{{ $order->id }}</h4>
                                <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $order->delivery_address }}</p>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $order->status === 'validated' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ $order->translated_status }}
                                </span>
                                <p class="text-sm text-gray-600 mt-1">
                                    @if($exchangeRate)
                                        {{ number_format($order->total_amount * $exchangeRate->inverse_rate, 2) }} CDF
                                        <span class="text-xs text-gray-500">($ {{ number_format($order->total_amount, 2) }})</span>
                                    @else
                                        $ {{ number_format($order->total_amount, 2) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Client</p>
                                <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-600">{{ $order->user->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Type de commande</p>
                                <p class="text-sm text-gray-900">{{ ucfirst($order->type) }}</p>
                                @if($order->subscription)
                                    <p class="text-sm text-gray-600">{{ ucfirst($order->subscription->type) }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('orders.show', $order) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                                <i class="fas fa-eye mr-2"></i>Voir Détails
                            </a>
                            
                            @if($order->status === 'validated')
                                <form method="POST" action="{{ route('orders.start-delivery', $order) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700 text-sm">
                                        <i class="fas fa-truck mr-2"></i>Démarrer Livraison
                                    </button>
                                </form>
                            @endif
                            
                            @if($order->status === 'in_delivery')
                                <button onclick="showDeliveryValidation({{ $order->id }})" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">
                                    <i class="fas fa-check mr-2"></i>Valider Livraison
                                </button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-truck text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucune livraison assignée</p>
                    <p class="text-sm text-gray-400">Vous recevrez des notifications quand de nouvelles commandes vous seront assignées</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Deliveries -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Livraisons Récentes</h3>
                <a href="{{ route('driver.deliveries') }}" class="text-green-600 hover:text-green-700 text-sm">
                    Voir tout
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($recentDeliveries->count() > 0)
                <div class="space-y-4">
                    @foreach($recentDeliveries as $delivery)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-900">Commande #{{ $delivery->order->id }}</p>
                            <p class="text-sm text-gray-600">{{ $delivery->order->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $delivery->delivery_time->format('d/m/Y H:i') }}</p>
                            <p class="text-sm text-gray-600">
                                @if($exchangeRate)
                                    {{ number_format($delivery->order->total_amount * $exchangeRate->inverse_rate, 2) }} CDF
                                    <span class="text-xs text-gray-500">($ {{ number_format($delivery->order->total_amount, 2) }})</span>
                                @else
                                    $ {{ number_format($delivery->order->total_amount, 2) }}
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Livrée
                            </span>
                            <div class="mt-2">
                                <a href="{{ route('orders.show', $delivery->order) }}" class="text-green-600 hover:text-green-700 text-sm">
                                    <i class="fas fa-eye mr-1"></i>Voir
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-history text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucune livraison récente</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Actions Rapides</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('orders.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-list text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Mes Livraisons</p>
                    <p class="text-sm text-gray-500">Voir toutes les livraisons assignées</p>
                </div>
            </a>
            <a href="{{ route('driver.deliveries') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <i class="fas fa-history text-green-600 mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Historique</p>
                    <p class="text-sm text-gray-500">Voir l'historique des livraisons</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Delivery Instructions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Instructions de Livraison</h3>
        <div class="space-y-4">
            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                <div>
                    <p class="font-medium text-gray-900">Récupérer la commande</p>
                    <p class="text-sm text-gray-600">Récupérez la commande validée auprès de l'équipe</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                <div>
                    <p class="font-medium text-gray-900">Démarrer la livraison</p>
                    <p class="text-sm text-gray-600">Cliquez sur "Démarrer Livraison" dans l'interface</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                <div>
                    <p class="font-medium text-gray-900">Livrer au client</p>
                    <p class="text-sm text-gray-600">Remettez la commande au client à l'adresse indiquée</p>
                </div>
            </div>
            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold">4</div>
                <div>
                    <p class="font-medium text-gray-900">Valider avec le code</p>
                    <p class="text-sm text-gray-600">Demandez le code sécurisé au client et validez la livraison</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delivery Validation Modal -->
<div id="deliveryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Valider la Livraison</h3>
            </div>
            <form id="deliveryForm" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label for="secure_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Code Sécurisé du Client
                    </label>
                    <input type="text" name="secure_code" id="secure_code" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-green-500 focus:border-green-500"
                           placeholder="Entrez le code fourni par le client">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideDeliveryValidation()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Valider
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showDeliveryValidation(orderId) {
    const modal = document.getElementById('deliveryModal');
    const form = document.getElementById('deliveryForm');
    form.action = `/orders/${orderId}/validate-delivery`;
    modal.classList.remove('hidden');
}

function hideDeliveryValidation() {
    const modal = document.getElementById('deliveryModal');
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deliveryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeliveryValidation();
    }
});
</script>
@endsection
