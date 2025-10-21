@extends('admin_dashboard.layout')

@section('title', 'Détails de la Zone Urbaine')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Détails de la Zone: {{ $zone->nom }}</h1>
        <div>
            <a href="{{ route('admin.zones.edit', $zone) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Modifier
            </a>
            <a href="{{ route('admin.zones.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informations de la zone -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations Générales</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nom</label>
                                <p>{{ $zone->nom }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Surface Totale</label>
                                <p>{{ $zone->surface ? number_format($zone->surface, 2, ',', ' ') . ' m²' : 'Non spécifiée' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">ID</label>
                                <p>{{ $zone->id }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Date de création</label>
                                <p>{{ $zone->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques des bâtiments -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Statistiques des Bâtiments</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $stats['total_batiments'] }}</div>
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Bâtiments</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_emissions'], 2) }}</div>
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Émissions CO₂ (kg/an)</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $stats['total_employes'] }}</div>
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Employés</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $stats['total_habitants'] }}</div>
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Habitants</div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Moyenne Énergie Renouvelable</label>
                                <p>{{ number_format($stats['moyenne_renouvelable'], 1) }}%</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Arbres Recommandés</label>
                                <p>{{ $zone->getNbArbresBesoinAttribute() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions et informations -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Actions</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.zones.edit', $zone) }}" class="btn btn-warning btn-block mb-2">
                        <i class="fas fa-edit"></i> Modifier la zone
                    </a>
                    <form action="{{ route('admin.zones.destroy', $zone) }}" method="POST" class="d-inline w-100">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ? Cette action est irréversible.')">
                            <i class="fas fa-trash"></i> Supprimer la zone
                        </button>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-secondary">Informations Système</h6>
                </div>
                <div class="card-body">
                    <p><strong>Dernière modification :</strong><br>
                    {{ $zone->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des bâtiments -->
    @if($batiments->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Bâtiments dans cette zone ({{ $batiments->count() }})</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Émissions CO₂</th>
                            <th>Énergie Renouvelable</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($batiments as $batiment)
                        <tr>
                            <td>{{ $batiment->id }}</td>
                            <td>{{ $batiment->nom }}</td>
                            <td>{{ number_format($batiment->emission_c_o2, 2) }} kg/an</td>
                            <td>{{ $batiment->pourcentage_renouvelable }}%</td>
                            <td>
                                <a href="{{ route('backoffice.showbatiment', $batiment) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection