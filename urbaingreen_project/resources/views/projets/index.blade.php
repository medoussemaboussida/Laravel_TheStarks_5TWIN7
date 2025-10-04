@extends('layouts.app')

@section('title', 'Liste des Projets - UrbanGreen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-project-diagram"></i> Gestion des Projets</h1>
    <a href="{{ route('projets.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Nouveau Projet
    </a>
</div>

@if($projets->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Statut</th>
                            <th>Budget</th>
                            <th>Événements</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projets as $projet)
                            <tr>
                                <td>
                                    <strong>{{ $projet->nom }}</strong>
                                </td>
                                <td>{{ Str::limit($projet->description, 50) }}</td>
                                <td>{{ $projet->date_debut->format('d/m/Y') }}</td>
                                <td>
                                    {{ $projet->date_fin ? $projet->date_fin->format('d/m/Y') : 'Non définie' }}
                                </td>
                                <td>
                                    @switch($projet->statut)
                                        @case('planifie')
                                            <span class="badge bg-secondary">Planifié</span>
                                            @break
                                        @case('en_cours')
                                            <span class="badge bg-primary">En cours</span>
                                            @break
                                        @case('termine')
                                            <span class="badge bg-success">Terminé</span>
                                            @break
                                        @case('suspendu')
                                            <span class="badge bg-warning">Suspendu</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    {{ $projet->budget ? number_format($projet->budget, 2) . ' €' : 'Non défini' }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $projet->evenements->count() }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('projets.show', $projet) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('projets.edit', $projet) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('projets.destroy', $projet) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
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
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $projets->links() }}
    </div>
@else
    <div class="text-center">
        <div class="card">
            <div class="card-body">
                <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                <h4>Aucun projet trouvé</h4>
                <p class="text-muted">Commencez par créer votre premier projet.</p>
                <a href="{{ route('projets.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Créer un projet
                </a>
            </div>
        </div>
    </div>
@endif
@endsection
