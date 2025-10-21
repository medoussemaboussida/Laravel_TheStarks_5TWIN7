@extends('admin_dashboard.layout')

@section('title', 'Gestion des Bâtiments')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Bâtiments</h1>
        <div>
            <a href="{{ route('backoffice.batiments.report.pdf') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-2" target="_blank">
                <i class="fas fa-file-pdf fa-sm text-white-50"></i> Générer Rapport PDF
            </a>
            <a href="{{ route('backoffice.createbatiment') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter un Bâtiment
            </a>
        </div>
    </div>

    <!-- Statistics Row -->
    <div class="row mb-4">
        <!-- Total Bâtiments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Bâtiments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_batiments'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maisons -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Maisons</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_maisons'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-home fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usines -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Usines</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_usines'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-industry fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Émissions CO2 Totales -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Émissions CO2 Totales</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_emissions_co2'], 2) }} t/an</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cloud fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics Row -->
    <div class="row mb-4">
        <!-- Énergie Renouvelable Moyenne -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Énergie Renouvelable Moyenne</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['moyenne_energie_renouvelable'], 1) }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sun fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Arbres Nécessaires Total -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Arbres Nécessaires Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_arbres_besoin']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tree fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Taux de Recyclage -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Bâtiments avec Recyclage</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Batiment::whereNotNull('recyclage_data')->count() }} / {{ $stats['total_batiments'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-recycle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

                        <!-- Tri par émissions CO2 -->
                        <div class="d-flex align-items-center">
                            <label for="sort_co2" class="me-2 mb-0" style="font-size: 0.9rem;">Émissions CO2:</label>
                            <select name="sort_co2" id="sort-co2" class="form-select form-select-sm" style="width: 140px;">
                                <option value="">Trier par...</option>
                                <option value="desc" {{ request('sort_co2') == 'desc' ? 'selected' : '' }}>🔴 Plus polluant</option>
                                <option value="asc" {{ request('sort_co2') == 'asc' ? 'selected' : '' }}>🟢 Moins polluant</option>
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
                        @if(request('search') || request('type') || request('sort_co2'))
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
                                                <a href="{{ route('backoffice.showbatiment', $batiment) }}" class="btn btn-sm btn-success" title="Recommandations IA">
                                                    <i class="fas fa-brain"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-warning" title="Modifier" onclick="openEditModalForBatiment({{ $batiment->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
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

    // Gestion des clics sur les boutons d'action (délégation d'événements)
    document.addEventListener('click', function(e) {
        // Bouton Voir les détails
        if (e.target.closest('.btn-info')) {
            const button = e.target.closest('.btn-info');
            const batimentId = button.getAttribute('data-batiment-id');
            if (batimentId) {
                loadBatimentDetails(batimentId);
            }
        }

        // Bouton Modifier
        if (e.target.closest('.btn-warning')) {
            const button = e.target.closest('.btn-warning');
            const batimentId = button.getAttribute('data-batiment-id');
            if (batimentId) {
                openEditModalForBatiment(batimentId);
            }
        }
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
                        <th>Type de zone urbaine:</th>
                        <td>${batiment.type_zone_urbaine ? batiment.type_zone_urbaine.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()) : 'N/A'}</td>
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

        ${(() => {
            let emissionData = batiment.emission_data;
            // S'assurer que emissionData est un objet
            if (typeof emissionData === 'string') {
                try {
                    emissionData = JSON.parse(emissionData);
                } catch (e) {
                    emissionData = {};
                }
            }
            if (!emissionData || typeof emissionData !== 'object' || Object.keys(emissionData).length === 0) {
                return '';
            }
            return `
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="text-danger mb-2"><i class="fas fa-cloud"></i> Sources d'Émissions</h6>
                <div class="mb-0">
                    ${Object.keys(emissionData).map(key => {
                        const data = emissionData[key];
                        const nb = data && data.nb ? data.nb : 0;
                        let unit = '';

                        // Définir les unités selon le type d'émission
                        switch(key) {
                            case 'voiture':
                            case 'moto':
                            case 'bus':
                            case 'camion':
                                unit = 'km';
                                break;
                            case 'avion':
                                unit = 'km';
                                break;
                            case 'electricite':
                                unit = 'kWh';
                                break;
                            case 'gaz':
                                unit = 'm³';
                                break;
                            case 'clim':
                            case 'machine':
                                unit = 'h';
                                break;
                            case 'fumeur':
                                unit = 'cigarettes';
                                break;
                            default:
                                unit = '';
                        }

                        const formattedName = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        return `<span class="badge bg-danger me-1">${formattedName} (${nb}${unit})</span>`;
                    }).join('')}
                </div>
            </div>
        </div>`;
        })()}

        ${(() => {
            let energiesData = batiment.energies_renouvelables_data;
            // S'assurer que energiesData est un objet
            if (typeof energiesData === 'string') {
                try {
                    energiesData = JSON.parse(energiesData);
                } catch (e) {
                    energiesData = {};
                }
            }
            if (!energiesData || typeof energiesData !== 'object' || Object.keys(energiesData).length === 0) {
                return '';
            }
            return `
        <div class="row mt-3">
            <div class="col-12">
                <h6 class="text-success mb-2"><i class="fas fa-sun"></i> Énergies Renouvelables</h6>
                <div class="mb-0">
                    ${Object.keys(energiesData).map(key => {
                        if (key === 'existe') return '';
                        const data = energiesData[key];
                        const nb = data && data.nb ? data.nb : 0;
                        let unit = '';

                        // Définir les unités selon le type d'énergie renouvelable
                        switch(key) {
                            case 'panneaux_solaires':
                                unit = 'kW';
                                break;
                            case 'energie_eolienne':
                                unit = 'MW';
                                break;
                            case 'energie_hydroelectrique':
                                unit = 'TWh';
                                break;
                            case 'voitures_electriques':
                            case 'camions_electriques':
                                unit = 'unités';
                                break;
                            default:
                                unit = '';
                        }

                        const formattedName = key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                        return `<span class="badge bg-success me-1">${formattedName} (${nb} ${unit})</span>`;
                    }).filter(item => item !== '').join('')}
                </div>
            </div>
        </div>`;
        })()}
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
    if (currentDetailsModalInstance) {
        currentDetailsModalInstance.hide();
    }

    // Ouvrir le modal d'édition
    const editModal = new bootstrap.Modal(document.getElementById('editBatimentModal'));
    editModal.show();

    // Charger le formulaire d'édition
    loadEditForm(currentBatimentId);
}

// Fonction pour ouvrir directement le modal d'édition depuis la table
function openEditModalForBatiment(batimentId) {
    currentBatimentId = batimentId;

    // Ouvrir le modal d'édition
    const editModalElement = document.getElementById('editBatimentModal');
    currentEditModalInstance = new bootstrap.Modal(editModalElement);
    currentEditModalInstance.show();

    // Charger le formulaire d'édition
    loadEditForm(batimentId);
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
        // Stocker les données du bâtiment pour la sélection de zone
        window.currentBatiment = data.batiment;

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

    // Parser les données JSON si elles sont sous forme de chaîne
    let emissionData = batiment.emission_data;
    if (typeof emissionData === 'string') {
        try {
            emissionData = JSON.parse(emissionData);
        } catch (e) {
            emissionData = {};
        }
    }

    let energiesData = batiment.energies_renouvelables_data;
    if (typeof energiesData === 'string') {
        try {
            energiesData = JSON.parse(energiesData);
        } catch (e) {
            energiesData = {};
        }
    }

    let recyclageData = batiment.recyclage_data;
    if (typeof recyclageData === 'string') {
        try {
            recyclageData = JSON.parse(recyclageData);
        } catch (e) {
            recyclageData = {};
        }
    }

    const html = `
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="edit_type_batiment" class="form-label">Type de bâtiment <span class="text-danger">*</span></label>
                    <select name="type_batiment" id="edit_type_batiment" class="form-control" required>
                        <option value="">Sélectionner un type</option>
                        <option value="Maison" ${batiment.type_batiment === 'Maison' ? 'selected' : ''}>Maison</option>
                        <option value="Usine" ${batiment.type_batiment === 'Usine' ? 'selected' : ''}>Usine</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="edit_zone_id" class="form-label">État (Gouvernorat) <span class="text-danger">*</span></label>
                    <select name="zone_id" id="edit_zone_id" class="form-control" required>
                        <option value="">Sélectionner un état</option>
                        <!-- Les zones seront chargées dynamiquement -->
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="edit_type_zone_urbaine" class="form-label">Zone Urbaine</label>
                    <select name="type_zone_urbaine" id="edit_type_zone_urbaine" class="form-control">
                        <option value="">Sélectionner une zone urbaine</option>
                        <option value="zone_industrielle" ${batiment.type_zone_urbaine === 'zone_industrielle' ? 'selected' : ''}>Zone Industrielle</option>
                        <option value="quartier_residentiel" ${batiment.type_zone_urbaine === 'quartier_residentiel' ? 'selected' : ''}>Quartier Résidentiel</option>
                        <option value="centre_ville" ${batiment.type_zone_urbaine === 'centre_ville' ? 'selected' : ''}>Centre Ville</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="edit_adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
            <input type="text" name="adresse" id="edit_adresse" class="form-control" value="${batiment.adresse || ''}" placeholder="Entrez l'adresse complète du bâtiment" required>
        </div>

        <!-- Champs spécifiques selon le type de bâtiment -->
        <div id="edit_maison_fields" class="row" style="display: ${batiment.type_batiment === 'Maison' ? 'block' : 'none'};">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="edit_nbHabitants" class="form-label">Nombre d'Habitants</label>
                    <input type="number" name="nbHabitants" id="edit_nbHabitants" class="form-control" value="${batiment.nb_habitants || ''}" placeholder="Entrez le nombre d'habitants" min="1">
                </div>
            </div>
        </div>

        <div id="edit_usine_fields" class="row" style="display: ${batiment.type_batiment === 'Usine' ? 'block' : 'none'};">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="edit_nbEmployes" class="form-label">Nombre d'Employés</label>
                    <input type="number" name="nbEmployes" id="edit_nbEmployes" class="form-control" value="${batiment.nb_employes || ''}" placeholder="Entrez le nombre d'employés" min="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="edit_typeIndustrie" class="form-label">Type d'Industrie</label>
                    <select name="typeIndustrie" id="edit_typeIndustrie" class="form-control">
                        <option value="">Sélectionner un type d'industrie</option>
                        <option value="Alimentaire" ${batiment.type_industrie === 'Alimentaire' ? 'selected' : ''}>Alimentaire</option>
                        <option value="Chimique" ${batiment.type_industrie === 'Chimique' ? 'selected' : ''}>Chimique</option>
                        <option value="Électronique" ${batiment.type_industrie === 'Électronique' ? 'selected' : ''}>Électronique</option>
                        <option value="Mécanique" ${batiment.type_industrie === 'Mécanique' ? 'selected' : ''}>Mécanique</option>
                        <option value="Textile" ${batiment.type_industrie === 'Textile' ? 'selected' : ''}>Textile</option>
                        <option value="Automobile" ${batiment.type_industrie === 'Automobile' ? 'selected' : ''}>Automobile</option>
                        <option value="Pharmaceutique" ${batiment.type_industrie === 'Pharmaceutique' ? 'selected' : ''}>Pharmaceutique</option>
                        <option value="Autre" ${batiment.type_industrie === 'Autre' ? 'selected' : ''}>Autre</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section Émissions CO2 -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Émissions CO2 (t/an)</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Cochez les sources d'émissions et indiquez les quantités mensuelles pour calculer les émissions annuelles de CO2.</p>

                <div class="row">
                    <!-- Transport -->
                    <div class="col-md-6">
                        <h6 class="text-primary">Transport</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_voiture_check" name="emissions[voiture][check]" value="1" ${emissionData && emissionData.voiture ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_voiture_check">
                                Voiture (km/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_voiture_nb" name="emissions[voiture][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.voiture ? emissionData.voiture.nb || '' : ''}" ${emissionData && emissionData.voiture ? '' : 'disabled'}>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_moto_check" name="emissions[moto][check]" value="1" ${emissionData && emissionData.moto ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_moto_check">
                                Moto (km/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_moto_nb" name="emissions[moto][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.moto ? emissionData.moto.nb || '' : ''}" ${emissionData && emissionData.moto ? '' : 'disabled'}>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_bus_check" name="emissions[bus][check]" value="1" ${emissionData && emissionData.bus ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_bus_check">
                                Bus (km/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_bus_nb" name="emissions[bus][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.bus ? emissionData.bus.nb || '' : ''}" ${emissionData && emissionData.bus ? '' : 'disabled'}>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_avion_check" name="emissions[avion][check]" value="1" ${emissionData && emissionData.avion ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_avion_check">
                                Avion (km/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_avion_nb" name="emissions[avion][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.avion ? emissionData.avion.nb || '' : ''}" ${emissionData && emissionData.avion ? '' : 'disabled'}>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_camion_check" name="emissions[camion][check]" value="1" ${emissionData && emissionData.camion ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_camion_check">
                                Camion (km/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_camion_nb" name="emissions[camion][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.camion ? emissionData.camion.nb || '' : ''}" ${emissionData && emissionData.camion ? '' : 'disabled'}>
                        </div>
                    </div>

                    <!-- Énergie et autres -->
                    <div class="col-md-6">
                        <h6 class="text-primary">Énergie & Autres</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_electricite_check" name="emissions[electricite][check]" value="1" ${emissionData && emissionData.electricite ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_electricite_check">
                                Électricité (kWh/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_electricite_nb" name="emissions[electricite][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.electricite ? emissionData.electricite.nb || '' : ''}" ${emissionData && emissionData.electricite ? '' : 'disabled'}>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_gaz_check" name="emissions[gaz][check]" value="1" ${emissionData && emissionData.gaz ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_gaz_check">
                                Gaz (kWh/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_gaz_nb" name="emissions[gaz][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.gaz ? emissionData.gaz.nb || '' : ''}" ${emissionData && emissionData.gaz ? '' : 'disabled'}>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_clim_check" name="emissions[clim][check]" value="1" ${emissionData && emissionData.clim ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_clim_check">
                                Climatisation (kWh/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_clim_nb" name="emissions[clim][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.clim ? emissionData.clim.nb || '' : ''}" ${emissionData && emissionData.clim ? '' : 'disabled'}>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_machine_check" name="emissions[machine][check]" value="1" ${emissionData && emissionData.machine ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_machine_check">
                                Machines (kWh/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_machine_nb" name="emissions[machine][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.machine ? emissionData.machine.nb || '' : ''}" ${emissionData && emissionData.machine ? '' : 'disabled'}>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input emission-checkbox" type="checkbox" id="edit_fumeur_check" name="emissions[fumeur][check]" value="1" ${emissionData && emissionData.fumeur ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_fumeur_check">
                                Fumeur (paquets/mois)
                            </label>
                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="edit_fumeur_nb" name="emissions[fumeur][nb]" placeholder="0" min="0" step="0.1" value="${emissionData && emissionData.fumeur ? emissionData.fumeur.nb || '' : ''}" ${emissionData && emissionData.fumeur ? '' : 'disabled'}>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Énergies Renouvelables -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-success">Énergies Renouvelables</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">Cochez les sources d'énergies renouvelables utilisées et indiquez les quantités produites.</p>

                <div class="row">
                    <!-- Production solaire et éolienne -->
                    <div class="col-md-6">
                        <h6 class="text-success">Production Électrique</h6>
                        <div class="form-check mb-3">
                            <input class="form-check-input renewable-checkbox" type="checkbox" id="edit_panneaux_solares_check" name="energies_renouvelables[panneaux_solaires][check]" value="1" ${energiesData && energiesData.panneaux_solaires ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_panneaux_solares_check">
                                Panneaux Solaires
                            </label>
                            <div class="input-group input-group-sm mt-1">
                                <input type="number" class="form-control renewable-input" id="edit_panneaux_solares_nb" name="energies_renouvelables[panneaux_solaires][nb]" placeholder="0" min="0" step="0.1" value="${energiesData && energiesData.panneaux_solaires ? energiesData.panneaux_solaires.nb || '' : ''}" ${energiesData && energiesData.panneaux_solaires ? '' : 'disabled'}>
                                <div class="input-group-append">
                                    <span class="input-group-text">kW produits</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input renewable-checkbox" type="checkbox" id="edit_energie_eolienne_check" name="energies_renouvelables[energie_eolienne][check]" value="1" ${energiesData && energiesData.energie_eolienne ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_energie_eolienne_check">
                                Énergie Éolienne
                            </label>
                            <div class="input-group input-group-sm mt-1">
                                <input type="number" class="form-control renewable-input" id="edit_energie_eolienne_nb" name="energies_renouvelables[energie_eolienne][nb]" placeholder="0" min="0" step="0.1" value="${energiesData && energiesData.energie_eolienne ? energiesData.energie_eolienne.nb || '' : ''}" ${energiesData && energiesData.energie_eolienne ? '' : 'disabled'}>
                                <div class="input-group-append">
                                    <span class="input-group-text">MW</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input renewable-checkbox" type="checkbox" id="edit_energie_hydroelectrique_check" name="energies_renouvelables[energie_hydroelectrique][check]" value="1" ${energiesData && energiesData.energie_hydroelectrique ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_energie_hydroelectrique_check">
                                Énergie Hydroélectrique
                            </label>
                            <div class="input-group input-group-sm mt-1">
                                <input type="number" class="form-control renewable-input" id="edit_energie_hydroelectrique_nb" name="energies_renouvelables[energie_hydroelectrique][nb]" placeholder="0" min="0" step="0.1" value="${energiesData && energiesData.energie_hydroelectrique ? energiesData.energie_hydroelectrique.nb || '' : ''}" ${energiesData && energiesData.energie_hydroelectrique ? '' : 'disabled'}>
                                <div class="input-group-append">
                                    <span class="input-group-text">TWh</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Véhicules électriques -->
                    <div class="col-md-6">
                        <h6 class="text-success">Véhicules Électriques</h6>
                        <div class="form-check mb-3">
                            <input class="form-check-input renewable-checkbox" type="checkbox" id="edit_voitures_electriques_check" name="energies_renouvelables[voitures_electriques][check]" value="1" ${energiesData && energiesData.voitures_electriques ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_voitures_electriques_check">
                                Voitures Électriques
                            </label>
                            <div class="input-group input-group-sm mt-1">
                                <input type="number" class="form-control renewable-input" id="edit_voitures_electriques_nb" name="energies_renouvelables[voitures_electriques][nb]" placeholder="0" min="0" step="0.1" value="${energiesData && energiesData.voitures_electriques ? energiesData.voitures_electriques.nb || '' : ''}" ${energiesData && energiesData.voitures_electriques ? '' : 'disabled'}>
                                <div class="input-group-append">
                                    <span class="input-group-text">km/mois</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input renewable-checkbox" type="checkbox" id="edit_camions_electriques_check" name="energies_renouvelables[camions_electriques][check]" value="1" ${energiesData && energiesData.camions_electriques ? 'checked' : ''}>
                            <label class="form-check-label" for="edit_camions_electriques_check">
                                Camions Électriques
                            </label>
                            <div class="input-group input-group-sm mt-1">
                                <input type="number" class="form-control renewable-input" id="edit_camions_electriques_nb" name="energies_renouvelables[camions_electriques][nb]" placeholder="0" min="0" step="0.1" value="${energiesData && energiesData.camions_electriques ? energiesData.camions_electriques.nb || '' : ''}" ${energiesData && energiesData.camions_electriques ? '' : 'disabled'}>
                                <div class="input-group-append">
                                    <span class="input-group-text">km/mois</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Recyclage des produits -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">Recyclage des Produits</h6>
            </div>
            <div class="card-body">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="edit_recyclage_existe" name="recyclage[existe]" value="1" ${recyclageData && recyclageData.existe ? 'checked' : ''}>
                    <label class="form-check-label" for="edit_recyclage_existe">
                        <strong>Le bâtiment pratique le recyclage</strong>
                    </label>
                </div>

                <div id="edit_recyclage_options" style="display: ${recyclageData && recyclageData.existe ? 'block' : 'none'};">
                    <p class="text-muted small">Cochez les types de produits recyclés et indiquez les quantités (en kg/mois).</p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_papier_carton_check" name="recyclage[produit_recycle][]" value="Papier/Carton" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Papier/Carton') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_papier_carton_check">
                                    Papier/Carton
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Papier/Carton]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Papier/Carton'] ? recyclageData.quantites['Papier/Carton'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Papier/Carton') ? '' : 'disabled'}>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_plastique_check" name="recyclage[produit_recycle][]" value="Plastique" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Plastique') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_plastique_check">
                                    Plastique
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Plastique]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Plastique'] ? recyclageData.quantites['Plastique'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Plastique') ? '' : 'disabled'}>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_verre_check" name="recyclage[produit_recycle][]" value="Verre" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Verre') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_verre_check">
                                    Verre
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Verre]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Verre'] ? recyclageData.quantites['Verre'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Verre') ? '' : 'disabled'}>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_metal_check" name="recyclage[produit_recycle][]" value="Métal" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Métal') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_metal_check">
                                    Métal
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Métal]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Métal'] ? recyclageData.quantites['Métal'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Métal') ? '' : 'disabled'}>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_dechets_organiques_check" name="recyclage[produit_recycle][]" value="Déchets Organiques" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Déchets Organiques') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_dechets_organiques_check">
                                    Déchets Organiques
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Déchets Organiques]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Déchets Organiques'] ? recyclageData.quantites['Déchets Organiques'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Déchets Organiques') ? '' : 'disabled'}>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_dechets_electroniques_check" name="recyclage[produit_recycle][]" value="Déchets Électroniques" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Déchets Électroniques') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_dechets_electroniques_check">
                                    Déchets Électroniques
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Déchets Électroniques]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Déchets Électroniques'] ? recyclageData.quantites['Déchets Électroniques'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Déchets Électroniques') ? '' : 'disabled'}>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_textile_check" name="recyclage[produit_recycle][]" value="Textile" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Textile') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_textile_check">
                                    Textile
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Textile]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Textile'] ? recyclageData.quantites['Textile'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Textile') ? '' : 'disabled'}>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_bois_check" name="recyclage[produit_recycle][]" value="Bois" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Bois') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_bois_check">
                                    Bois
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Bois]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Bois'] ? recyclageData.quantites['Bois'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Bois') ? '' : 'disabled'}>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_batteries_check" name="recyclage[produit_recycle][]" value="Batteries" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Batteries') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_batteries_check">
                                    Batteries
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Batteries]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Batteries'] ? recyclageData.quantites['Batteries'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Batteries') ? '' : 'disabled'}>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="edit_autre_check" name="recyclage[produit_recycle][]" value="Autre" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Autre') ? 'checked' : ''}>
                                <label class="form-check-label" for="edit_autre_check">
                                    Autre
                                </label>
                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Autre]" placeholder="0" min="0" step="0.1" value="${recyclageData && recyclageData.quantites && recyclageData.quantites['Autre'] ? recyclageData.quantites['Autre'] : ''}" ${recyclageData && recyclageData.produit_recycle && recyclageData.produit_recycle.includes('Autre') ? '' : 'disabled'}>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="batiment_id" value="${batiment.id}">
    `;

    modalBody.innerHTML = html;

    // Charger les zones dynamiquement avec la zone actuelle sélectionnée
    console.log('Batiment zone_id:', batiment.zone_id);
    loadZonesForEdit(batiment.zone_id);

    // Initialiser les événements JavaScript pour le formulaire d'édition
    initializeEditFormEvents();
}

// Fonction pour initialiser les événements du formulaire d'édition
function initializeEditFormEvents() {
    // Gestion du changement de type de bâtiment
    const typeBatimentSelect = document.getElementById('edit_type_batiment');
    if (typeBatimentSelect) {
        typeBatimentSelect.addEventListener('change', function() {
            const type = this.value;
            const maisonFields = document.getElementById('edit_maison_fields');
            const usineFields = document.getElementById('edit_usine_fields');

            if (maisonFields) maisonFields.style.display = type === 'Maison' ? 'block' : 'none';
            if (usineFields) usineFields.style.display = type === 'Usine' ? 'block' : 'none';
        });
    }

    // Gestion des checkboxes d'émissions
    const emissionCheckboxes = document.querySelectorAll('.emission-checkbox');
    emissionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const inputId = this.id.replace('_check', '_nb');
            const input = document.getElementById(inputId);
            if (input) {
                input.disabled = !this.checked;
                if (!this.checked) {
                    input.value = '';
                }
            }
        });
    });

    // Gestion des checkboxes d'énergies renouvelables
    const renewableCheckboxes = document.querySelectorAll('.renewable-checkbox');
    renewableCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const inputId = this.id.replace('_check', '_nb');
            const input = document.getElementById(inputId);
            if (input) {
                input.disabled = !this.checked;
                if (!this.checked) {
                    input.value = '';
                }
            }
        });
    });

    // Gestion de la checkbox de recyclage principal
    const recyclageExisteCheckbox = document.getElementById('edit_recyclage_existe');
    if (recyclageExisteCheckbox) {
        recyclageExisteCheckbox.addEventListener('change', function() {
            const recyclageOptions = document.getElementById('edit_recyclage_options');
            if (recyclageOptions) {
                recyclageOptions.style.display = this.checked ? 'block' : 'none';
                if (!this.checked) {
                    // Désactiver tous les champs de recyclage
                    document.querySelectorAll('.recyclage-checkbox').forEach(cb => {
                        cb.checked = false;
                        const inputId = cb.id.replace('_check', '_nb');
                        const input = document.getElementById(inputId);
                        if (input) {
                            input.disabled = true;
                            input.value = '';
                        }
                    });
                }
            }
        });
    }

    // Gestion des checkboxes de recyclage individuelles
    const recyclageCheckboxes = document.querySelectorAll('.recyclage-checkbox');
    recyclageCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const inputName = this.value;
            const input = document.querySelector(`input[name="recyclage[quantites][${inputName}]"]`);
            if (input) {
                input.disabled = !this.checked;
                if (!this.checked) {
                    input.value = '';
                }
            }
        });
    });
}

