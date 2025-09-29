@extends('layouts.admin')

@section('title','Dashboard')

@section('content')
  <h1 class="h3 mb-4 text-gray-800">Bienvenue sur le Dashboard</h1>

  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Nombre de Bâtiments
              </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $nbBatiments }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-building fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
