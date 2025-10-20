@extends('admin_dashboard.layout')

@section('title', 'Détails du Bâtiment')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails du Bâtiment</h1>
        <div>
            <a href="{{ route('backoffice.indexbatiment') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm mr-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
            </a>
            <a href="{{ route('backoffice.editbatiment', $batiment->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informations générales -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations Générales</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Type de bâtiment:</strong> {{ $batiment->type_batiment }}</p>
                            <p><strong>Adresse:</strong> {{ $batiment->adresse }}</p>
                            <p><strong>Zone urbaine:</strong> {{ $batiment->type_zone_urbaine_formatted }}</p>
                            @if($batiment->zone)
                                <p><strong>Zone associée:</strong> {{ $batiment->zone->nom }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($batiment->nb_habitants)
                                <p><strong>Nombre d'habitants:</strong> {{ $batiment->nb_habitants }}</p>
                            @endif
                            @if($batiment->nb_employes)
                                <p><strong>Nombre d'employés:</strong> {{ $batiment->nb_employes }}</p>
                            @endif
                            @if($batiment->type_industrie && $batiment->type_industrie !== 'général')
                                <p><strong>Type d'industrie:</strong> {{ $batiment->type_industrie }}</p>
                            @endif
                            <p><strong>Propriétaire:</strong> {{ $batiment->user->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Métriques environnementales -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Métriques Environnementales</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-left-primary">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Émissions CO2 (tonnes/an)
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($batiment->emission_c_o2, 2) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-success">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Énergie Renouvelable
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($batiment->pourcentage_renouvelable, 1) }}%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-left-warning">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Émissions Réelles
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($batiment->emission_reelle, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card border-left-info">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Arbres Nécessaires
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($batiment->nb_arbres_besoin) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-left-danger">
                                <div class="card-body">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Réduction CO2
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($batiment->emission_c_o2 - $batiment->emission_reelle, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Équipements et pratiques -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Équipements et Pratiques Écologiques</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Énergies Renouvelables</h6>
                            @if($batiment->energies_renouvelables_data && !empty($batiment->energies_renouvelables_data))
                                <ul class="list-group list-group-flush">
                                    @foreach($batiment->energies_renouvelables_data as $key => $value)
                                        @if($value === true || $value === "true" || $value === 1 || $value === "1")
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                                                <span class="badge badge-success badge-pill"><i class="fas fa-check"></i></span>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Aucune énergie renouvelable installée</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Pratiques de Recyclage</h6>
                            @if($batiment->recyclage_data && !empty($batiment->recyclage_data) && isset($batiment->recyclage_data['existe']) && $batiment->recyclage_data['existe'])
                                @if(isset($batiment->recyclage_data['quantites']) && is_array($batiment->recyclage_data['quantites']))
                                    <ul class="list-group list-group-flush">
                                        @foreach($batiment->recyclage_data['quantites'] as $type => $quantite)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ ucfirst($type) }}
                                                <span class="badge badge-primary badge-pill">{{ $quantite }} kg/mois</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-success"><i class="fas fa-check-circle"></i> Système de recyclage en place</p>
                                @endif
                            @else
                                <p class="text-muted">Aucune pratique de recyclage déclarée</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommandations IA -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">🧠 Recommandations IA</h6>
                    <button class="btn btn-sm btn-outline-primary" onclick="generateRecommendations()">
                        <i class="fas fa-sync-alt"></i> Régénérer
                    </button>
                </div>
                <div class="card-body" id="recommendations-content">
                    @php
                        $recommendations = $batiment->generateNatureProtectionRecommendations();
                    @endphp

                    <!-- Recommandations principales -->
                    <div class="mb-3">
                        <h6 class="text-primary"><i class="fas fa-star"></i> Recommandations Principales</h6>
                        <ul class="list-unstyled">
                            @foreach($recommendations['recommandations_principales'] as $rec)
                                <li class="mb-2">
                                    <i class="fas fa-leaf text-success mr-2"></i>
                                    {{ $rec }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Actions courte terme -->
                    <div class="mb-3">
                        <h6 class="text-warning"><i class="fas fa-clock"></i> Actions Courte Terme</h6>
                        <ul class="list-unstyled">
                            @foreach($recommendations['actions_courte_terme'] as $action)
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-warning mr-2"></i>
                                    {{ $action }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Actions longue terme -->
                    <div class="mb-3">
                        <h6 class="text-info"><i class="fas fa-road"></i> Actions Long Terme</h6>
                        <ul class="list-unstyled">
                            @foreach($recommendations['actions_long_terme'] as $action)
                                <li class="mb-2">
                                    <i class="fas fa-long-arrow-alt-right text-info mr-2"></i>
                                    {{ $action }}
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Impact estimé -->
                    <div class="mb-3">
                        <h6 class="text-success"><i class="fas fa-chart-line"></i> Impact Estimé</h6>
                        <p class="text-muted small">{{ $recommendations['impact_estime'] }}</p>
                    </div>

                    <!-- Coût estimé -->
                    <div class="mb-3">
                        <h6 class="text-warning"><i class="fas fa-money-bill-wave"></i> Coût Estimé (TND)</h6>
                        <p class="text-muted small">{{ $recommendations['cout_estime'] }}</p>
                    </div>

                    <!-- Durée d'implémentation -->
                    <div class="mb-3">
                        <h6 class="text-info"><i class="fas fa-calendar-alt"></i> Durée d'Implémentation</h6>
                        <p class="text-muted small">{{ $recommendations['duree_implementation'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Actions Rapides</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-sm" onclick="printRecommendations()">
                            <i class="fas fa-print"></i> Imprimer Recommandations
                        </button>
                        <button class="btn btn-info btn-sm" onclick="shareRecommendations()">
                            <i class="fas fa-share"></i> Partager
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="createActionPlan()">
                            <i class="fas fa-tasks"></i> Créer Plan d'Action
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function generateRecommendations() {
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Génération...';
    button.disabled = true;

    // Recharger la page pour régénérer les recommandations
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function printRecommendations() {
    window.print();
}

function shareRecommendations() {
    if (navigator.share) {
        navigator.share({
            title: 'Recommandations UrbanGreen - {{ $batiment->type_batiment }} à {{ $batiment->adresse }}',
            text: 'Découvrez les recommandations IA pour améliorer l\'impact environnemental de ce bâtiment.',
            url: window.location.href
        });
    } else {
        // Fallback: copier l'URL dans le presse-papiers
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Lien copié dans le presse-papiers !');
        });
    }
}

function createActionPlan() {
    // Rediriger vers une page de création de plan d'action (à implémenter)
    alert('Fonctionnalité de création de plan d\'action à venir !');
}
</script>

<style>
@media print {
    .card-header button,
    .d-grid {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
@endsection