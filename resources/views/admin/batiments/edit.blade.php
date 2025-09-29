@extends('layouts.admin')

@section('title','Modifier un Bâtiment')

@section('content')
<div class="container">
  <h1 class="h3 mb-4 text-gray-800">Modifier un Bâtiment</h1>
  <form action="{{ route('batiments.update', $batiment->getId()) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="nom">Nom</label>
      <input type="text" name="nom" id="nom" class="form-control" value="{{ $batiment->getNom() }}" required>
    </div>
    <div class="form-group">
      <label for="zone_id">Zone Urbaine</label>
      <select name="zone_id" id="zone_id" class="form-control">
        @foreach($zones as $zone)
          <option value="{{ $zone->getId() }}" @if($batiment->getZone() && $batiment->getZone()->getId() == $zone->getId()) selected @endif>{{ $zone->getNom() }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="surface">Surface</label>
      <input type="number" name="surface" id="surface" class="form-control" value="{{ $batiment->getSurface() }}" required>
    </div>
    <button type="submit" class="btn btn-success">Mettre à jour</button>
    <a href="{{ route('batiments.index') }}" class="btn btn-secondary">Annuler</a>
  </form>
</div>
@endsection
