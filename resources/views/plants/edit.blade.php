@extends('admin_dashboard.layout')
@section('title', 'Modifier une Plante')
@section('content')

<h1 class="mb-4">Modifier une Plante</h1>

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

<form action="{{ route('plants.update', $plant->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nom :</label>
        <input type="text" name="name" value="{{ old('name', $plant->name) }}" required pattern="^[A-Za-zÀ-ÿ\s]+$" title="Le nom doit contenir uniquement des lettres" class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-danger name-error"></small>
        <div class="invalid-feedback name-feedback"></div>
    </div>

    <div class="form-group">
        <label>Âge :</label>
        <input type="number" name="age" value="{{ old('age', $plant->age) }}" required min="0" max="200" step="1" title="L’âge doit être un nombre entre 0 et 200" class="form-control @error('age') is-invalid @enderror">
        @error('age')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-danger age-error"></small>
    </div>

    <div class="form-group">
        <label>Localisation :</label>
        <input type="text" name="location" value="{{ old('location', $plant->location) }}" required pattern="^[A-Za-zÀ-ÿ0-9\s\-']+$" title="La localisation doit contenir des lettres et/ou des chiffres" class="form-control @error('location') is-invalid @enderror">
        @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-danger location-error"></small>
    </div>

    <div class="form-group">
        <label>Type :</label>
        <select name="plant_type_id" required class="form-control @error('plant_type_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}" {{ old('plant_type_id', $plant->plant_type_id) == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
        @error('plant_type_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-danger type-error"></small>
    </div>

    <button type="submit" class="btn btn-primary" disabled>Modifier</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form.needs-validation');
    if (!form) return;
    const submitBtn = form.querySelector('button[type="submit"]');

    function validateAndToggle() {
        // Force validation display for all fields
        Array.from(form.elements).forEach(function(field) {
            if (field.checkValidity()) {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            } else {
                field.classList.remove('is-valid');
                field.classList.add('is-invalid');
            }
        });

        if (form.checkValidity()) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-primary');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-secondary');
            submitBtn.classList.remove('btn-primary');
        }
    }

    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
        validateAndToggle();
    }, false);

    Array.from(form.elements).forEach(function(el) {
        el.addEventListener('input', function() {
            form.classList.add('was-validated');
            validateAndToggle();
        });
        el.addEventListener('change', function() {
            form.classList.add('was-validated');
            validateAndToggle();
        });
    });

    validateAndToggle();
});
</script>
@endsection
