@extends('layouts.app')

@section('title', 'Gestion des Catégories - Green Express')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Gestion des Catégories</h1>
        <button type="button" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700" onclick="openCreateCategoryModal()">
            <i class="fas fa-plus mr-2"></i>Nouvelle Catégorie
        </button>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nom
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Repas Associés
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $category->description ?: 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $category->meals_count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button type="button" class="text-blue-600 hover:text-blue-900" onclick="openEditCategoryModal({{ $category->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 @if($category->meals_count > 0) opacity-50 cursor-not-allowed @endif" @if($category->meals_count > 0) disabled @endif>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Aucune catégorie trouvée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Nouvelle Catégorie</h3>
                <div class="mt-2 px-7 py-3">
                    <form id="categoryForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="category_id" id="categoryId">
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 text-left">Nom de la Catégorie</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 text-left">Description (optionnel)</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                        </div>
                        
                        <div class="items-center px-4 py-3">
                            <button id="saveCategoryBtn" type="submit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                Enregistrer
                            </button>
                            <button type="button" class="mt-3 px-4 py-2 bg-gray-200 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300" onclick="closeCategoryModal()">
                                Annuler
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const categoryModal = document.getElementById('categoryModal');
    const modalTitle = document.getElementById('modalTitle');
    const categoryForm = document.getElementById('categoryForm');
    const categoryIdInput = document.getElementById('categoryId');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const methodInput = document.getElementById('_method');

    function openCreateCategoryModal() {
        modalTitle.textContent = 'Nouvelle Catégorie';
        categoryForm.action = '{{ route('admin.categories.store') }}';
        methodInput.value = 'POST';
        categoryIdInput.value = '';
        nameInput.value = '';
        descriptionInput.value = '';
        categoryModal.classList.remove('hidden');
    }

    function openEditCategoryModal(id) {
        modalTitle.textContent = 'Modifier Catégorie';
        categoryForm.action = `/admin/categories/${id}`;
        methodInput.value = 'PUT';
        categoryIdInput.value = id;

        fetch(`/admin/categories/${id}/show`)
            .then(response => response.json())
            .then(data => {
                nameInput.value = data.name;
                descriptionInput.value = data.description;
            });

        categoryModal.classList.remove('hidden');
    }

    function closeCategoryModal() {
        categoryModal.classList.add('hidden');
    }
</script>
@endsection
