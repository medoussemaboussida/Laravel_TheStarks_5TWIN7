@extends('layouts.app')

@section('title', $projet->nom . ' - UrbanGreen')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-project-diagram"></i> {{ $projet->nom }}</h4>
                <div>
                    <a href="{{ route('projets.edit', $projet) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('projets.destroy', $projet) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Description:</strong></div>
                    <div class="col-sm-9">{{ $projet->description }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Date de début:</strong></div>
                    <div class="col-sm-9">{{ $projet->date_debut->format('d/m/Y') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Date de fin:</strong></div>
                    <div class="col-sm-9">
                        {{ $projet->date_fin ? $projet->date_fin->format('d/m/Y') : 'Non définie' }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Statut:</strong></div>
                    <div class="col-sm-9">
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
                    </div>
                </div>
                
                @if($projet->budget)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Budget:</strong></div>
                        <div class="col-sm-9">{{ number_format($projet->budget, 2) }} €</div>
                    </div>
                @endif
                
                @if($projet->localisation)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Localisation:</strong></div>
                        <div class="col-sm-9">{{ $projet->localisation }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-calendar-alt"></i> Événements</h5>
                <a href="{{ route('evenements.create') }}?projet_id={{ $projet->id }}"
                   class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Ajouter
                </a>
            </div>
            <div class="card-body">
                @if($projet->evenements->count() > 0)
                    @foreach($projet->evenements as $evenement)
                        <div class="border-bottom pb-2 mb-2">
                            <h6>
                                <a href="{{ route('evenements.show', $evenement) }}" 
                                   class="text-decoration-none">
                                    {{ $evenement->nom }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                {{ $evenement->date_debut->format('d/m/Y H:i') }}
                                @switch($evenement->statut)
                                    @case('planifie')
                                        <span class="badge bg-secondary ms-1">Planifié</span>
                                        @break
                                    @case('en_cours')
                                        <span class="badge bg-primary ms-1">En cours</span>
                                        @break
                                    @case('termine')
                                        <span class="badge bg-success ms-1">Terminé</span>
                                        @break
                                    @case('annule')
                                        <span class="badge bg-danger ms-1">Annulé</span>
                                        @break
                                @endswitch
                            </small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">Aucun événement pour ce projet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('projets.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>
@endsection
