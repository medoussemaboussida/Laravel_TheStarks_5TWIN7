@extends('admin_dashboard.layout')
@section('title', 'Ajouter une Plante')
@section('content')

<h1 class="mb-4">Ajouter une Plante</h1>

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

<form action="{{ route('plants.store') }}" method="POST" class="needs-validation" novalidate>
    @csrf

    <div class="form-group">
        <label>Nom :</label>
        <input type="text" name="name" value="{{ old('name') }}" required pattern="^[A-Za-zÀ-ÿ\s]+$" title="Le nom doit contenir uniquement des lettres" class="form-control @error('name') is-invalid @enderror">
        <div class="invalid-feedback">{{ $errors->first('name') ?? 'Le nom doit contenir uniquement des lettres' }}</div>
    </div>

    <div class="form-group">
        <label>Âge :</label>
        <input type="number" name="age" value="{{ old('age') }}" required min="0" max="200" step="1" title="L’âge doit être un nombre entre 0 et 200" class="form-control @error('age') is-invalid @enderror">
        <div class="invalid-feedback">{{ $errors->first('age') ?? 'L’âge doit être un nombre entre 0 et 200' }}</div>
    </div>

    <div class="form-group">
        <label>Localisation :</label>
        <input type="text" name="location" value="{{ old('location') }}" required pattern="^[A-Za-zÀ-ÿ0-9\s\-']+$" title="La localisation doit contenir des lettres et/ou des chiffres" class="form-control @error('location') is-invalid @enderror">
        <div class="invalid-feedback">{{ $errors->first('location') ?? 'La localisation doit contenir des lettres et/ou des chiffres' }}</div>
    </div>

    <div class="form-group">
        <label>Type :</label>
        <select name="plant_type_id" required class="form-control @error('plant_type_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}" {{ old('plant_type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
        <div class="invalid-feedback">{{ $errors->first('plant_type_id') ?? 'Veuillez sélectionner un type de plante' }}</div>
    </div>

    <button type="submit" class="btn btn-secondary" disabled>Enregistrer</button>
</form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form.needs-validation');
    if (!form) return;
    const submitBtn = form.querySelector('button[type="submit"]');

    function validateAndToggle() {
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
        el.addEventListener('input', validateAndToggle);
        el.addEventListener('change', validateAndToggle);
    });

    validateAndToggle();
});
</script>
@endsection
