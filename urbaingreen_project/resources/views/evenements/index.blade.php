@extends('layouts.app')

@section('title', 'Liste des Événements - UrbanGreen')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-calendar-alt"></i> Gestion des Événements</h1>
    <a href="{{ route('evenements.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Nouvel Événement
    </a>
</div>

@if($evenements->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Projet</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Lieu</th>
                            <th>Participants max</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evenements as $evenement)
                            <tr>
                                <td>
                                    <strong>{{ $evenement->nom }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('projets.show', $evenement->projet) }}" 
                                       class="text-decoration-none">
                                        {{ $evenement->projet->nom }}
                                    </a>
                                </td>
                                <td>{{ $evenement->date_debut->format('d/m/Y H:i') }}</td>
                                <td>{{ $evenement->date_fin->format('d/m/Y H:i') }}</td>
                                <td>{{ $evenement->lieu ?? 'Non défini' }}</td>
                                <td>
                                    {{ $evenement->nombre_participants_max ?? 'Illimité' }}
                                </td>
                                <td>
                                    @switch($evenement->statut)
                                        @case('planifie')
                                            <span class="badge bg-secondary">Planifié</span>
                                            @break
                                        @case('en_cours')
                                            <span class="badge bg-primary">En cours</span>
                                            @break
                                        @case('termine')
                                            <span class="badge bg-success">Terminé</span>
                                            @break
                                        @case('annule')
                                            <span class="badge bg-danger">Annulé</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('evenements.show', $evenement) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('evenements.edit', $evenement) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('evenements.destroy', $evenement) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
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
        {{ $evenements->links() }}
    </div>
@else
    <div class="text-center">
        <div class="card">
            <div class="card-body">
                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                <h4>Aucun événement trouvé</h4>
                <p class="text-muted">Commencez par créer votre premier événement.</p>
                <a href="{{ route('evenements.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Créer un événement
                </a>
            </div>
        </div>
    </div>
@endif
@endsection
