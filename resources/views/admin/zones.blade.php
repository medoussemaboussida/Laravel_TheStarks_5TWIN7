@extends('layouts.admin')

@section('title','Gestion des Zones Urbaines')

@section('content')
  <h1 class="h3 mb-4 text-gray-800">Gestion des Zones Urbaines</h1>
  <a href="#" class="btn btn-primary mb-3">Ajouter une zone</a>
  <div class="table-responsive">
    <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Population</th>
        <th>Surface</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($zones as $zone)
        <tr>
          <td>{{ $zone->getId() }}</td>
          <td>{{ $zone->getNom() }}</td>
          <td>{{ $zone->getPopulation() }}</td>
          <td>{{ $zone->getSurface() }}</td>
          <td>
            <a href="#" class="btn btn-sm btn-warning">Modifier</a>
            <form action="#" method="POST" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette zone ?')">Supprimer</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
    </table>
  </div>
@endsection
