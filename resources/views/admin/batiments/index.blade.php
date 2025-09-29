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
        <button type="button" class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#addBatimentModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter Bâtiment
        </button>
        <!-- Modal Ajout Bâtiment -->
        <div class="modal fade" id="addBatimentModal" tabindex="-1" role="dialog" aria-labelledby="addBatimentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('batiments.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBatimentModalLabel">Ajouter un Bâtiment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="type_batiment_add">Type <span class="text-danger">*</span></label>
                                <select name="type_batiment" id="type_batiment_add" class="form-control" required>
                                    <option value="Maison">Maison</option>
                                    <option value="Usine">Usine</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="adresse_add">Adresse <span class="text-danger">*</span></label>
                                <input type="text" name="adresse" id="adresse_add" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="zone_id_add">Zone Urbaine <span class="text-danger">*</span></label>
                                <select name="zone_id" id="zone_id_add" class="form-control" required>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->getId() }}">{{ $zone->getNom() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nbHabitants_add">Nb Habitants</label>
                                <input type="number" name="nbHabitants" id="nbHabitants_add" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nbEmployes_add">Nb Employés</label>
                                <input type="number" name="nbEmployes" id="nbEmployes_add" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="typeIndustrie_add">Type Industrie</label>
                                <input type="text" name="typeIndustrie" id="typeIndustrie_add" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="pourcentageRenouvelable_add">% Renouvelable</label>
                                <input type="number" step="0.01" name="pourcentageRenouvelable" id="pourcentageRenouvelable_add" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                                    <div class="d-flex align-items-center gap-2">
                                        <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#editBatimentModal{{ $batiment->getId() }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('batiments.destroyBackoffice', $batiment->getId()) }}" method="POST" style="display:inline-block; margin-bottom:0;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="source" value="backoffice">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce bâtiment ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="editBatimentModal{{ $batiment->getId() }}" tabindex="-1" role="dialog" aria-labelledby="editBatimentModalLabel{{ $batiment->getId() }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('batiments.updateBackoffice', $batiment->getId()) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editBatimentModalLabel{{ $batiment->getId() }}">Modifier Bâtiment #{{ $batiment->getId() }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="source" value="backoffice">
                                                        <div class="form-group">
                                                            <label for="type_batiment_{{ $batiment->getId() }}">Type</label>
                                                            <select name="type_batiment" id="type_batiment_{{ $batiment->getId() }}" class="form-control" required>
                                                                <option value="Maison" @if($batiment->getTypeBatiment() == 'Maison') selected @endif>Maison</option>
                                                                <option value="Usine" @if($batiment->getTypeBatiment() == 'Usine') selected @endif>Usine</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="adresse_{{ $batiment->getId() }}">Adresse</label>
                                                            <input type="text" name="adresse" id="adresse_{{ $batiment->getId() }}" class="form-control" value="{{ $batiment->getAdresse() }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="zone_id_{{ $batiment->getId() }}">Zone Urbaine</label>
                                                            <select name="zone_id" id="zone_id_{{ $batiment->getId() }}" class="form-control" required>
                                                                @foreach($batiment->getZone() ? [$batiment->getZone()] : [] as $zone)
                                                                    <option value="{{ $zone->getId() }}" selected>{{ $zone->getNom() }}</option>
                                                                @endforeach
                                                                @foreach($batiments as $b)
                                                                    @if($b->getZone() && (!$batiment->getZone() || $b->getZone()->getId() != $batiment->getZone()->getId()))
                                                                        <option value="{{ $b->getZone()->getId() }}">{{ $b->getZone()->getNom() }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nbHabitants_{{ $batiment->getId() }}">Nb Habitants</label>
                                                            <input type="number" name="nbHabitants" id="nbHabitants_{{ $batiment->getId() }}" class="form-control" value="{{ $batiment->getNbHabitants() }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nbEmployes_{{ $batiment->getId() }}">Nb Employés</label>
                                                            <input type="number" name="nbEmployes" id="nbEmployes_{{ $batiment->getId() }}" class="form-control" value="{{ $batiment->getNbEmployes() }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="typeIndustrie_{{ $batiment->getId() }}">Type Industrie</label>
                                                            <input type="text" name="typeIndustrie" id="typeIndustrie_{{ $batiment->getId() }}" class="form-control" value="{{ $batiment->getTypeIndustrie() }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="pourcentageRenouvelable_{{ $batiment->getId() }}">% Renouvelable</label>
                                                            <input type="number" step="0.01" name="pourcentageRenouvelable" id="pourcentageRenouvelable_{{ $batiment->getId() }}" class="form-control" value="{{ $batiment->getPourcentageRenouvelable() }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-success">Mettre à jour</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
