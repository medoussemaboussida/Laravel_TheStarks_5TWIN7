@extends('layouts.admin')

@section('title', 'Tableau de bord - UrbanGreen Admin')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
        <a href="{{ route('public.home') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-globe fa-sm text-white-50"></i> Voir le site public
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Total Projets Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Projets</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_projets'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projets en cours Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Projets en cours</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['projets_en_cours'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Événements Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Événements</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_evenements'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Inscriptions Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Inscriptions confirmées</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['inscriptions_confirmees'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Projets récents -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Projets récents</h6>
                    <a href="{{ route('admin.projets.index') }}" class="btn btn-sm btn-primary">Voir tous</a>
                </div>
                <div class="card-body">
                    @if($projets_recents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Statut</th>
                                        <th>Date début</th>
                                        <th>Événements</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projets_recents as $projet)
                                    <tr>
                                        <td>{{ $projet->nom }}</td>
                                        <td>
                                            <span class="badge badge-{{ $projet->statut == 'en_cours' ? 'success' : ($projet->statut == 'planifie' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst(str_replace('_', ' ', $projet->statut)) }}
                                            </span>
                                        </td>
                                        <td>{{ $projet->date_debut->format('d/m/Y') }}</td>
                                        <td>{{ $projet->evenements->count() }}</td>
                                        <td>
                                            <a href="{{ route('admin.projets.show', $projet) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Aucun projet récent.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Événements à venir -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Événements à venir</h6>
                    <a href="{{ route('admin.evenements.index') }}" class="btn btn-sm btn-primary">Voir tous</a>
                </div>
                <div class="card-body">
                    @if($evenements_a_venir->count() > 0)
                        @foreach($evenements_a_venir as $evenement)
                        <div class="d-flex align-items-center border-bottom py-2">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-calendar text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small text-gray-500">{{ $evenement->date_debut->format('d/m/Y H:i') }}</div>
                                <div class="font-weight-bold">{{ $evenement->nom }}</div>
                                <div class="small">{{ $evenement->projet->nom }}</div>
                                <div class="small text-success">{{ $evenement->inscriptions->count() }} inscriptions</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">Aucun événement à venir.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Inscriptions récentes -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Inscriptions récentes</h6>
                    <a href="{{ route('admin.inscriptions.index') }}" class="btn btn-sm btn-primary">Voir toutes</a>
                </div>
                <div class="card-body">
                    @if($inscriptions_recentes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Événement</th>
                                        <th>Date inscription</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inscriptions_recentes as $inscription)
                                    <tr>
                                        <td>{{ $inscription->user->name }}</td>
                                        <td>{{ $inscription->evenement->nom }}</td>
                                        <td>{{ $inscription->date_inscription->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $inscription->statut == 'confirmee' ? 'success' : ($inscription->statut == 'en_attente' ? 'warning' : 'danger') }}">
                                                {{ ucfirst(str_replace('_', ' ', $inscription->statut)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.inscriptions.show', $inscription) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Aucune inscription récente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
<style>
.icon-circle {
    height: 2.5rem;
    width: 2.5rem;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
