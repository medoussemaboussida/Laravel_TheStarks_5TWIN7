@extends('admin_dashboard.layout')

@section('title', 'Créer une Zone Urbaine')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Créer une Zone Urbaine</h1>
        <a href="{{ route('admin.zones.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations de la Zone Urbaine</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.zones.store') }}" method="POST">
                        @csrf

                        <div class="form-group row">
                            <label for="nom" class="col-sm-3 col-form-label">Nom <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="surface" class="col-sm-3 col-form-label">Surface totale (m²)</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control @error('surface') is-invalid @enderror"
                                       id="surface" name="surface" value="{{ old('surface') }}" min="0" step="0.01">
                                @error('surface')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Créer la Zone
                                </button>
                                <a href="{{ route('admin.zones.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fas fa-times"></i> Annuler
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Informations</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nom :</strong> Identifiant unique de la zone urbaine</p>
                    <p><strong>Surface :</strong> Surface totale en mètres carrés</p>

                    <hr>
                    <p class="text-muted small">
                        <i class="fas fa-info-circle"></i>
                        Le nom est obligatoire. La surface peut être ajoutée ultérieurement.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection