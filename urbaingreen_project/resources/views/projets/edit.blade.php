@extends('layouts.app')

@section('title', 'Modifier ' . $projet->nom . ' - UrbanGreen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-edit"></i> Modifier le Projet: {{ $projet->nom }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('projets.update', $projet) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom du projet *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom', $projet->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" required>{{ old('description', $projet->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de début *</label>
                                <input type="date" class="form-control @error('date_debut') is-invalid @enderror" 
                                       id="date_debut" name="date_debut" 
                                       value="{{ old('date_debut', $projet->date_debut->format('Y-m-d')) }}" required>
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de fin</label>
                                <input type="date" class="form-control @error('date_fin') is-invalid @enderror" 
                                       id="date_fin" name="date_fin" 
                                       value="{{ old('date_fin', $projet->date_fin ? $projet->date_fin->format('Y-m-d') : '') }}">
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="statut" class="form-label">Statut *</label>
                                <select class="form-select @error('statut') is-invalid @enderror" 
                                        id="statut" name="statut" required>
                                    <option value="">Sélectionner un statut</option>
                                    <option value="planifie" {{ old('statut', $projet->statut) == 'planifie' ? 'selected' : '' }}>Planifié</option>
                                    <option value="en_cours" {{ old('statut', $projet->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="termine" {{ old('statut', $projet->statut) == 'termine' ? 'selected' : '' }}>Terminé</option>
                                    <option value="suspendu" {{ old('statut', $projet->statut) == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                </select>
                                @error('statut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="budget" class="form-label">Budget (€)</label>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('budget') is-invalid @enderror" 
                                       id="budget" name="budget" value="{{ old('budget', $projet->budget) }}">
                                @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="localisation" class="form-label">Localisation</label>
                        <input type="text" class="form-control @error('localisation') is-invalid @enderror" 
                               id="localisation" name="localisation" value="{{ old('localisation', $projet->localisation) }}">
                        @error('localisation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('projets.show', $projet) }}" class="btn btn-secondary">
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
