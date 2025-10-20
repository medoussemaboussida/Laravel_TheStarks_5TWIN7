@extends('admin_dashboard.layout')
@section('title', 'Modifier un Type de Plante')
@section('content')

<h1 class="mb-4">Modifier un Type</h1>

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

<form action="{{ route('plant-types.update', $plantType->id) }}" method="POST" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nom :</label>
        <input type="text" name="name" value="{{ old('name', $plantType->name) }}" required pattern="^[A-Za-zÀ-ÿ\s]{3,50}$" title="Uniquement des lettres (3 à 50)" class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-danger name-error"></small>
    </div>

    <div class="form-group">
        <label>Description :</label>
        <textarea name="description" required pattern="^[A-Za-zÀ-ÿ\s\.,'-]{5,200}$" title="5 à 200 caractères, lettres uniquement" class="form-control @error('description') is-invalid @enderror">{{ old('description', $plantType->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-danger desc-error"></small>
    </div>

    <button type="submit" class="btn btn-primary" disabled>Modifier</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form.needs-validation');
    if (!form) return;
    const submitBtn = form.querySelector('button[type="submit"]');
    const nameField = form.querySelector('input[name="name"]');
    const descField = form.querySelector('textarea[name="description"]');

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
