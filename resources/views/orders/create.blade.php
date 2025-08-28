@extends('layouts.app')

@section('title', 'Nouvelle Commande - Green Express')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Nouvelle Commande</h1>
        <a href="{{ route('orders.index') }}" class="text-green-600 hover:text-green-700">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux commandes
        </a>
    </div>

    <form method="POST" action="{{ route('orders.store') }}" class="space-y-6">
        @csrf
        
        <!-- Order Type Selection -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Type de Commande</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="relative">
                    <input type="radio" name="type" value="single" class="sr-only" checked>
                    <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors">
                        <div class="flex items-center">
                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3"></div>
                            <div>
                                <h4 class="font-medium text-gray-900">Plat Unique</h4>
                                <p class="text-sm text-gray-500">Commander un ou plusieurs plats</p>
                            </div>
                        </div>
                    </div>
                </label>
                
                <label class="relative">
                    <input type="radio" name="type" value="subscription" class="sr-only">
                    <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors">
                        <div class="flex items-center">
                            <div class="w-4 h-4 border-2 border-gray-300 rounded-full mr-3"></div>
                            <div>
                                <h4 class="font-medium text-gray-900">Abonnement</h4>
                                <p class="text-sm text-gray-500">Utiliser un abonnement actif</p>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Meals Selection (for single orders) -->
        <div id="meals-section" class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Sélection des Plats</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($meals as $meal)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="font-medium text-gray-900">{{ $meal->name }}</h4>
                        <span class="text-lg font-semibold text-green-600" data-price-cdf="{{ $meal->price_cdf }}">
                            {{ $meal->formatted_price_cdf }}
                            @if($exchangeRate && $exchangeRate->rate > 0)
                                <span class="text-sm text-gray-500">($ {{ $meal->formatted_price_usd }})</span>
                            @endif
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">{{ $meal->description }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500 uppercase">{{ $meal->category }}</span>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300" onclick="decrementQuantity({{ $meal->id }})">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <input type="number" name="meals[{{ $meal->id }}][quantity]" value="0" min="0" max="10" class="w-12 text-center border border-gray-300 rounded" readonly>
                            <button type="button" class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center hover:bg-green-600" onclick="incrementQuantity({{ $meal->id }})">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="meals[{{ $meal->id }}][meal_id]" value="{{ $meal->id }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Subscription Selection (for subscription orders) -->
        <div id="subscription-section" class="bg-white rounded-lg shadow p-6 hidden">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Sélection d'Abonnement</h3>
            
            @if($subscriptionPlans->count() > 0)
                <div class="space-y-4">
                    @foreach($subscriptionPlans as $plan)
                    <label class="relative">
                        <input type="radio" name="subscription_plan_id" value="{{ $plan->id }}" class="sr-only">
                        <div class="border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-green-500 transition-colors">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $plan->name }}</h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $plan->benefits }}
                                    </p>
                                    @if($plan->description)
                                        <p class="text-xs text-gray-400 mt-1">{!! Str::limit(nl2br($plan->description), 100) !!}</p>
                                    @endif
                                </div>
                                <span class="text-lg font-semibold text-green-600" data-price-cdf="{{ $plan->package_price_cdf }}">
                                    {{ number_format($plan->package_price_cdf, 0, ',', '.') }} CDF
                                    @if($exchangeRate && $exchangeRate->rate > 0)
                                        <span class="text-sm text-gray-500">($ {{ number_format($plan->package_price_usd, 2) }})</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Aucune formule d'abonnement disponible pour le moment.</p>
                    <p class="text-sm text-gray-400">Veuillez contacter l'administrateur ou revenir plus tard.</p>
                </div>
            @endif
        </div>

        <!-- Delivery Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de Livraison</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse de Livraison
                    </label>
                    <textarea id="delivery_address" name="delivery_address" rows="3" required
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-green-500 focus:border-green-500"
                              placeholder="Votre adresse complète">{{ Auth::user()->address }}</textarea>
                </div>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notes (optionnel)
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-green-500 focus:border-green-500"
                              placeholder="Instructions spéciales, préférences..."></textarea>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Récapitulatif</h3>
            
            <div id="order-summary" class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Sous-total:</span>
                    <span class="font-medium" id="subtotal">$ 0.00</span>
                </div>
                <div class="flex justify-between text-lg font-semibold border-t pt-3">
                    <span>Total:</span>
                    <span class="text-green-600" id="total">$ 0.00</span>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                <i class="fas fa-shopping-cart mr-2"></i>Passer la Commande
            </button>
        </div>
    </form>
</div>

<script>
// Taux de change (passé du contrôleur)
const cdfToUsdRate = {{ $exchangeRate ? $exchangeRate->rate : 0 }};

// Fonction pour convertir CDF en USD
function convertCdfToUsd(cdfAmount) {
    if (cdfToUsdRate > 0) {
        return (cdfAmount * cdfToUsdRate).toFixed(2);
    }
    return 0; // Ou gérer l'erreur
}

// Toggle between meals and subscription sections
document.querySelectorAll('input[name="type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const mealsSection = document.getElementById('meals-section');
        const subscriptionSection = document.getElementById('subscription-section');
        
        if (this.value === 'single') {
            mealsSection.classList.remove('hidden');
            subscriptionSection.classList.add('hidden');
        } else {
            mealsSection.classList.add('hidden');
            subscriptionSection.classList.remove('hidden');
        }
        
        updateSummary();
    });
});

// Quantity controls
function incrementQuantity(mealId) {
    const input = document.querySelector(`input[name="meals[${mealId}][quantity]"]`);
    const currentValue = parseInt(input.value);
    if (currentValue < 10) {
        input.value = currentValue + 1;
        updateSummary();
    }
}

function decrementQuantity(mealId) {
    const input = document.querySelector(`input[name="meals[${mealId}][quantity]"]`);
    const currentValue = parseInt(input.value);
    if (currentValue > 0) {
        input.value = currentValue - 1;
        updateSummary();
    }
}

// Update order summary
function updateSummary() {
    const type = document.querySelector('input[name="type"]:checked').value;
    let totalCdf = 0;
    
    if (type === 'single') {
        // Calculate from meals
        document.querySelectorAll('#meals-section input[name*="[quantity]"]').forEach(input => {
            const quantity = parseInt(input.value) || 0;
            // const mealId = input.name.match(/\[(\d+)\]/)[1];
            const priceCdf = parseFloat(input.closest('.border').querySelector('[data-price-cdf]').dataset.priceCdf);
            totalCdf += quantity * priceCdf;
        });
    } else {
        // Get subscription plan price
        const selectedSubscriptionPlan = document.querySelector('#subscription-section input[name="subscription_plan_id"]:checked');
        if (selectedSubscriptionPlan) {
            totalCdf = parseFloat(selectedSubscriptionPlan.closest('.border').querySelector('[data-price-cdf]').dataset.priceCdf);
        }
    }
    
    document.getElementById('subtotal').textContent = `${number_format(totalCdf, 0)} CDF`;
    document.getElementById('total').textContent = `${number_format(totalCdf, 0)} CDF`;

    // Afficher aussi le total en USD si le taux de change est disponible
    if (cdfToUsdRate > 0) {
        const totalUsd = convertCdfToUsd(totalCdf);
        document.getElementById('total').textContent += ` ($${totalUsd})`;
        // document.getElementById('subtotal').textContent += ` ($${totalUsd})`; // Peut-être pas nécessaire d'afficher le sous-total en USD
    }
}

// Fonction utilitaire pour le formatage des nombres
function number_format(number, decimals, decPoint, thousandsSep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousandsSep === 'undefined') ? ',': thousandsSep,
        dec = (typeof decPoint === 'undefined') ? '.' : decPoint,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                .toFixed(prec);
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

// Initialize summary
updateSummary();
// Assurez-vous que la section correcte est visible au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    const initialType = document.querySelector('input[name="type"]:checked').value;
    const mealsSection = document.getElementById('meals-section');
    const subscriptionSection = document.getElementById('subscription-section');

    if (initialType === 'single') {
        mealsSection.classList.remove('hidden');
        subscriptionSection.classList.add('hidden');
    } else {
        mealsSection.classList.add('hidden');
        subscriptionSection.classList.remove('hidden');
    }
    updateSummary(); // Assurez-vous que le récapitulatif est à jour au chargement
});
</script>
@endsection
