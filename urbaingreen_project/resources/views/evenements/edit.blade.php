@extends('layouts.app')

@section('title', 'Modifier ' . $evenement->nom . ' - UrbanGreen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-edit"></i> Modifier l'Événement: {{ $evenement->nom }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('evenements.update', $evenement) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de l'événement *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom', $evenement->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description', $evenement->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="projet_id" class="form-label">Projet associé *</label>
                        <select class="form-select @error('projet_id') is-invalid @enderror" 
                                id="projet_id" name="projet_id" required>
                            <option value="">Sélectionner un projet</option>
                            @foreach($projets as $projet)
                                <option value="{{ $projet->id }}" 
                                        {{ old('projet_id', $evenement->projet_id) == $projet->id ? 'selected' : '' }}>
                                    {{ $projet->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('projet_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date et heure de début *</label>
                                <input type="datetime-local" class="form-control @error('date_debut') is-invalid @enderror" 
                                       id="date_debut" name="date_debut" 
                                       value="{{ old('date_debut', $evenement->date_debut->format('Y-m-d\TH:i')) }}" required>
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date et heure de fin *</label>
                                <input type="datetime-local" class="form-control @error('date_fin') is-invalid @enderror" 
                                       id="date_fin" name="date_fin" 
                                       value="{{ old('date_fin', $evenement->date_fin->format('Y-m-d\TH:i')) }}" required>
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lieu" class="form-label">Lieu</label>
                                <input type="text" class="form-control @error('lieu') is-invalid @enderror" 
                                       id="lieu" name="lieu" value="{{ old('lieu', $evenement->lieu) }}">
                                @error('lieu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre_participants_max" class="form-label">Nombre max de participants</label>
                                <input type="number" min="1" 
                                       class="form-control @error('nombre_participants_max') is-invalid @enderror" 
                                       id="nombre_participants_max" name="nombre_participants_max" 
                                       value="{{ old('nombre_participants_max', $evenement->nombre_participants_max) }}">
                                @error('nombre_participants_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="statut" class="form-label">Statut *</label>
                        <select class="form-select @error('statut') is-invalid @enderror" 
                                id="statut" name="statut" required>
                            <option value="">Sélectionner un statut</option>
                            <option value="planifie" {{ old('statut', $evenement->statut) == 'planifie' ? 'selected' : '' }}>Planifié</option>
                            <option value="en_cours" {{ old('statut', $evenement->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="termine" {{ old('statut', $evenement->statut) == 'termine' ? 'selected' : '' }}>Terminé</option>
                            <option value="annule" {{ old('statut', $evenement->statut) == 'annule' ? 'selected' : '' }}>Annulé</option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('evenements.show', $evenement) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
