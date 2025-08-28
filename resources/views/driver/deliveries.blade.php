@extends('layouts.app')

@section('title', 'Mes Livraisons - Green Express')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mes Livraisons</h1>
            <p class="text-gray-600 mt-2">Gérez et suivez vos livraisons assignées</p>
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau des Livraisons -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Commande #
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Adresse de Livraison
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut de la Commande
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Heure de Livraison
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($deliveries as $delivery)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $delivery->order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $delivery->order->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $delivery->order->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $delivery->order->delivery_address }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $delivery->order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($delivery->order->status === 'validated' ? 'bg-blue-100 text-blue-800' : 
                                           ($delivery->order->status === 'in_delivery' ? 'bg-orange-100 text-orange-800' : 
                                           ($delivery->order->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))) }}">
                                        {{ ucfirst($delivery->order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $delivery->delivery_time ? $delivery->delivery_time->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('orders.show', $delivery->order) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-eye"></i> Voir Commande
                                    </a>
                                    @if($delivery->order->status === 'in_delivery' && !$delivery->code_validated)
                                        <button onclick="showDeliveryValidation({{ $delivery->order->id }})" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm">
                                            <i class="fas fa-check mr-2"></i>Valider Livraison
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Aucune livraison trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($deliveries->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $deliveries->links() }}
                </div>
            @endif
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
