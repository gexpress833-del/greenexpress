@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon Profil - Administrateur</h1>
            <p class="text-gray-600 mt-2">Gérez vos informations personnelles et vos préférences</p>
        </div>

        <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations personnelles -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Informations personnelles</h2>
                    
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Adresse email</label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                                <input type="tel" id="phone" name="phone" value="{{ auth()->user()->phone }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <textarea id="address" name="address" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">{{ auth()->user()->address }}</textarea>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Mettre à jour le profil
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Changement de mot de passe -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Changer le mot de passe</h2>
                    
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                                <input type="password" id="current_password" name="current_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Paramètres système -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Paramètres système</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">Notifications WhatsApp</h3>
                                <p class="text-sm text-gray-600">Activer les notifications automatiques</p>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="whatsapp_notifications" name="whatsapp_notifications" 
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" checked>
                                <label for="whatsapp_notifications" class="ml-2 text-sm text-gray-700">Activé</label>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">Génération automatique d'invoices</h3>
                                <p class="text-sm text-gray-600">Créer automatiquement les factures PDF</p>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="auto_invoice" name="auto_invoice" 
                                       class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded" checked>
                                <label for="auto_invoice" class="ml-2 text-sm text-gray-700">Activé</label>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div>
                                <h3 class="font-medium text-gray-900">Mode maintenance</h3>
                                <p class="text-sm text-gray-600">Restreindre l'accès aux clients</p>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="maintenance_mode" name="maintenance_mode" 
                                       class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                <label for="maintenance_mode" class="ml-2 text-sm text-gray-700">Désactivé</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="button" class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            Sauvegarder les paramètres
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Statistiques rapides -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistiques globales</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Commandes totales</span>
                            <span class="font-semibold text-gray-900">{{ \App\Models\Order::count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Clients actifs</span>
                            <span class="font-semibold text-gray-900">{{ \App\Models\User::clients()->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Livreurs</span>
                            <span class="font-semibold text-gray-900">{{ \App\Models\User::drivers()->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Chiffre d'affaires</span>
                            <span class="font-semibold text-gray-900">$ {{ number_format(\App\Models\Order::where('status', '!=', 'cancelled')->sum('total_amount'), 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Admin depuis</span>
                            <span class="font-semibold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.dashboard') }}" class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-md hover:bg-green-700 transition duration-200">
                            Tableau de bord
                        </a>
                        
                        <a href="{{ route('orders.index') }}" class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                            Gérer les commandes
                        </a>
                        
                        <a href="{{ route('admin.meals') }}" class="block w-full bg-purple-600 text-white text-center px-4 py-2 rounded-md hover:bg-purple-700 transition duration-200">
                            Gérer les repas
                        </a>
                        
                        <a href="{{ route('admin.users') }}" class="block w-full bg-orange-600 text-white text-center px-4 py-2 rounded-md hover:bg-orange-700 transition duration-200">
                            Gérer les utilisateurs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
