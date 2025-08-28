@extends('layouts.app')

@section('title', 'Commandes - Green Express')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">
            @if(Auth::user()->isAdmin())
                Toutes les Commandes
            @elseif(Auth::user()->isClient())
                Mes Commandes
            @else
                Mes Livraisons
            @endif
        </h1>
        @if(Auth::user()->isClient())
            <a href="{{ route('orders.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i>Nouvelle Commande
            </a>
        @endif
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Tous</option>
                    <option value="pending">En attente</option>
                    <option value="validated">Validée</option>
                    <option value="in_delivery">En livraison</option>
                    <option value="delivered">Livrée</option>
                    <option value="cancelled">Annulée</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Tous</option>
                    <option value="a_l_unite">Plat unique</option>
                    <option value="subscription">Abonnement</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div class="flex items-end">
                <button class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    <i class="fas fa-search mr-2"></i>Filtrer
                </button>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        @if(Auth::user()->isAdmin())
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        @if(Auth::user()->isAdmin())
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Livreur
                            </th>
                        @endif
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $order->id }}
                        </td>
                        @if(Auth::user()->isAdmin())
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->user->name }}
                            </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $order->type === 'subscription' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $order->type === 'a_l_unite' ? 'À l\'unité' : 'Abonnement' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($order->total_amount, 2) }} CDF
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($order->status === 'validated' ? 'bg-blue-100 text-blue-800' : 
                                   ($order->status === 'in_delivery' ? 'bg-orange-100 text-orange-800' : 
                                   ($order->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))) }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        @if(Auth::user()->isAdmin())
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->driver ? $order->driver->name : 'Non assigné' }}
                            </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('orders.show', $order) }}" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->isAdmin() && $order->status === 'pending')
                                    <form method="POST" action="{{ route('orders.validate', $order) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                @if(Auth::user()->isDriver() && $order->status === 'validated' && $order->driver_id === Auth::id())
                                    <form method="POST" action="{{ route('orders.start-delivery', $order) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-orange-600 hover:text-orange-900">
                                            <i class="fas fa-truck"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isAdmin() ? 8 : 6 }}" class="px-6 py-4 text-center text-gray-500">
                            Aucune commande trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
