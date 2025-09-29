@extends('layouts.admin')

@section('title','Gestion des Bâtiments')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Bâtiments</h1>
        <a href="{{ route('batiments.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter Bâtiment
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des bâtiments</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Adresse</th>
                            <th>Zone</th>
                            <th>Émission CO₂</th>
                            <th>Nb Habitants</th>
                            <th>Nb Employés</th>
                            <th>Type Industrie</th>
                            <th>% Renouvelable</th>
                            <th>Émission réelle</th>
                            <th>Arbres besoin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($batiments as $batiment)
                            <tr>
                                <td>{{ $batiment->getId() }}</td>
                                <td>{{ $batiment->getTypeBatiment() }}</td>
                                <td>{{ $batiment->getAdresse() }}</td>
                                <td>{{ $batiment->getZone() ? $batiment->getZone()->getNom() : '-' }}</td>
                                <td>{{ $batiment->getEmissionCO2() }}</td>
                                <td>{{ $batiment->getNbHabitants() }}</td>
                                <td>{{ $batiment->getNbEmployes() }}</td>
                                <td>{{ $batiment->getTypeIndustrie() }}</td>
                                <td>{{ $batiment->getPourcentageRenouvelable() }}%</td>
                                <td>{{ $batiment->getEmissionReelle() }}</td>
                                <td>{{ $batiment->getNbArbresBesoin() }}</td>
                                <td>
                                    <a href="{{ route('batiments.edit', $batiment->getId()) }}" class="btn btn-warning btn-sm mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('batiments.destroyBackoffice', $batiment->getId()) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="source" value="backoffice">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce bâtiment ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
