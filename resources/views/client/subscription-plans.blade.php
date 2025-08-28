@extends('layouts.app')

@section('title', 'Choisir un Abonnement - Green Express')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Choisissez votre Formule d'Abonnement</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($subscriptionPlans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($subscriptionPlans as $plan)
                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-between border-t-4 @if($plan->category_type === 'basic') border-gray-500 @elseif($plan->category_type === 'professional') border-blue-500 @else border-purple-500 @endif">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan->name }}</h2>
                            <p class="text-gray-600 mb-4">{{ $plan->benefits }}</p>
                            <ul class="list-disc list-inside text-gray-700 mb-4 space-y-1">
                                <li><span class="font-semibold">Catégorie:</span> {{ match($plan->category_type) {
                                    'basic' => 'Séculier/Basic',
                                    'professional' => 'Professionnel',
                                    'premium' => 'Premium Entreprise',
                                    default => ucfirst($plan->category_type),
                                } }}</li>
                                <li><span class="font-semibold">Durée:</span> {{ match($plan->duration_type) {
                                    'weekly' => 'Semaine',
                                    'monthly' => 'Mois',
                                    default => ucfirst($plan->duration_type),
                                } }}</li>
                                <li><span class="font-semibold">Repas inclus:</span> {{ $plan->meal_count }}</li>
                                <li><span class="font-semibold">Prix Unitaire par Repas:</span> {{ number_format($plan->unit_price_per_meal_cdf, 0, ',', '.') }} CDF</li>
                                <li><span class="font-semibold">Prix du Forfait:</span> <span class="text-green-600 font-semibold">{{ number_format($plan->package_price_cdf, 0, ',', '.') }} CDF</span></li>
                                <li><span class="font-semibold">Économies par Forfait:</span> {{ number_format($plan->unit_price_per_meal_cdf * $plan->meal_count - $plan->package_price_cdf, 0, ',', '.') }} CDF</li>
                            </ul>
                            <div class="mt-4">
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">Description des Repas</h4>
                                <p class="text-gray-700 text-sm leading-relaxed">{!! $plan->description !!}</p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <form action="{{ route('client.subscribe') }}" method="POST">
                                @csrf
                                <input type="hidden" name="subscription_plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-semibold">
                                    Souscrire à cet abonnement
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg shadow-md">
                <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Aucune formule d'abonnement disponible pour le moment.</p>
                <p class="text-gray-400 mt-2">Revenez plus tard pour découvrir nos offres !</p>
            </div>
        @endif
    </div>
</div>
@endsection
