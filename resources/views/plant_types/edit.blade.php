@extends('layouts.app')
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

<form action="{{ route('plant-types.update', $plantType->id) }}" method="POST" novalidate>
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Nom :</label>
        <input type="text" name="name" value="{{ old('name', $plantType->name) }}" class="form-control @error('name') is-invalid @enderror">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label>Description :</label>
        <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $plantType->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Modifier</button>
</form>

@endsection
