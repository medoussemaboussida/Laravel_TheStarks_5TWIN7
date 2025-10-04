@extends('layouts.app')

@section('title', $evenement->nom . ' - UrbanGreen')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-calendar-alt"></i> {{ $evenement->nom }}</h4>
                <div>
                    <a href="{{ route('evenements.edit', $evenement) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('evenements.destroy', $evenement) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Description:</strong></div>
                    <div class="col-sm-9">{{ $evenement->description }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Projet associé:</strong></div>
                    <div class="col-sm-9">
                        <a href="{{ route('projets.show', $evenement->projet) }}" 
                           class="text-decoration-none">
                            {{ $evenement->projet->nom }}
                        </a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Date de début:</strong></div>
                    <div class="col-sm-9">{{ $evenement->date_debut->format('d/m/Y à H:i') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Date de fin:</strong></div>
                    <div class="col-sm-9">{{ $evenement->date_fin->format('d/m/Y à H:i') }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Durée:</strong></div>
                    <div class="col-sm-9">
                        @php
                            $duree = $evenement->date_debut->diff($evenement->date_fin);
                            $heures = $duree->h + ($duree->days * 24);
                        @endphp
                        {{ $heures }}h {{ $duree->i }}min
                    </div>
                </div>
                
                @if($evenement->lieu)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Lieu:</strong></div>
                        <div class="col-sm-9">{{ $evenement->lieu }}</div>
                    </div>
                @endif
                
                @if($evenement->nombre_participants_max)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Participants max:</strong></div>
                        <div class="col-sm-9">{{ $evenement->nombre_participants_max }}</div>
                    </div>
                @endif
                
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Statut:</strong></div>
                    <div class="col-sm-9">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-project-diagram"></i> Informations du Projet</h5>
            </div>
            <div class="card-body">
                <h6>{{ $evenement->projet->nom }}</h6>
                <p class="text-muted">{{ Str::limit($evenement->projet->description, 100) }}</p>
                
                <div class="mb-2">
                    <strong>Statut du projet:</strong>
                    @switch($evenement->projet->statut)
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
                
                @if($evenement->projet->localisation)
                    <div class="mb-2">
                        <strong>Localisation:</strong> {{ $evenement->projet->localisation }}
                    </div>
                @endif
                
                <div class="mt-3">
                    <a href="{{ route('projets.show', $evenement->projet) }}" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye"></i> Voir le projet
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('evenements.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>
@endsection
