@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Abonnements</h1>
            <p class="text-gray-600 mt-2">Gérez les abonnements de vos clients</p>
        </div>
        <button onclick="openCreateModal()" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
            <i class="fas fa-plus mr-2"></i>Ajouter un abonnement
        </button>
    </div>

    <!-- Messages de succès/erreur -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tableau des abonnements -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nom
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type
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
                                Économies (CDF)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Repas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description du Plan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Raison (Changement)
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date de début
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date de fin
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <i class="fas fa-user text-blue-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $subscription->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $subscription->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $subscription->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($subscription->category_type === 'basic') bg-gray-100 text-gray-800
                                        @elseif($subscription->category_type === 'professional') bg-blue-100 text-blue-800
                                        @else bg-purple-100 text-purple-800 @endif">
                                        {{ match($subscription->category_type) {
                                            'basic' => 'Séculier/Basic',
                                            'professional' => 'Professionnel',
                                            'premium' => 'Premium Entreprise',
                                            default => ucfirst($subscription->category_type),
                                        } }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ match($subscription->duration_type) {
                                        'weekly' => 'Semaine',
                                        'monthly' => 'Mois',
                                        default => ucfirst($subscription->duration_type),
                                    } }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $subscription->formatted_unit_price_per_meal_cdf }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $subscription->formatted_package_price_cdf }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $subscription->formatted_savings_cdf }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $subscription->meal_count }} repas
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $subscription->plan_description ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $subscription->reason ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($subscription->status === 'active')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Actif
                                        </span>
                                    @elseif($subscription->status === 'expired')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Expiré
                                        </span>
                                    @elseif($subscription->status === 'pending_validation')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            En attente de validation
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Annulé
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $subscription->start_date ? $subscription->start_date->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $subscription->end_date ? $subscription->end_date->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($subscription->status === 'pending_validation')
                                        <button type="button" onclick="openValidateSubscriptionModal({{ $subscription->id }})" class="bg-green-500 text-white px-3 py-1 rounded-full text-xs hover:bg-green-600">Valider</button>
                                        <button type="button" onclick="openRejectSubscriptionModal({{ $subscription->id }})" class="bg-red-500 text-white px-3 py-1 rounded-full text-xs hover:bg-red-600">Rejeter</button>
                                    @endif
                                    <button type="button" onclick="openEditSubscriptionModal({{ $subscription->id }})" class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs hover:bg-blue-600">Éditer</button>
                                    <button type="button" onclick="deleteSubscription({{ $subscription->id }})" class="bg-red-500 text-white px-3 py-1 rounded-full text-xs hover:bg-red-600">Supprimer</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="13" class="px-6 py-4 text-center text-gray-500">
                                    Aucun abonnement trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($subscriptions->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de création/édition -->
<div id="subscriptionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Ajouter un abonnement</h3>
            <form id="subscriptionForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Client</label>
                    <select id="user_id" name="user_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Sélectionner un client</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de l'abonnement</label>
                    <input type="text" id="name" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="category_type" class="block text-sm font-medium text-gray-700 mb-2">Catégorie d'abonnement</label>
                    <select id="category_type" name="category_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Sélectionner une catégorie</option>
                        <option value="basic">Basic</option>
                        <option value="professional">Professionnel</option>
                        <option value="premium">Premium</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="duration_type" class="block text-sm font-medium text-gray-700 mb-2">Durée de l'abonnement</label>
                    <select id="duration_type" name="duration_type" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Sélectionner une durée</option>
                        <option value="weekly">Hebdomadaire</option>
                        <option value="monthly">Mensuel</option>
                    </select>
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
                    <label for="meal_count" class="block text-sm font-medium text-gray-700 mb-2">Nombre de repas</label>
                    <input type="number" id="meal_count" name="meal_count" step="1" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="plan_description" class="block text-sm font-medium text-gray-700 mb-2">Description du Plan</label>
                    <textarea id="plan_description" name="plan_description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                    <input type="date" id="start_date" name="start_date" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                    <input type="date" id="end_date" name="end_date" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select id="status" name="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">Sélectionner un statut</option>
                        <option value="active">Actif</option>
                        <option value="expired">Expiré</option>
                        <option value="cancelled">Annulé</option>
                        <option value="pending_validation">En attente de validation</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Raison du changement (optionnel)</label>
                    <textarea id="reason" name="reason" rows="3"
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

<!-- Modal de confirmation pour la validation d'abonnement -->
<div id="validateSubscriptionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Valider l'abonnement</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir valider cet abonnement ?</p>
            </div>
            <form id="validateSubscriptionForm" method="POST">
                @csrf
                <input type="hidden" name="subscription" id="validate_subscription_id">
                <input type="hidden" name="status" value="active">
                <div class="items-center px-4 py-3">
                    <button type="button" onclick="closeValidateSubscriptionModal()" class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 mt-2">Confirmer la Validation</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de confirmation pour le rejet d'abonnement -->
<div id="rejectSubscriptionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Rejeter l'abonnement</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir rejeter cet abonnement ?</p>
                <textarea name="reason" id="reject_reason" rows="3" placeholder="Raison du rejet (minimum 10 caractères)" class="mt-3 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500"></textarea>
            </div>
            <form id="rejectSubscriptionForm" method="POST">
                @csrf
                <input type="hidden" name="subscription" id="reject_subscription_id">
                <input type="hidden" name="status" value="cancelled">
                <div class="items-center px-4 py-3">
                    <button type="button" onclick="closeRejectSubscriptionModal()" class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 mt-2">Confirmer le Rejet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Ajouter un abonnement';
    document.getElementById('subscriptionForm').action = '{{ route("admin.subscriptions.store") }}';
    document.getElementById('subscriptionForm').method = 'POST';
    
    let methodField = document.querySelector('#subscriptionForm input[name="_method"]');
    if (methodField) methodField.remove();

    document.getElementById('subscriptionForm').reset();
    document.getElementById('subscriptionModal').classList.remove('hidden');
    // Clear reason field specifically
    document.getElementById('reason').value = '';
    // Enable all form elements when opening for creation
    const formElements = document.querySelectorAll('#subscriptionForm input, #subscriptionForm select, #subscriptionForm textarea');
    formElements.forEach(element => {
        element.readOnly = false;
        element.disabled = false;
    });
    document.querySelector('#subscriptionForm button[type="submit"]').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('subscriptionModal').classList.add('hidden');
    document.getElementById('subscriptionForm').reset();
    let methodField = document.querySelector('#subscriptionForm input[name="_method"]');
    if (methodField) methodField.remove();
    // Clear reason field specifically
    document.getElementById('reason').value = '';
}

function viewSubscription(id) {
    editSubscription(id, true); // Pass a readOnly flag
}

function openEditSubscriptionModal(id) {
    fetch(`{{ url('/admin/subscriptions') }}/${id}/show`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Modifier l\'abonnement';
            document.getElementById('subscriptionForm').action = `{{ url('/admin/subscriptions') }}/${id}`;
            document.getElementById('subscriptionForm').method = 'POST';

            let methodField = document.querySelector('#subscriptionForm input[name="_method"]');
            if (!methodField) {
                methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                document.getElementById('subscriptionForm').appendChild(methodField);
            }
            methodField.value = 'PUT';

            document.getElementById('user_id').value = data.user_id;
            document.getElementById('name').value = data.name;
            document.getElementById('category_type').value = data.category_type;
            document.getElementById('duration_type').value = data.duration_type;
            document.getElementById('unit_price_per_meal_cdf').value = data.unit_price_per_meal_cdf;
            document.getElementById('package_price_cdf').value = data.package_price_cdf;
            document.getElementById('meal_count').value = data.meal_count;
            document.getElementById('plan_description').value = data.plan_description;
            document.getElementById('start_date').value = data.start_date.split('T')[0];
            document.getElementById('end_date').value = data.end_date.split('T')[0];
            document.getElementById('status').value = data.status;
            document.getElementById('reason').value = data.reason || ''; // Populate reason field

            // Enable all form elements for editing
            const formElements = document.querySelectorAll('#subscriptionForm input, #subscriptionForm select, #subscriptionForm textarea');
            formElements.forEach(element => {
                element.readOnly = false;
                element.disabled = false;
            });
            document.querySelector('#subscriptionForm button[type="submit"]').classList.remove('hidden');
            
            document.getElementById('subscriptionModal').classList.remove('hidden');
        });
}

// Simplification: Directement appelées par les boutons pour ouvrir les modales de validation/rejet
function openValidateSubscriptionModal(subscriptionId) {
    document.getElementById('validate_subscription_id').value = subscriptionId;
    document.getElementById('validateSubscriptionForm').action = `{{ route('admin.subscriptions.validate', ['subscription' => '__SUBSCRIPTION_ID__']) }}`.replace('__SUBSCRIPTION_ID__', subscriptionId);
    document.getElementById('validateSubscriptionModal').classList.remove('hidden');
}

function closeValidateSubscriptionModal() {
    document.getElementById('validateSubscriptionModal').classList.add('hidden');
}

function openRejectSubscriptionModal(subscriptionId) {
    document.getElementById('reject_subscription_id').value = subscriptionId;
    document.getElementById('reject_reason').value = ''; // Clear previous reason
    document.getElementById('rejectSubscriptionForm').action = `{{ route('admin.subscriptions.reject', ['subscription' => '__SUBSCRIPTION_ID__']) }}`.replace('__SUBSCRIPTION_ID__', subscriptionId);
    document.getElementById('rejectSubscriptionModal').classList.remove('hidden');
}

function closeRejectSubscriptionModal() {
    document.getElementById('rejectSubscriptionModal').classList.add('hidden');
}

function deleteSubscription(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet abonnement ?')) {
        fetch(`{{ route('admin.subscriptions.destroy', ['subscription' => '__SUBSCRIPTION_ID__']) }}`.replace('__SUBSCRIPTION_ID__', id), {
            method: 'POST', // Laravel delete method uses POST with _method field
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ _method: 'DELETE' })
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Erreur lors de la suppression de l\'abonnement.');
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('Erreur réseau ou du serveur.');
        });
    }
}
</script>
@endsection
