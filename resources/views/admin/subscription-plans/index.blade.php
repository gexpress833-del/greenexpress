@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Formules d'Abonnement</h1>
                <p class="text-gray-600 mt-2">Gérez les différentes formules d'abonnement disponibles pour les clients.</p>
            </div>
            <button onclick="openCreateModal()" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                <i class="fas fa-plus mr-2"></i>Ajouter une formule
            </button>
        </div>

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

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nom de la formule
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Catégorie
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Durée
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix Unitaire Repas (CDF)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix Forfait (CDF)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Repas inclus
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bénéfices
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description des Repas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($subscriptionPlans as $plan)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $plan->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ match($plan->category_type) {
                                        'basic' => 'Séculier/Basic',
                                        'professional' => 'Professionnel',
                                        'premium' => 'Premium Entreprise',
                                        default => ucfirst($plan->category_type),
                                    } }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ match($plan->duration_type) {
                                        'weekly' => 'Semaine',
                                        'monthly' => 'Mois',
                                        default => ucfirst($plan->duration_type),
                                    } }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($plan->unit_price_per_meal_cdf, 0, ',', '.') }} CDF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($plan->package_price_cdf, 0, ',', '.') }} CDF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $plan->meal_count }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ Str::limit($plan->benefits, 50) }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ Str::limit(strip_tags($plan->description), 50) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button onclick="editSubscriptionPlan({{ $plan->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="deleteSubscriptionPlan({{ $plan->id }})" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                                    Aucune formule d'abonnement trouvée.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($subscriptionPlans->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $subscriptionPlans->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de création/édition -->
<div id="subscriptionPlanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Ajouter une Formule d'Abonnement</h3>
            <form id="subscriptionPlanForm" method="POST">
                @csrf
                <input type="hidden" id="plan_id" name="id">

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la formule</label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label for="category_type" class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                        <select id="category_type" name="category_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Sélectionner une catégorie</option>
                            <option value="basic">Séculier/Basic</option>
                            <option value="professional">Professionnel</option>
                            <option value="premium">Premium Entreprise</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="duration_type" class="block text-sm font-medium text-gray-700 mb-2">Durée</label>
                        <select id="duration_type" name="duration_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Sélectionner une durée</option>
                            <option value="weekly">Hebdomadaire</option>
                            <option value="monthly">Mensuel</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="unit_price_per_meal_cdf" class="block text-sm font-medium text-gray-700 mb-2">Prix Unitaire par Repas (CDF)</label>
                    <input type="number" id="unit_price_per_meal_cdf" name="unit_price_per_meal_cdf" step="1" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="package_price_cdf" class="block text-sm font-medium text-gray-700 mb-2">Prix du Forfait (CDF)</label>
                    <input type="number" id="package_price_cdf" name="package_price_cdf" step="1" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div class="mb-4">
                    <label for="meal_count" class="block text-sm font-medium text-gray-700 mb-2">Nombre de repas inclus</label>
                    <input type="number" id="meal_count" name="meal_count" step="1" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="benefits" class="block text-sm font-medium text-gray-700 mb-2">Bénéfices (description courte)</label>
                    <textarea id="benefits" name="benefits" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description des repas (détails quotidiens)</label>
                    <textarea id="description" name="description" rows="5"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
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
        document.getElementById('modalTitle').textContent = 'Ajouter une Formule d'Abonnement';
        document.getElementById('subscriptionPlanForm').action = '{{ route("admin.subscription-plans.store") }}';
        document.getElementById('subscriptionPlanForm').method = 'POST';
        document.getElementById('subscriptionPlanForm').reset();
        document.getElementById('plan_id').value = '';
        removeMethodField();
        document.getElementById('subscriptionPlanModal').classList.remove('hidden');
    }

    function editSubscriptionPlan(planId) {
        document.getElementById('modalTitle').textContent = 'Modifier la Formule d'Abonnement';
        document.getElementById('subscriptionPlanForm').action = `/admin/subscription-plans/${planId}`;
        document.getElementById('subscriptionPlanForm').method = 'POST'; // Laravel will interpret POST with _method as PUT
        document.getElementById('plan_id').value = planId;

        // Add _method field for PUT
        let methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        document.getElementById('subscriptionPlanForm').appendChild(methodField);

        fetch(`{{ url('/admin/subscription-plans') }}/${planId}/show`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('name').value = data.name;
                document.getElementById('category_type').value = data.category_type;
                document.getElementById('duration_type').value = data.duration_type;
                document.getElementById('unit_price_per_meal_cdf').value = data.unit_price_per_meal_cdf;
                document.getElementById('package_price_cdf').value = data.package_price_cdf;
                document.getElementById('meal_count').value = data.meal_count;
                document.getElementById('benefits').value = data.benefits;
                document.getElementById('description').value = data.description;
            });

        document.getElementById('subscriptionPlanModal').classList.remove('hidden');
    }

    function deleteSubscriptionPlan(planId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette formule d'abonnement ?')) {
            fetch(`/admin/subscription-plans/${planId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Erreur lors de la suppression de la formule.');
                }
            });
        }
    }

    function closeModal() {
        document.getElementById('subscriptionPlanModal').classList.add('hidden');
        document.getElementById('subscriptionPlanForm').reset();
        removeMethodField();
    }

    function removeMethodField() {
        let methodField = document.querySelector('#subscriptionPlanForm input[name="_method"]');
        if (methodField) methodField.remove();
    }
</script>
@endsection
