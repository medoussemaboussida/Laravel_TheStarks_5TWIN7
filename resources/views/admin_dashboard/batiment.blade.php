@extends('admin_dashboard.layout')

@section('title', 'Gestion des Bâtiments')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Bâtiments</h1>
        <a href="{{ route('backoffice.createbatiment') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter un Bâtiment
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des Bâtiments</h6>

                    <!-- Filtres et Recherche -->
                    <form method="GET" action="{{ route('backoffice.indexbatiment') }}" id="search-form" class="d-flex align-items-center gap-3">
                        <!-- Filtre par type -->
                        <div class="d-flex align-items-center">
                            <label for="type" class="me-2 mb-0" style="font-size: 0.9rem;">Type:</label>
                            <select name="type" id="filter-type" class="form-select form-select-sm" style="width: 120px;">
                                <option value="">Tous</option>
                                <option value="Maison" {{ request('type') == 'Maison' ? 'selected' : '' }}>Maison</option>
                                <option value="Usine" {{ request('type') == 'Usine' ? 'selected' : '' }}>Usine</option>
                            </select>
                        </div>

                        <!-- Recherche par adresse -->
                        <div class="d-flex align-items-center">
                            <label for="search" class="me-2 mb-0" style="font-size: 0.9rem;">Adresse:</label>
                            <input type="text" name="search" id="search-adresse" class="form-control form-control-sm" placeholder="Rechercher..." style="width: 200px;" value="{{ request('search') }}">
                        </div>

                        <!-- Bouton de recherche -->
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-search"></i> Rechercher
                        </button>

                        <!-- Bouton pour effacer les filtres -->
                        @if(request('search') || request('type'))
                            <a href="{{ route('backoffice.indexbatiment') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-times"></i> Effacer
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    @if($batiments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Adresse</th>
                                        <th>Zone</th>
                                        <th>Propriétaire</th>
                                        <th>Émission CO2</th>
                                        <th>Émission Réelle</th>
                                        <th>Arbres Besoin</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="batiments-table-body">
                                    @foreach($batiments as $batiment)
                                    <tr>
                                        <td>{{ $batiment->id }}</td>
                                        <td>
                                            <span class="badge bg-{{ $batiment->type_batiment === 'Maison' ? 'success' : 'warning' }}">
                                                {{ $batiment->type_batiment }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($batiment->adresse, 30) }}</td>
                                        <td>{{ $batiment->zone->nom ?? 'N/A' }}</td>
                                        <td>{{ $batiment->user->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($batiment->emissionCO2, 2) }} t/an</td>
                                        <td>{{ number_format($batiment->emission_reelle, 2) }} t/an</td>
                                        <td>{{ $batiment->nbArbresBesoin }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-info" title="Voir" onclick="loadBatimentDetails({{ $batiment->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <a href="{{ route('backoffice.editbatiment', $batiment) }}" class="btn btn-sm btn-warning" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('backoffice.destroybatiment', $batiment) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bâtiment ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $batiments->links('vendor.pagination.custom') }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-building fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun bâtiment trouvé</h5>
                            <p class="text-muted">Il n'y a actuellement aucun bâtiment enregistré dans le système.</p>
                            <a href="{{ route('backoffice.createbatiment') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Ajouter le premier bâtiment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails du Bâtiment -->
<div class="modal fade" id="batimentModal" tabindex="-1" aria-labelledby="batimentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="batimentModalLabel">Détails du Bâtiment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="batimentModalBody">
                <!-- Les détails du bâtiment seront chargés ici via AJAX -->
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <p class="mt-2">Chargement des détails...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning" id="editBatimentBtn" style="display: none;" onclick="openEditModal()">Modifier</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Modifier le Bâtiment -->
<div class="modal fade" id="editBatimentModal" tabindex="-1" aria-labelledby="editBatimentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBatimentModalLabel">Modifier le Bâtiment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBatimentForm">
                <div class="modal-body" id="editBatimentModalBody">
                    <!-- Le formulaire d'édition sera chargé ici via AJAX -->
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <p class="mt-2">Chargement du formulaire...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts pour la recherche automatique et la modal -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-adresse');
    const typeFilter = document.getElementById('filter-type');
    const searchForm = document.getElementById('search-form');

    let searchTimeout;

    // Fonction pour soumettre le formulaire avec un délai
    function submitSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchForm.submit();
        }, 500); // Délai de 500ms pour éviter trop de requêtes
    }

    // Recherche automatique lors de la saisie
    searchInput.addEventListener('input', submitSearch);

    // Recherche immédiate lors du changement de type
    typeFilter.addEventListener('change', () => {
        searchForm.submit();
    });

    // Empêcher la soumission du formulaire lors de l'appui sur Entrée dans le champ de recherche
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchForm.submit();
        }
    });
});

