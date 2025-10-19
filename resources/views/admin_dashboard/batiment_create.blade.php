@extends('admin_dashboard.layout')

@section('title', 'Ajouter un Bâtiment')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ajouter un Bâtiment</h1>
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
                    <form action="{{ route('backoffice.storebatiment') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="type_batiment" class="form-label">Type de bâtiment <span class="text-danger">*</span></label>
                                    <select name="type_batiment" id="type_batiment" class="form-control @error('type_batiment') is-invalid @enderror" required>
                                        <option value="">Sélectionner un type</option>
                                        <option value="Maison" {{ old('type_batiment') == 'Maison' ? 'selected' : '' }}>Maison</option>
                                        <option value="Usine" {{ old('type_batiment') == 'Usine' ? 'selected' : '' }}>Usine</option>
                                    </select>
                                    @error('type_batiment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="zone_id" class="form-label">Zone urbaine <span class="text-danger">*</span></label>
                                    <select name="zone_id" id="zone_id" class="form-control @error('zone_id') is-invalid @enderror" required>
                                        <option value="">Sélectionner une zone</option>
                                        @foreach($zones as $zone)
                                            <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
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

                        <div class="form-group mb-3">
                            <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                            <input type="text" name="adresse" id="adresse" class="form-control @error('adresse') is-invalid @enderror"
                                   value="{{ old('adresse') }}" placeholder="Entrez l'adresse complète du bâtiment" required>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
@endsection