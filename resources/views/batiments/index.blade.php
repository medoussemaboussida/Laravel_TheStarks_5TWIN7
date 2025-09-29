@extends('layouts.app')

@section('title','Bâtiments')

@section('content')
<div class="container">
  <h1>Bâtiments</h1>
  <a href="{{ route('batiments.create') }}" class="btn btn-primary mb-3">Ajouter un bâtiment</a>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Adresse</th>
        <th>Emission CO₂ (t/an)</th>
        <th>% Renouvelable</th>
        <th>Emission réelle</th>
        <th>Arbres nécessaires 🌳</th>
        <th>Nombres personne</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($batiments as $b)
      <tr>
        <td>{{ $b->getId() }}</td>
        <td>{{ $b->getTypeBatiment() }}</td>
        <td>{{ $b->getAdresse() }}</td>
        <td>{{ number_format($b->getEmissionCO2(), 2) }}</td>
        <td>{{ $b->getPourcentageRenouvelable() }}%</td>
        <td>{{ number_format($b->getEmissionReelle(), 2) }}</td>
        <td>{{ number_format($b->getNbArbresBesoin()) }}</td>
<td>
    @if ($b->getTypeBatiment() === 'Usine')
        {{ number_format($b->getNbEmployes() ?? 0) }}
    @elseif ($b->getTypeBatiment() === 'Maison')
        {{ number_format($b->getNbHabitants() ?? 0) }}
    @else
        -
    @endif
</td>

        <td>
          <a href="{{ route('batiments.edit', $b->getId()) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('batiments.destroyFrontoffice', $b->getId()) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Suppr</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
