@extends('layouts.app')

@section('title', 'Détail Commande #' . $order->id . ' - Green Express')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Commande #{{ $order->id }}</h1>
            <p class="text-gray-600">Créée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('orders.index') }}" class="text-green-600 hover:text-green-700">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
            @if($order->invoice && (Auth::user()->isAdmin() || Auth::user()->isClient()))
                <a href="{{ route('orders.invoice.download', $order) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    <i class="fas fa-download mr-2"></i>Télécharger Facture
                </a>
            @endif
        </div>
    </div>

    <!-- Order Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Statut de la Commande</h3>
                <p class="text-sm text-gray-600">Suivi en temps réel</p>
            </div>
            <span class="px-4 py-2 text-sm font-semibold rounded-full 
                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($order->status === 'validated' ? 'bg-blue-100 text-blue-800' : 
                   ($order->status === 'in_delivery' ? 'bg-orange-100 text-orange-800' : 
                   ($order->status === 'delivered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))) }}">
                {{ $order->translated_status }}
            </span>
        </div>
        
        <!-- Status Timeline -->
        <div class="mt-6">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Commande créée</p>
                    <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            
            @if($order->status !== 'pending')
            <div class="flex items-center space-x-4 mt-4">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Commande validée</p>
                    <p class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            @endif
            
            @if($order->status === 'in_delivery' || $order->status === 'delivered')
            <div class="flex items-center space-x-4 mt-4">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">En livraison</p>
                    <p class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            @endif
            
            @if($order->status === 'delivered')
            <div class="flex items-center space-x-4 mt-4">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">Livrée</p>
                    <p class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Order Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations Client</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Nom:</span>
                    <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Email:</span>
                    <p class="text-sm text-gray-900">{{ $order->user->email }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Téléphone:</span>
                    <p class="text-sm text-gray-900">{{ $order->user->phone }}</p>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Adresse de livraison:</span>
                    <p class="text-sm text-gray-900">{{ $order->delivery_address }}</p>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Détails de la Commande</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Type:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $order->type === 'subscription' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $order->type === 'single' ? 'À l\'unité' : 'Abonnement' }}
                    </span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Montant total:</span>
                    <p class="text-lg font-semibold text-green-600">{{ number_format($order->total_amount, 2) }} CDF</p>
                </div>
                @if($order->subscription)
                <div>
                    <span class="text-sm font-medium text-gray-500">Abonnement:</span>
                    <p class="text-sm text-gray-900">{{ $order->subscription->name }} ({{ match($order->subscription->category_type) { 'basic' => 'Séculier/Basic', 'professional' => 'Professionnel', 'premium' => 'Premium Entreprise', default => ucfirst($order->subscription->category_type), } }} - {{ match($order->subscription->duration_type) { 'weekly' => 'Semaine', 'monthly' => 'Mois', default => ucfirst($order->subscription->duration_type), } }})</p>
                </div>
                @endif
                @if($order->driver)
                <div>
                    <span class="text-sm font-medium text-gray-500">Livreur:</span>
                    <p class="text-sm text-gray-900">{{ $order->driver->name }}</p>
                </div>
                @endif
                @if($order->notes)
                <div>
                    <span class="text-sm font-medium text-gray-500">Notes:</span>
                    <p class="text-sm text-gray-900">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Items -->
    @if($order->orderItems->count() > 0)
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Articles Commandés</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Article
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Quantité
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prix unitaire
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $item->meal->name ?? 'Repas supprimé' }}</div>
                                <div class="text-sm text-gray-500">{{ $item->meal->description ?? 'N/A' }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($item->unit_price, 2) }} CDF
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ number_format($item->total_price, 2) }} CDF
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Invoice Information -->
    @if($order->invoice && (Auth::user()->isAdmin() || Auth::user()->isClient()))
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations Facture</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <span class="text-sm font-medium text-gray-500">Numéro de facture:</span>
                <p class="text-sm text-gray-900">{{ $order->invoice->invoice_number }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">Code sécurisé:</span>
                <p class="text-sm font-mono text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $order->invoice->secure_code }}</p>
            </div>
            <div>
                <span class="text-sm font-medium text-gray-500">WhatsApp envoyé:</span>
                <p class="text-sm text-gray-900">
                    @if($order->invoice->whatsapp_sent)
                        <span class="text-green-600">Oui</span>
                    @else
                        <span class="text-red-600">Non</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Admin Actions -->
    @if(Auth::user()->isAdmin())
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Actions Administrateur</h3>
        <div class="flex space-x-4">
            @if($order->status === 'pending')
                <form method="POST" action="{{ route('orders.validate', $order) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        <i class="fas fa-check mr-2"></i>Valider la Commande
                    </button>
                </form>
            @endif
            
            @if($order->status === 'validated' && !$order->driver_id)
                <form method="POST" action="{{ route('orders.assign-driver', $order) }}" class="inline">
                    @csrf
                    <select name="driver_id" class="border border-gray-300 rounded-md px-3 py-2 mr-2">
                        <option value="">Sélectionner un livreur</option>
                        @foreach(\App\Models\User::drivers()->get() as $driver)
                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-user-plus mr-2"></i>Assigner un Livreur
                    </button>
                </form>
            @endif
        </div>
    </div>
    @endif

    <!-- Driver Actions -->
    @if(Auth::user()->isDriver() && $order->driver_id === Auth::id())
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Actions Livreur</h3>
        
        @if($order->status === 'validated')
            <form method="POST" action="{{ route('orders.start-delivery', $order) }}" class="mb-4">
                @csrf
                <button type="submit" class="bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700">
                    <i class="fas fa-truck mr-2"></i>Démarrer la Livraison
                </button>
            </form>
        @endif
        
        @if($order->status === 'in_delivery')
            <form method="POST" action="{{ route('orders.validate-delivery', $order) }}" class="space-y-4">
                @csrf
                <div>
                    <label for="secure_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Code Sécurisé du Client
                    </label>
                    <input type="text" name="secure_code" id="secure_code" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-green-500 focus:border-green-500"
                           placeholder="Entrez le code fourni par le client">
                </div>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i>Valider la Livraison
                </button>
            </form>
        @endif
    </div>
    @endif
</div>
@endsection
