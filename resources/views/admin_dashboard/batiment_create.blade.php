@extends('admin_dashboard.layout')

@section('title', isset($batiment) ? 'Modifier un Bâtiment' : 'Ajouter un Bâtiment')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ isset($batiment) ? 'Modifier un Bâtiment' : 'Ajouter un Bâtiment' }}</h1>
        <a href="{{ route('backoffice.indexbatiment') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-8 col-lg-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations du bâtiment</h6>
                </div>
                <div class="card-body">
                    <form action="{{ isset($batiment) ? route('backoffice.updatebatiment', $batiment) : route('backoffice.storebatiment') }}" method="POST">
                        @csrf
                        @if(isset($batiment))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="type_batiment" class="form-label">Type de bâtiment <span class="text-danger">*</span></label>
                                    <select name="type_batiment" id="type_batiment" class="form-control @error('type_batiment') is-invalid @enderror" required>
                                        <option value="">Sélectionner un type</option>
                                        <option value="Maison" {{ (old('type_batiment') ?? $batiment->type_batiment ?? '') == 'Maison' ? 'selected' : '' }}>Maison</option>
                                        <option value="Usine" {{ (old('type_batiment') ?? $batiment->type_batiment ?? '') == 'Usine' ? 'selected' : '' }}>Usine</option>
                                    </select>
                                    @error('type_batiment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="zone_id" class="form-label">État (Gouvernorat) <span class="text-danger">*</span></label>
                                    <select name="zone_id" id="zone_id" class="form-control @error('zone_id') is-invalid @enderror" required>
                                        <option value="">Sélectionner un état</option>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}" {{ (old('zone_id') ?? $batiment->zone_id ?? '') == $zone->id ? 'selected' : '' }}>
                                                {{ $zone->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('zone_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="type_zone_urbaine" class="form-label">Zone Urbaine</label>
                                    <select name="type_zone_urbaine" id="type_zone_urbaine" class="form-control @error('type_zone_urbaine') is-invalid @enderror">
                                        <option value="">Sélectionner une zone urbaine</option>
                                        @foreach($typesZoneUrbaine as $key => $label)
                                            <option value="{{ $key }}" {{ (old('type_zone_urbaine') ?? $batiment->type_zone_urbaine ?? '') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type_zone_urbaine')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                            <input type="text" name="adresse" id="adresse" class="form-control @error('adresse') is-invalid @enderror"
                                   value="{{ old('adresse') ?? ($batiment->adresse ?? '') }}" placeholder="Entrez l'adresse complète du bâtiment" required>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Champs spécifiques selon le type de bâtiment -->
                        <div id="maison-fields" class="row" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nbHabitants" class="form-label">Nombre d'Habitants</label>
                                    <input type="number" name="nbHabitants" id="nbHabitants" class="form-control @error('nbHabitants') is-invalid @enderror"
                                           value="{{ old('nbHabitants') ?? ($batiment->nb_habitants ?? '') }}" placeholder="Entrez le nombre d'habitants" min="1">
                                    @error('nbHabitants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div id="usine-fields" class="row" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nbEmployes" class="form-label">Nombre d'Employés</label>
                                    <input type="number" name="nbEmployes" id="nbEmployes" class="form-control @error('nbEmployes') is-invalid @enderror"
                                           value="{{ old('nbEmployes') ?? ($batiment->nb_employes ?? '') }}" placeholder="Entrez le nombre d'employés" min="1">
                                    @error('nbEmployes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="typeIndustrie" class="form-label">Type d'Industrie</label>
                                    <select name="typeIndustrie" id="typeIndustrie" class="form-control @error('typeIndustrie') is-invalid @enderror">
                                        <option value="">Sélectionner un type d'industrie</option>
                                        <option value="Alimentaire" {{ (old('typeIndustrie') ?? $batiment->type_industrie ?? '') == 'Alimentaire' ? 'selected' : '' }}>Alimentaire</option>
                                        <option value="Chimique" {{ (old('typeIndustrie') ?? $batiment->type_industrie ?? '') == 'Chimique' ? 'selected' : '' }}>Chimique</option>
                                        <option value="Électronique" {{ (old('typeIndustrie') ?? $batiment->type_industrie ?? '') == 'Électronique' ? 'selected' : '' }}>Électronique</option>
                                        <option value="Mécanique" {{ (old('typeIndustrie') ?? $batiment->type_industrie ?? '') == 'Mécanique' ? 'selected' : '' }}>Mécanique</option>
                                        <option value="Textile" {{ (old('typeIndustrie') ?? $batiment->type_industrie ?? '') == 'Textile' ? 'selected' : '' }}>Textile</option>
                                        <option value="Automobile" {{ (old('typeIndustrie') ?? $batiment->type_industrie ?? '') == 'Automobile' ? 'selected' : '' }}>Automobile</option>
                                        <option value="Pharmaceutique" {{ (old('typeIndustrie') ?? $batiment->type_industrie ?? '') == 'Pharmaceutique' ? 'selected' : '' }}>Pharmaceutique</option>
                                        <option value="Autre" {{ (old('typeIndustrie') ?? $batiment->type_industrie ?? '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                    @error('typeIndustrie')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="voiture_check" name="emissions[voiture][check]" value="1">
                                            <label class="form-check-label" for="voiture_check">
                                                Voiture (km/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="voiture_nb" name="emissions[voiture][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="moto_check" name="emissions[moto][check]" value="1">
                                            <label class="form-check-label" for="moto_check">
                                                Moto (km/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="moto_nb" name="emissions[moto][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="bus_check" name="emissions[bus][check]" value="1">
                                            <label class="form-check-label" for="bus_check">
                                                Bus (km/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="bus_nb" name="emissions[bus][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="avion_check" name="emissions[avion][check]" value="1">
                                            <label class="form-check-label" for="avion_check">
                                                Avion (km/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="avion_nb" name="emissions[avion][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="camion_check" name="emissions[camion][check]" value="1">
                                            <label class="form-check-label" for="camion_check">
                                                Camion (km/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="camion_nb" name="emissions[camion][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                    </div>

                                    <!-- Énergie et autres -->
                                    <div class="col-md-6">
                                        <h6 class="text-primary">Énergie & Autres</h6>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="electricite_check" name="emissions[electricite][check]" value="1">
                                            <label class="form-check-label" for="electricite_check">
                                                Électricité (kWh/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="electricite_nb" name="emissions[electricite][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="gaz_check" name="emissions[gaz][check]" value="1">
                                            <label class="form-check-label" for="gaz_check">
                                                Gaz (kWh/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="gaz_nb" name="emissions[gaz][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="clim_check" name="emissions[clim][check]" value="1">
                                            <label class="form-check-label" for="clim_check">
                                                Climatisation (kWh/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="clim_nb" name="emissions[clim][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="machine_check" name="emissions[machine][check]" value="1">
                                            <label class="form-check-label" for="machine_check">
                                                Machines (kWh/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="machine_nb" name="emissions[machine][nb]" placeholder="0" min="0" step="0.1" disabled>
                                        </div>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input emission-checkbox" type="checkbox" id="fumeur_check" name="emissions[fumeur][check]" value="1">
                                            <label class="form-check-label" for="fumeur_check">
                                                Fumeur (paquets/mois)
                                            </label>
                                            <input type="number" class="form-control form-control-sm mt-1 emission-input" id="fumeur_nb" name="emissions[fumeur][nb]" placeholder="0" min="0" step="0.1" disabled>
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
                                            <input class="form-check-input renewable-checkbox" type="checkbox" id="panneaux_solares_check" name="energies_renouvelables[panneaux_solaires][check]" value="1">
                                            <label class="form-check-label" for="panneaux_solares_check">
                                                Panneaux Solaires
                                            </label>
                                            <div class="input-group input-group-sm mt-1">
                                                <input type="number" class="form-control renewable-input" id="panneaux_solares_nb" name="energies_renouvelables[panneaux_solaires][nb]" placeholder="0" min="0" step="0.1" disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">kW produits</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input renewable-checkbox" type="checkbox" id="energie_eolienne_check" name="energies_renouvelables[energie_eolienne][check]" value="1">
                                            <label class="form-check-label" for="energie_eolienne_check">
                                                Énergie Éolienne
                                            </label>
                                            <div class="input-group input-group-sm mt-1">
                                                <input type="number" class="form-control renewable-input" id="energie_eolienne_nb" name="energies_renouvelables[energie_eolienne][nb]" placeholder="0" min="0" step="0.1" disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">MW</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input renewable-checkbox" type="checkbox" id="energie_hydroelectrique_check" name="energies_renouvelables[energie_hydroelectrique][check]" value="1">
                                            <label class="form-check-label" for="energie_hydroelectrique_check">
                                                Énergie Hydroélectrique
                                            </label>
                                            <div class="input-group input-group-sm mt-1">
                                                <input type="number" class="form-control renewable-input" id="energie_hydroelectrique_nb" name="energies_renouvelables[energie_hydroelectrique][nb]" placeholder="0" min="0" step="0.1" disabled>
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
                                            <input class="form-check-input renewable-checkbox" type="checkbox" id="voitures_electriques_check" name="energies_renouvelables[voitures_electriques][check]" value="1">
                                            <label class="form-check-label" for="voitures_electriques_check">
                                                Voitures Électriques
                                            </label>
                                            <div class="input-group input-group-sm mt-1">
                                                <input type="number" class="form-control renewable-input" id="voitures_electriques_nb" name="energies_renouvelables[voitures_electriques][nb]" placeholder="0" min="0" step="0.1" disabled>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">km/mois</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input renewable-checkbox" type="checkbox" id="camions_electriques_check" name="energies_renouvelables[camions_electriques][check]" value="1">
                                            <label class="form-check-label" for="camions_electriques_check">
                                                Camions Électriques
                                            </label>
                                            <div class="input-group input-group-sm mt-1">
                                                <input type="number" class="form-control renewable-input" id="camions_electriques_nb" name="energies_renouvelables[camions_electriques][nb]" placeholder="0" min="0" step="0.1" disabled>
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
                                    <input class="form-check-input" type="checkbox" id="recyclage_existe" name="recyclage[existe]" value="1">
                                    <label class="form-check-label" for="recyclage_existe">
                                        <strong>Le bâtiment pratique le recyclage</strong>
                                    </label>
                                </div>

                                <div id="recyclage-options" style="display: none;">
                                    <p class="text-muted small">Cochez les types de produits recyclés et indiquez les quantités (en kg/mois).</p>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="papier_carton_check" name="recyclage[produit_recycle][]" value="Papier/Carton">
                                                <label class="form-check-label" for="papier_carton_check">
                                                    Papier/Carton
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Papier/Carton]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="plastique_check" name="recyclage[produit_recycle][]" value="Plastique">
                                                <label class="form-check-label" for="plastique_check">
                                                    Plastique
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Plastique]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="verre_check" name="recyclage[produit_recycle][]" value="Verre">
                                                <label class="form-check-label" for="verre_check">
                                                    Verre
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Verre]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="metal_check" name="recyclage[produit_recycle][]" value="Métal">
                                                <label class="form-check-label" for="metal_check">
                                                    Métal
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Métal]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="dechets_organiques_check" name="recyclage[produit_recycle][]" value="Déchets Organiques">
                                                <label class="form-check-label" for="dechets_organiques_check">
                                                    Déchets Organiques
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Déchets Organiques]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="dechets_electroniques_check" name="recyclage[produit_recycle][]" value="Déchets Électroniques">
                                                <label class="form-check-label" for="dechets_electroniques_check">
                                                    Déchets Électroniques
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Déchets Électroniques]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="textile_check" name="recyclage[produit_recycle][]" value="Textile">
                                                <label class="form-check-label" for="textile_check">
                                                    Textile
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Textile]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="bois_check" name="recyclage[produit_recycle][]" value="Bois">
                                                <label class="form-check-label" for="bois_check">
                                                    Bois
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Bois]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="batteries_check" name="recyclage[produit_recycle][]" value="Batteries">
                                                <label class="form-check-label" for="batteries_check">
                                                    Batteries
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Batteries]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input recyclage-checkbox" type="checkbox" id="autre_check" name="recyclage[produit_recycle][]" value="Autre">
                                                <label class="form-check-label" for="autre_check">
                                                    Autre
                                                </label>
                                                <input type="number" class="form-control form-control-sm mt-1 recyclage-input" name="recyclage[quantites][Autre]" placeholder="0" min="0" step="0.1" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Option IA -->
                        <div class="card mt-4 border-warning">
                            <div class="card-header bg-warning text-white">
                                <h6 class="m-0 font-weight-bold">
                                    <i class="fas fa-robot"></i> Prédiction Intelligente (Optionnel)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="use_ai_prediction" name="use_ai_prediction" value="1" {{ old('use_ai_prediction') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="use_ai_prediction">
                                        <strong>Utiliser l'Intelligence Artificielle pour prédire les émissions</strong>
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    Si activé, l'IA analysera les données saisies (type de bâtiment, émissions, énergies renouvelables, recyclage)
                                    pour prédire automatiquement les valeurs d'émissions CO2, pourcentage d'énergie renouvelable et émissions réelles.
                                    Sinon, les calculs traditionnels seront utilisés.
                                </small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('backoffice.indexbatiment') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le bâtiment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gérer l'activation/désactivation des champs d'émissions
    const checkboxes = document.querySelectorAll('.emission-checkbox');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const formCheck = this.closest('.form-check');
            const input = formCheck.querySelector('.emission-input');

            if (this.checked) {
                input.disabled = false;
                input.focus();
            } else {
                input.disabled = true;
                input.value = '';
            }
        });
    });

    // Gérer l'activation/désactivation des champs d'énergies renouvelables
    const renewableCheckboxes = document.querySelectorAll('.renewable-checkbox');
    
    renewableCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const formCheck = this.closest('.form-check');
            const input = formCheck.querySelector('.renewable-input');
            
            if (this.checked) {
                input.disabled = false;
                input.focus();
            } else {
                input.disabled = true;
                input.value = '';
            }
        });
    });

    // Gérer l'affichage des options de recyclage
    const recyclageExiste = document.getElementById('recyclage_existe');
    const recyclageOptions = document.getElementById('recyclage-options');
    
    if (recyclageExiste && recyclageOptions) {
        recyclageExiste.addEventListener('change', function() {
            if (this.checked) {
                recyclageOptions.style.display = 'block';
            } else {
                recyclageOptions.style.display = 'none';
                // Désactiver tous les inputs de recyclage
                const recyclageInputs = document.querySelectorAll('.recyclage-input');
                const recyclageCheckboxes = document.querySelectorAll('.recyclage-checkbox');
                
                recyclageInputs.forEach(function(input) {
                    input.disabled = true;
                    input.value = '';
                });
                
                recyclageCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            }
        });
    }

    // Gérer l'activation/désactivation des champs de recyclage individuels
    const recyclageCheckboxes = document.querySelectorAll('.recyclage-checkbox');
    
    recyclageCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const container = this.closest('.form-check');
            const input = container.querySelector('.recyclage-input');
            
            if (this.checked) {
                input.disabled = false;
                input.focus();
            } else {
                input.disabled = true;
                input.value = '';
            }
        });
    });

    // Gérer le changement de type de bâtiment
    const typeBatiment = document.getElementById('type_batiment');
    if (typeBatiment) {
        typeBatiment.addEventListener('change', function() {
            const type = this.value;
            const maisonFields = document.getElementById('maison-fields');
            const usineFields = document.getElementById('usine-fields');

            if (type === 'Maison') {
                if (maisonFields) maisonFields.style.display = 'block';
                if (usineFields) usineFields.style.display = 'none';
            } else if (type === 'Usine') {
                if (maisonFields) maisonFields.style.display = 'none';
                if (usineFields) usineFields.style.display = 'block';
            } else {
                if (maisonFields) maisonFields.style.display = 'none';
                if (usineFields) usineFields.style.display = 'none';
            }
        });

        // Déclencher le changement au chargement de la page
        typeBatiment.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection