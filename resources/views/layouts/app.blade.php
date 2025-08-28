<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Green Express')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-green-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Green Express Logo" class="h-10 w-auto mr-2 rounded-full ring-2 ring-white"> <!-- Ajustement de la taille et ajout d'une bordure -->
                        <span class="text-white font-bold text-xl">Green Express</span>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-white text-sm">{{ Auth::user()->name }}</span>
                            <span class="text-green-200 text-xs px-2 py-1 rounded-full bg-green-700">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-white hover:text-green-200 text-sm">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Déconnexion
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="flex">
        @auth
            <!-- Sidebar -->
            <div class="w-64 bg-white shadow-lg min-h-screen">
                <div class="p-4">
                    <nav class="space-y-2">
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-shopping-cart mr-3"></i>
                                Commandes
                            </a>
                            <a href="{{ route('admin.meals') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-utensils mr-3"></i>
                                Plats
                            </a>
                            <a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-tags mr-3"></i>
                                Catégories
                            </a>
                            <a href="{{ route('admin.subscriptions') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-calendar-alt mr-3"></i>
                                Abonnements
                            </a>
                            <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-users mr-3"></i>
                                Utilisateurs
                            </a>
                            <a href="{{ route('admin.exchange-rates') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-exchange-alt mr-3"></i>
                                Taux de change
                            </a>
                            <a href="{{ route('admin.profile') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-user mr-3"></i>
                                Mon Profil
                            </a>
                        @elseif(Auth::user()->isClient())
                            <a href="{{ route('client.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-shopping-cart mr-3"></i>
                                Mes Commandes
                            </a>
                            <a href="{{ route('orders.create') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-plus mr-3"></i>
                                Nouvelle Commande
                            </a>
                            <a href="{{ route('client.profile') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-user mr-3"></i>
                                Mon Profil
                            </a>
                            <a href="{{ route('client.exchange-rate') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-exchange-alt mr-3"></i>
                                Taux de change
                            </a>
                            <a href="{{ route('client.subscription-plans') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-calendar-check mr-3"></i>
                                Formules d'Abonnement
                            </a>
                        @elseif(Auth::user()->isDriver())
                            <a href="{{ route('driver.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-truck mr-3"></i>
                                Mes Livraisons
                            </a>
                            <a href="{{ route('driver.deliveries') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-history mr-3"></i>
                                Historique
                            </a>
                            <a href="{{ route('driver.profile') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-user mr-3"></i>
                                Mon Profil
                            </a>
                            <a href="{{ route('driver.exchange-rate') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-md">
                                <i class="fas fa-exchange-alt mr-3"></i>
                                Taux de change
                            </a>
                        @endif
                    </nav>
                </div>
            </div>
        @endauth

        <!-- Main Content -->
        <div class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Section 1: À propos de Green Express -->
            <div>
                <h4 class="text-lg font-semibold text-green-400 mb-4">À propos de Green Express</h4>
                <p class="text-gray-400 text-sm">
                    Nous proposons un service de livraison express de repas sains, directement sur votre lieu de travail ou à l'endroit où vous vous trouvez.
                </p>
            </div>

            <!-- Section 2: Contact -->
            <div>
                <h4 class="text-lg font-semibold text-green-400 mb-4">Contact</h4>
                <ul class="space-y-2 text-sm">
                    <li><i class="fas fa-phone-alt mr-2 text-green-500"></i> Tél: <a href="https://wa.me/243972545000" target="_blank" class="text-gray-400 hover:text-green-400">+243972545000</a></li>
                    <li><i class="fas fa-envelope mr-2 text-green-500"></i> Email: <a href="mailto:gexpress833@gmail.com" class="text-gray-400 hover:text-green-400">gexpress833@gmail.com</a></li>
                    <li><i class="fas fa-map-marker-alt mr-2 text-green-500"></i> Catégorie: Service Local</li>
                </ul>
            </div>

            <!-- Section 3: Horaires -->
            <div>
                <h4 class="text-lg font-semibold text-green-400 mb-4">Horaires d'Ouverture</h4>
                <p class="text-gray-400 text-sm">
                    Du Lundi au Vendredi: 06h30 - 15h00
                </p>
            </div>
        </div>
        <div class="text-center text-gray-500 text-xs mt-8">
            &copy; {{ date('Y') }} Green Express. Tous droits réservés.
        </div>
    </footer>
</body>
</html>
