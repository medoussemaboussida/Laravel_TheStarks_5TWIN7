@extends('admin_dashboard.layout')

@section('title', 'Gestion des Zones Urbaines')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Zones Urbaines</h1>
        <a href="{{ route('admin.zones.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter une Zone
        </a>
    </div>

    <!-- Statistics Row -->
    <div class="row mb-4">
        <!-- Total Zones -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Zones</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_zones'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtres et Recherche</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.zones.index') }}" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher par nom ou description..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                    <a href="{{ route('admin.zones.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Réinitialiser
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Zones Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Zones Urbaines</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Surface (m²)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($zones as $zone)
                        <tr>
                            <td>{{ $zone->id }}</td>
                            <td>
                                <strong>{{ $zone->nom }}</strong>
                            </td>
                            <td>{{ $zone->surface ? number_format($zone->surface, 2, ',', ' ') : 'N/A' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.zones.show', $zone) }}" class="btn btn-sm btn-info" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.zones.edit', $zone) }}" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.zones.destroy', $zone) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette zone ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-map-marked-alt fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Aucune zone urbaine trouvée.</p>
                                <a href="{{ route('admin.zones.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Créer la première zone
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($zones->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $zones->links('vendor.pagination.custom') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection