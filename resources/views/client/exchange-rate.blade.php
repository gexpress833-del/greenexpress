@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900">Taux de Change</h1>
            <p class="text-gray-600 mt-2">Informations sur le taux de change CDF/USD utilisé pour les calculs</p>
        </div>

        <!-- Taux de change actuel -->
        <div class="bg-white rounded-lg shadow-md p-8">
            @php
                $currentRate = \App\Models\ExchangeRate::getCurrentRate();
            @endphp
            
            @if($currentRate)
                <div class="text-center mb-8">
                    <div class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                        <i class="fas fa-info-circle mr-2"></i>
                        Taux de change actuel
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="text-center p-6 bg-green-50 rounded-lg">
                        <div class="text-4xl font-bold text-green-600 mb-2">
                            {{ number_format($currentRate->inverse_rate, 0, ',', ' ') }}
                        </div>
                        <div class="text-gray-600">CDF</div>
                        <div class="text-sm text-gray-500 mt-1">pour 1 USD</div>
                    </div>
                    
                    <div class="text-center p-6 bg-blue-50 rounded-lg">
                        <div class="text-4xl font-bold text-blue-600 mb-2">
                            {{ number_format($currentRate->rate, 6) }}
                        </div>
                        <div class="text-gray-600">USD</div>
                        <div class="text-sm text-gray-500 mt-1">pour 1 CDF</div>
                    </div>
                </div>

                <div class="text-center text-sm text-gray-500">
                    <i class="fas fa-clock mr-1"></i>
                    Dernière mise à jour : {{ $currentRate->last_updated->format('d/m/Y à H:i') }}
                </div>

                <!-- Exemples de conversion -->
                <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 text-center">Exemples de conversion</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="text-center">
                            <div class="font-medium text-gray-700">10 USD</div>
                            <div class="text-green-600 font-bold">= {{ number_format(10 * $currentRate->inverse_rate, 0, ',', ' ') }} CDF</div>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-gray-700">50 000 CDF</div>
                            <div class="text-blue-600 font-bold">= {{ number_format(50000 * $currentRate->rate, 2) }} USD</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-4xl text-yellow-500 mb-4"></i>
                    <p class="text-gray-500">Aucun taux de change disponible</p>
                </div>
            @endif
        </div>

        <!-- Note d'information -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Information</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Le taux de change est mis à jour régulièrement par l'administrateur pour assurer des calculs précis. 
                        Tous les prix affichés sur la plateforme utilisent ce taux pour la conversion automatique entre CDF et USD.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