// Fonction pour charger les zones pour le formulaire d'édition
function loadZonesForEdit(currentZoneId = null) {
    console.log('Loading zones for edit, current zone ID:', currentZoneId);
    fetch('/api/zones')
        .then(response => response.json())
        .then(data => {
            const zoneSelect = document.getElementById('edit_zone_id');
            if (zoneSelect && data.zones) {
                zoneSelect.innerHTML = '<option value="">Sélectionner un état</option>';
                data.zones.forEach(zone => {
                    const option = document.createElement('option');
                    option.value = zone.id;
                    option.textContent = zone.nom;
                    // Sélectionner la zone actuelle si elle existe
                    if (currentZoneId && currentZoneId == zone.id) {
                        option.selected = true;
                        console.log('Selected zone:', zone.nom, 'ID:', zone.id);
                    }
                    zoneSelect.appendChild(option);
                });
                console.log('Zones loaded, selected zone ID:', zoneSelect.value);
            }
        })
        .catch(error => {
            console.error('Erreur lors du chargement des zones:', error);
        });
}

// Variable pour stocker les données actuelles du bâtiment
let currentBatimentData = null;

// Variable pour stocker l'instance du modal d'édition
let currentEditModalInstance = null;

// Variable pour stocker l'instance du modal de détails
let currentDetailsModalInstance = null;

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
    currentDetailsModalInstance = new bootstrap.Modal(document.getElementById('batimentModal'));
    currentDetailsModalInstance.show();

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
        if (currentEditModalInstance) {
            currentEditModalInstance.hide();
        }

        // Actualiser la page pour voir les changements
        location.reload();
    })
    .catch(error => {
        console.error('Erreur lors de la sauvegarde:', error);
        alert('Erreur lors de la sauvegarde des modifications.');
    });
});

