@extends('layouts.layout')

@section('title', 'Liste des Types de Plantes')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Liste des Types de Plantes</h1>
<p class="mb-4">Voici la liste des types de plantes enregistrés. Vous pouvez ajouter, modifier ou supprimer des types.</p>

<!-- Bouton Ajouter un type -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addTypeModal">
    Ajouter un type
</button>

@if(session('success'))
    <p class="text-success">{{ session('success') }}</p>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Types de Plantes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="typesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->description }}</td>
                        <td>
                            <!-- Bouton Modifier -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editTypeModal{{ $type->id }}" title="Modifier">
                            <i class="fas fa-edit"></i>
                            </button>


                            <!-- Bouton Supprimer -->
                           <form action="{{ route('plant-types.destroy', $type->id) }}" method="POST" style="display:inline;" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm btn-delete" title="Supprimer">
        <i class="fas fa-trash"></i>
    </button>
</form>

                        </td>
                    </tr>

                    <!-- Modal Modifier -->
                    <div class="modal fade" id="editTypeModal{{ $type->id }}" tabindex="-1" role="dialog" aria-labelledby="editTypeModalLabel{{ $type->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                               <form action="{{ route('plant-types.update', $type->id) }}" method="POST" class="validate-form" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editTypeModalLabel{{ $type->id }}">Modifier le Type de Plante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Nom du type</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $type->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger name-error"></small>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $type->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger desc-error"></small>
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
<div class="text-center mt-3">
    {{ $types->onEachSide(0)->links('pagination::simple-bootstrap-4') }}
</div>


<!-- Modal Ajouter un Type -->
<div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-labelledby="addTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('plant-types.store') }}" method="POST" class="validate-form" novalidate>
    @csrf
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addTypeModalLabel">Ajouter un Type de Plante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Nom du type</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger name-error"></small>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger desc-error"></small>
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

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // DataTable
    $('#typesTable').DataTable({
        "pagingType": "simple_numbers",
        "pageLength": 5,
        "lengthChange": false,
        "language": {"paginate": {"previous": "<", "next": ">" }},
        "dom": '<"top"f>rt<"bottom"ip><"clear">'
    });

    // Confirmation avant suppression
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        let form = $(this).closest('form');
        if(confirm("Êtes-vous sûr de supprimer ce type ?")) {
            form.submit();
        }
    });

    // Validation des formulaires Ajouter/Modifier
    $(document).on('submit', '.validate-form', function(e){
        const name = $(this).find('input[name="name"]').val();
        const desc = $(this).find('textarea[name="description"]').val();

        const nameRegex = /^[A-Za-zÀ-ÿ\s]{3,50}$/;
        const descRegex = /^[A-Za-zÀ-ÿ0-9\s\.,'-]{5,200}$/;

        if(!nameRegex.test(name)){
            alert("Nom invalide : uniquement lettres, 3 à 50 caractères.");
            e.preventDefault();
            return false;
        }

        if(!descRegex.test(desc)){
            alert("Description invalide : 5 à 200 caractères autorisés.");
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection
