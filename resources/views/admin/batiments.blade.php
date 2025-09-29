@extends('layouts.admin')

@section('title','Gestion des Bâtiments')

@section('content')
  <h1 class="h3 mb-4 text-gray-800">Gestion des Bâtiments</h1>
  <a href="{{ route('batiments.create') }}" class="btn btn-primary mb-3">Ajouter un bâtiment</a>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Zone</th>
        <th>Surface</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($batiments as $batiment)
        <tr>
          <td>{{ $batiment->getId() }}</td>
          <td>{{ $batiment->getNom() }}</td>
          <td>{{ $batiment->getZone() ? $batiment->getZone()->getNom() : '-' }}</td>
          <td>{{ $batiment->getSurface() }}</td>
          <td>
            <a href="{{ route('batiments.edit', $batiment->getId()) }}" class="btn btn-sm btn-warning">Modifier</a>
            <form action="{{ route('batiments.destroy', $batiment->getId()) }}" method="POST" style="display:inline-block;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce bâtiment ?')">Supprimer</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
