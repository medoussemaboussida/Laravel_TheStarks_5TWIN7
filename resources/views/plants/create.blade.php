@extends('layouts.app')
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

<form action="{{ route('plants.store') }}" method="POST" novalidate>
    @csrf

    <div class="form-group">
        <label>Nom :</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Âge :</label>
        <input type="number" name="age" value="{{ old('age') }}" class="form-control @error('age') is-invalid @enderror">
        @error('age')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Localisation :</label>
        <input type="text" name="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror">
        @error('location')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Type :</label>
        <select name="plant_type_id" class="form-control @error('plant_type_id') is-invalid @enderror">
            <option value="">-- Sélectionner --</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}" {{ old('plant_type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach
        </select>
        @error('plant_type_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
</form>

@endsection
