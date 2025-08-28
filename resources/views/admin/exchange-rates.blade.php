@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestion du Taux de Change</h1>
            <p class="text-gray-600 mt-2">Configurez le taux de change CDF/USD pour les calculs automatiques</p>
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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Configuration du taux actuel -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Taux de Change Actuel</h2>
                
                @if($currentRate)
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg">
                            <span class="text-gray-700 font-medium">1 USD =</span>
                            <span class="text-2xl font-bold text-green-600">{{ number_format($currentRate->inverse_rate, 0, ',', ' ') }} CDF</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-4 bg-blue-50 rounded-lg">
                            <span class="text-gray-700 font-medium">1 CDF =</span>
                            <span class="text-2xl font-bold text-blue-600">{{ number_format($currentRate->rate, 6) }} USD</span>
                        </div>
                        
                        <div class="text-sm text-gray-500 text-center">
                            Dernière mise à jour : {{ $currentRate->last_updated->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @else
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                        <p>Aucun taux de change actif</p>
                    </div>
                @endif
            </div>

            <!-- Formulaire de mise à jour -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">Mettre à jour le taux</h2>
                
                <form action="{{ route('admin.exchange-rates.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="usd_to_cdf_rate" class="block text-sm font-medium text-gray-700 mb-2">
                            Nouveau taux (1 USD = ? CDF)
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   id="usd_to_cdf_rate" 
                                   name="usd_to_cdf_rate" 
                                   step="0.01" 
                                   min="1" 
                                   max="10000"
                                   value="{{ $currentRate ? $currentRate->inverse_rate : 2700 }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="2700">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <span class="text-gray-500 text-sm">CDF</span>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            Exemple : 2700 signifie que 1 USD = 2700 CDF
                        </p>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Prévisualisation</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-600">
                                <div>1 USD = <span id="preview-rate">2700</span> CDF</div>
                                <div>1 CDF = <span id="preview-inverse">0.000370</span> USD</div>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <i class="fas fa-save mr-2"></i>Mettre à jour le taux
                    </button>
                </form>
            </div>
        </div>

        <!-- Historique des taux -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Historique des taux</h2>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                1 USD = CDF
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                1 CDF = USD
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($exchangeRates as $rate)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rate->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($rate->inverse_rate, 0, ',', ' ') }} CDF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($rate->rate, 6) }} USD
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($rate->is_active)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    Aucun historique disponible
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('usd_to_cdf_rate').addEventListener('input', function() {
    const usdToCdfRate = parseFloat(this.value) || 2700;
    const cdfToUsdRate = 1 / usdToCdfRate;
    
    document.getElementById('preview-rate').textContent = usdToCdfRate.toLocaleString();
    document.getElementById('preview-inverse').textContent = cdfToUsdRate.toFixed(6);
});
</script>
@endsection