// Initialisation des gestionnaires d'événements pour les modals
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire pour le modal d'édition avec jQuery (Bootstrap 4)
    $('#editBatimentModal').on('show.bs.modal', function() {
        // Créer l'instance du modal quand il s'ouvre
        currentEditModalInstance = $(this).data('bs.modal') || new bootstrap.Modal(this);
    });

    $('#editBatimentModal').on('hidden.bs.modal', function() {
        // Réinitialiser l'instance quand le modal se ferme
        currentEditModalInstance = null;
        currentBatimentId = null;
    });

    // Gestionnaire pour le modal de détails avec jQuery (Bootstrap 4)
    $('#batimentModal').on('show.bs.modal', function() {
        // Créer l'instance du modal quand il s'ouvre
        currentDetailsModalInstance = $(this).data('bs.modal') || new bootstrap.Modal(this);
    });

    $('#batimentModal').on('hidden.bs.modal', function() {
        // Réinitialiser l'instance quand le modal se ferme
        currentDetailsModalInstance = null;
    });

    // S'assurer que les boutons de fermeture fonctionnent pour les deux modals
    const allCloseButtons = document.querySelectorAll('#editBatimentModal .close, #editBatimentModal .btn-secondary[data-dismiss="modal"], #batimentModal .close, #batimentModal .btn-secondary[data-dismiss="modal"]');
    allCloseButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const modalId = this.closest('.modal').id;

            if (modalId === 'editBatimentModal') {
                if (currentEditModalInstance) {
                    currentEditModalInstance.hide();
                } else {
                    $('#editBatimentModal').modal('hide');
                }
            } else if (modalId === 'batimentModal') {
                if (currentDetailsModalInstance) {
                    currentDetailsModalInstance.hide();
                } else {
                    $('#batimentModal').modal('hide');
                }
            }
        });
    });
});

// Soumission automatique du formulaire lors du changement de tri
document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('sort-co2');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            document.getElementById('search-form').submit();
        });
    }
});
</script>
@endsection