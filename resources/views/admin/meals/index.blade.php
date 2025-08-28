@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Repas</h1>
                <p class="text-gray-600 mt-2">Gérez le menu de votre restaurant</p>
            </div>
            <button onclick="openCreateModal()" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="fas fa-plus mr-2"></i>Ajouter un repas
            </button>
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

        <!-- Tableau des repas -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Repas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Catégorie
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Commandes
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($meals as $meal)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($meal->image)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $meal->image) }}" alt="{{ $meal->name }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <i class="fas fa-utensils text-green-600"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $meal->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($meal->description, 50) }}</div>
                                </td>
                                                                 <td class="px-6 py-4 whitespace-nowrap">
                                     <div class="text-sm font-medium text-gray-900">{{ $meal->formatted_price_cdf }}</div>
                                     <div class="text-xs text-gray-500">{{ $meal->formatted_price_usd }}</div>
                                 </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $meal->category->name ?? 'N/A' }} <!-- Afficher le nom de la catégorie -->
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $meal->order_items_count }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($meal->is_available)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Indisponible
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="editMeal({{ $meal->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteMeal({{ $meal->id }})" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Aucun repas trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($meals->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $meals->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de création/édition -->
<div id="mealModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Ajouter un repas</h3>
            <form id="mealForm" method="POST" enctype="multipart/form-data"> <!-- Added enctype -->
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom du repas</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>
                
                                 <div class="mb-4">
                     <label for="price_cdf" class="block text-sm font-medium text-gray-700 mb-2">Prix en CDF</label>
                     <input type="number" id="price_cdf" name="price_cdf" step="1" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="27000">
                     <p class="text-xs text-gray-500 mt-1">Prix en Franc Congolais</p>
                 </div>
                 
                 <div class="mb-4">
                     <label for="price_usd" class="block text-sm font-medium text-gray-700 mb-2">Prix en USD</label>
                     <input type="number" id="price_usd" name="price_usd" step="0.01" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="10.00">
                     <p class="text-xs text-gray-500 mt-1">Prix en Dollar US</p>
                 </div>
                
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Image du repas</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="text-xs text-gray-500 mt-1">Téléchargez une image pour le repas (JPG, PNG)</p>
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                    <select id="category_id" name="category_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="is_available" name="is_available" value="1" 
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Disponible</span>
                    </label>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" 
                            class="px-4 py-2 text-gray-500 hover:text-gray-700">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Ajouter un repas';
    document.getElementById('mealForm').action = '{{ route("admin.meals.store") }}';
    document.getElementById('mealForm').method = 'POST';
    document.getElementById('category_id').value = ''; // Clear category selection
    document.getElementById('mealModal').classList.remove('hidden');
}

function editMeal(mealId) {
    document.getElementById('modalTitle').textContent = 'Modifier le repas';
    document.getElementById('mealForm').action = `/admin/meals/${mealId}`;
    document.getElementById('mealForm').method = 'POST';
    // Ajouter le champ _method pour PUT
    let methodField = document.createElement('input');
    methodField.type = 'hidden';
    methodField.name = '_method';
    methodField.value = 'PUT';
    document.getElementById('mealForm').appendChild(methodField);

    fetch(`{{ url('/admin/meals') }}/${mealId}/show`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('price_cdf').value = data.price_cdf;
            document.getElementById('price_usd').value = data.price_usd;
            document.getElementById('category_id').value = data.category_id; // Mettre à jour pour category_id
            document.getElementById('is_available').checked = data.is_available;

            // Afficher l'image existante si elle existe
            const existingImagePreview = document.getElementById('existingImagePreview');
            if (data.image) {
                if (!existingImagePreview) {
                    const img = document.createElement('img');
                    img.id = 'existingImagePreview';
                    img.src = `{{ asset('storage/') }}/${data.image}`;
                    img.className = 'mt-2 max-h-24 object-cover';
                    document.getElementById('image').parentNode.insertBefore(img, document.getElementById('image').nextSibling);
                } else {
                    existingImagePreview.src = `{{ asset('storage/') }}/${data.image}`;
                }
            } else if (existingImagePreview) {
                existingImagePreview.remove();
            }
        });

    document.getElementById('mealModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('mealModal').classList.add('hidden');
    // Nettoyer le formulaire
    document.getElementById('mealForm').reset();
    // Supprimer le champ _method s'il existe
    let methodField = document.querySelector('input[name="_method"]');
    if (methodField) methodField.remove();
}

function deleteMeal(mealId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce repas ?')) {
        fetch(`/admin/meals/${mealId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}
</script>
<script>
    const priceCdfInput = document.getElementById('price_cdf');
    const priceUsdInput = document.getElementById('price_usd');
    const usdToCdfRate = {{ $exchangeRate ? $exchangeRate->inverse_rate : 0 }}; // USD -> CDF
    const cdfToUsdRate = {{ $exchangeRate ? $exchangeRate->rate : 0 }}; // CDF -> USD

    let converting = false; // Flag to prevent infinite loops

    if (priceCdfInput && priceUsdInput && usdToCdfRate > 0 && cdfToUsdRate > 0) {
        priceCdfInput.addEventListener('input', function() {
            if (converting) return;
            converting = true;
            const cdfValue = parseFloat(this.value);
            if (!isNaN(cdfValue)) {
                priceUsdInput.value = (cdfValue * cdfToUsdRate).toFixed(2);
            } else {
                priceUsdInput.value = '';
            }
            converting = false;
        });

        priceUsdInput.addEventListener('input', function() {
            if (converting) return;
            converting = true;
            const usdValue = parseFloat(this.value);
            if (!isNaN(usdValue)) {
                priceCdfInput.value = (usdValue * usdToCdfRate).toFixed(0);
            } else {
                priceCdfInput.value = '';
            }
            converting = false;
        });
    }
</script>
@endsection