// Fonction pour charger les détails du bâtiment dans la modal
function loadBatimentDetails(batimentId) {
    const modalBody = document.getElementById('batimentModalBody');
    const editBtn = document.getElementById('editBatimentBtn');

    if (!modalBody) {
        console.error('Modal body element not found');
        return;
    }

    // Ouvrir le modal manuellement avec Bootstrap
    const modal = new bootstrap.Modal(document.getElementById('batimentModal'));
    modal.show();

    // Afficher le spinner de chargement
    modalBody.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mt-2">Chargement des détails...</p>
        </div>
    `;

    // Faire une requête AJAX pour récupérer les détails via l'API
    fetch(`/api/batiment/${batimentId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'  // Important pour envoyer les cookies de session
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        displayBatimentDetails(data.batiment);
        editBtn.style.display = 'inline-block';
        editBtn.onclick = () => {
            window.location.href = `/adminbatiment/${batimentId}/edit`;
        };
    })
    .catch(error => {
        console.error('Erreur lors du chargement des détails:', error);
        modalBody.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                Erreur lors du chargement des détails du bâtiment: ${error.message}
            </div>
        `;
    });
}

// Fonction pour afficher les détails du bâtiment dans la modal
function displayBatimentDetails(batiment) {
    const modalBody = document.getElementById('batimentModalBody');

    const html = `
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Informations Générales</h6>
                <table class="table table-sm">
                    <tr>
                        <th width="40%">ID:</th>
                        <td>${batiment.id}</td>
                    </tr>
                    <tr>
                        <th>Type:</th>
                        <td>
                            <span class="badge bg-${batiment.type_batiment === 'Maison' ? 'success' : 'warning'}">
                                ${batiment.type_batiment}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Adresse:</th>
                        <td>${batiment.adresse}</td>
                    </tr>
                    <tr>
                        <th>Zone:</th>
                        <td>${batiment.zone ? batiment.zone.nom : 'N/A'}</td>
                    </tr>
                    <tr>
                        <th>Propriétaire:</th>
                        <td>${batiment.user ? batiment.user.name : 'N/A'}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="text-success mb-3"><i class="fas fa-leaf"></i> Données Environnementales</h6>
                <table class="table table-sm">
                    <tr>
                        <th width="50%">Émission CO2:</th>
                        <td class="text-danger">${parseFloat(batiment.emission_c_o2 || 0).toFixed(2)} t/an</td>
                    </tr>
                    <tr>
                        <th>Émission réelle:</th>
                        <td class="text-warning">${parseFloat(batiment.emission_reelle || 0).toFixed(2)} t/an</td>
                    </tr>
                    <tr>
                        <th>Énergie renouvelable:</th>
                        <td class="text-success">${parseFloat(batiment.pourcentage_renouvelable || 0).toFixed(1)}%</td>
                    </tr>
                    <tr>
                        <th>Arbres nécessaires:</th>
                        <td class="text-info">${batiment.nbArbresBesoin || 0}</td>
                    </tr>
                </table>
            </div>
        </div>

        ${batiment.type_batiment === 'Maison' && batiment.nb_habitants ? `
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="text-secondary mb-2"><i class="fas fa-home"></i> Détails Maison</h6>
                <p class="mb-0">Nombre d'habitants: <strong>${batiment.nb_habitants}</strong></p>
            </div>
        </div>
        ` : ''}

        ${batiment.type_batiment === 'Usine' && (batiment.nb_employes || batiment.type_industrie) ? `
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="text-secondary mb-2"><i class="fas fa-industry"></i> Détails Usine</h6>
                ${batiment.nb_employes ? `<p class="mb-1">Nombre d'employés: <strong>${batiment.nb_employes}</strong></p>` : ''}
                ${batiment.type_industrie ? `<p class="mb-0">Type d'industrie: <strong>${batiment.type_industrie}</strong></p>` : ''}
            </div>
        </div>
        ` : ''}

        ${batiment.recyclage_data && batiment.recyclage_data.existe ? `
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="text-secondary mb-2"><i class="fas fa-recycle"></i> Recyclage</h6>
                <div class="mb-0">
                    ${batiment.recyclage_data.produit_recycle ? batiment.recyclage_data.produit_recycle.map(produit =>
                        `<span class="badge bg-light text-dark me-1">${produit}</span>`
                    ).join('') : ''}
                </div>
            </div>
        </div>
        ` : ''}
    `;

    modalBody.innerHTML = html;
}

// Variable globale pour stocker l'ID du bâtiment en cours d'édition
let currentBatimentId = null;

// Fonction pour ouvrir le modal d'édition
function openEditModal() {
    if (!currentBatimentId) {
        console.error('No building ID available for editing');
        return;
    }

    // Fermer le modal de détails
    const detailsModal = bootstrap.Modal.getInstance(document.getElementById('batimentModal'));
    if (detailsModal) {
        detailsModal.hide();
    }

    // Ouvrir le modal d'édition
    const editModal = new bootstrap.Modal(document.getElementById('editBatimentModal'));
    editModal.show();

    // Charger le formulaire d'édition
    loadEditForm(currentBatimentId);
}

// Fonction pour charger le formulaire d'édition
function loadEditForm(batimentId) {
    const modalBody = document.getElementById('editBatimentModalBody');

    // Afficher le spinner de chargement
    modalBody.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mt-2">Chargement du formulaire...</p>
        </div>
    `;

    // Récupérer les données actuelles du bâtiment
    fetch(`/api/batiment/${batimentId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        displayEditForm(data.batiment);
    })
    .catch(error => {
        console.error('Erreur lors du chargement du formulaire:', error);
        modalBody.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                Erreur lors du chargement du formulaire d'édition.
            </div>
        `;
    });
}

// Fonction pour afficher le formulaire d'édition
function displayEditForm(batiment) {
    const modalBody = document.getElementById('editBatimentModalBody');

    const html = `
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Informations Générales</h6>

                <div class="mb-3">
                    <label for="edit_type_batiment" class="form-label">Type de Bâtiment</label>
                    <select class="form-select" id="edit_type_batiment" name="type_batiment" required>
                        <option value="Maison" ${batiment.type_batiment === 'Maison' ? 'selected' : ''}>Maison</option>
                        <option value="Usine" ${batiment.type_batiment === 'Usine' ? 'selected' : ''}>Usine</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="edit_adresse" class="form-label">Adresse</label>
                    <input type="text" class="form-control" id="edit_adresse" name="adresse" value="${batiment.adresse || ''}" required>
                </div>

                <div class="mb-3">
                    <label for="edit_zone_id" class="form-label">Zone</label>
                    <select class="form-select" id="edit_zone_id" name="zone_id" required>
                        <option value="">Sélectionner une zone</option>
                        <!-- Les zones seront chargées dynamiquement -->
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <h6 class="text-success mb-3"><i class="fas fa-home"></i> Détails Spécifiques</h6>

                <div id="maison-fields" style="display: ${batiment.type_batiment === 'Maison' ? 'block' : 'none'};">
                    <div class="mb-3">
                        <label for="edit_nb_habitants" class="form-label">Nombre d'Habitants</label>
                        <input type="number" class="form-control" id="edit_nb_habitants" name="nb_habitants" value="${batiment.nb_habitants || ''}" min="1">
                    </div>
                </div>

                <div id="usine-fields" style="display: ${batiment.type_batiment === 'Usine' ? 'block' : 'none'};">
                    <div class="mb-3">
                        <label for="edit_nb_employes" class="form-label">Nombre d'Employés</label>
                        <input type="number" class="form-control" id="edit_nb_employes" name="nb_employes" value="${batiment.nb_employes || ''}" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="edit_type_industrie" class="form-label">Type d'Industrie</label>
                        <input type="text" class="form-control" id="edit_type_industrie" name="type_industrie" value="${batiment.type_industrie || ''}">
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="batiment_id" value="${batiment.id}">
    `;

    modalBody.innerHTML = html;

    // Charger les zones disponibles
    loadZones();

    // Gérer le changement de type de bâtiment
    document.getElementById('edit_type_batiment').addEventListener('change', function() {
        const type = this.value;
        document.getElementById('maison-fields').style.display = type === 'Maison' ? 'block' : 'none';
        document.getElementById('usine-fields').style.display = type === 'Usine' ? 'block' : 'none';
    });
}

// Fonction pour charger les zones
function loadZones() {
    fetch('/api/zones', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        const zoneSelect = document.getElementById('edit_zone_id');
        zoneSelect.innerHTML = '<option value="">Sélectionner une zone</option>';

        data.zones.forEach(zone => {
            const option = document.createElement('option');
            option.value = zone.id;
            option.textContent = zone.nom;
            if (currentBatimentData && currentBatimentData.zone_id == zone.id) {
                option.selected = true;
            }
            zoneSelect.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Erreur lors du chargement des zones:', error);
    });
}

// Variable pour stocker les données actuelles du bâtiment
let currentBatimentData = null;

// Modifier la fonction loadBatimentDetails pour stocker les données
function loadBatimentDetails(batimentId) {
    currentBatimentId = batimentId; // Stocker l'ID globalement

    const modalBody = document.getElementById('batimentModalBody');
    const editBtn = document.getElementById('editBatimentBtn');

    if (!modalBody) {
        console.error('Modal body element not found');
        return;
    }

    // Ouvrir le modal manuellement avec Bootstrap
    const modal = new bootstrap.Modal(document.getElementById('batimentModal'));
    modal.show();

    // Afficher le spinner de chargement
    modalBody.innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mt-2">Chargement des détails...</p>
        </div>
    `;

    // Faire une requête AJAX pour récupérer les détails via l'API
    fetch(`/api/batiment/${batimentId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'  // Important pour envoyer les cookies de session
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        currentBatimentData = data.batiment; // Stocker les données
        displayBatimentDetails(data.batiment);
        editBtn.style.display = 'inline-block';
    })
    .catch(error => {
        console.error('Erreur lors du chargement des détails:', error);
        modalBody.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                Erreur lors du chargement des détails du bâtiment: ${error.message}
            </div>
        `;
    });
}

// Gestionnaire de soumission du formulaire d'édition
document.getElementById('editBatimentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`/adminbatiment/${currentBatimentId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'X-HTTP-Method-Override': 'PUT'  // Simuler PUT avec POST
        },
        body: formData,
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        // Fermer le modal d'édition
        const editModal = bootstrap.Modal.getInstance(document.getElementById('editBatimentModal'));
        if (editModal) {
            editModal.hide();
        }

        // Actualiser la page pour voir les changements
        location.reload();
    })
    .catch(error => {
        console.error('Erreur lors de la sauvegarde:', error);
        alert('Erreur lors de la sauvegarde des modifications.');
    });
});
</script>
@endsection