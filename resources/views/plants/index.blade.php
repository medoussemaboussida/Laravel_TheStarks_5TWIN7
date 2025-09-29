@extends('layouts.layout')

@section('title', 'Liste des Plantes')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Liste des Plantes</h1>
<p class="mb-4">Voici la liste des plantes enregistrées. Vous pouvez ajouter, modifier ou supprimer des plantes.</p>

<!-- Bouton Ajouter une plante -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPlantModal">
    Ajouter une plante
</button>

@if(session('success'))
    <p class="text-success">{{ session('success') }}</p>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Plantes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="plantsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Âge</th>
                        <th>Localisation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plants as $plant)
                    <tr>
                        <td>{{ $plant->name }}</td>
                        <td>{{ $plant->type->name }}</td>
                        <td>{{ $plant->age ?? 'N/A' }}</td>
                        <td>{{ $plant->location ?? 'Non spécifiée' }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPlantModal{{ $plant->id }}" title="Modifier">
                            <i class="fas fa-edit"></i>
                            </button>


                            <form action="{{ route('plants.destroy', $plant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette plante ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                            <i class="fas fa-trash"></i>
                            </button>
                            </form>

                        </td>
                    </tr>

                    <!-- Modal Modifier -->
                    <div class="modal fade" id="editPlantModal{{ $plant->id }}" tabindex="-1" role="dialog" aria-labelledby="editPlantModalLabel{{ $plant->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('plants.update', $plant->id) }}" method="POST" class="validate-form" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Modifier la Plante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $plant->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger name-error"></small>
        </div>

        <div class="form-group">
            <label for="plant_type_id">Type</label>
            <select name="plant_type_id" class="form-control type-field @error('plant_type_id') is-invalid @enderror">
                <option value="">Sélectionner un type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ old('plant_type_id', $plant->plant_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('plant_type_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger type-error"></small>
        </div>

        <div class="form-group">
            <label for="age">Âge</label>
            <input type="number" name="age" class="form-control age-field @error('age') is-invalid @enderror" value="{{ old('age', $plant->age) }}">
            @error('age')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger age-error"></small>
        </div>

        <div class="form-group">
            <label for="location">Localisation</label>
            <input type="text" name="location" class="form-control location-field @error('location') is-invalid @enderror" value="{{ old('location', $plant->location) }}">
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger location-error"></small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
 <div class="text-center">
    <div class="text-center mt-3">
    {{ $plants->onEachSide(0)->links('pagination::simple-bootstrap-4') }}
</div>
</div>


<!-- Modal Ajouter une Plante -->
<div class="modal fade" id="addPlantModal" tabindex="-1" role="dialog" aria-labelledby="addPlantModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('plants.store') }}" method="POST" class="validate-form" novalidate>
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Ajouter une Plante</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Erreur de saisie :</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-danger name-error"></small>
            </div>

            <div class="form-group">
                <label for="plant_type_id">Type</label>
                <select name="plant_type_id" class="form-control @error('plant_type_id') is-invalid @enderror">
                    <option value="">Sélectionner un type</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('plant_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('plant_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-danger type-error"></small>
            </div>

            <div class="form-group">
                <label for="age">Âge</label>
                <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}">
                @error('age')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-danger age-error"></small>
            </div>

            <div class="form-group">
                <label for="location">Localisation</label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-danger location-error"></small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if ($errors->has('name') || $errors->has('plant_type_id') || $errors->has('age') || $errors->has('location'))
<script>
    $(document).ready(function() {
        $('#addPlantModal').modal('show');
    });
</script>
@endif

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#plantsTable').DataTable({
        pagingType: "simple_numbers",
        pageLength: 5,
        lengthChange: false,
        language: {
            paginate: {
                previous: "<",
                next: ">"
            }
        },
        dom: '<"top"f>rt<"bottom"ip><"clear">'
    });

    // Validation JS si activée
    $(document).on('submit', '.validate-form', function(e){
        let valid = true;

        $(this).find('input, select').each(function(){
            const field = $(this);
            const value = field.val();
            const pattern = field.attr('pattern');
            const min = field.attr('min');
            const max = field.attr('max');
            const errorField = field.siblings('small.text-danger');

            errorField.text('');

            if(field.prop('required') && !value){
                errorField.text('Ce champ est obligatoire');
                valid = false;
            }
            else if(pattern && value && !(new RegExp(pattern).test(value))){
                errorField.text(field.attr('title'));
                valid = false;
            }
            else if(field.attr('type') === 'number'){
                if(value && min && parseFloat(value) < parseFloat(min)){
                    errorField.text('Valeur minimale : ' + min);
                    valid = false;
                }
                if(value && max && parseFloat(value) > parseFloat(max)){
                    errorField.text('Valeur maximale : ' + max);
                    valid = false;
                }
            }
        });

        if(!valid) e.preventDefault();
    });
});
</script>
@endsection
