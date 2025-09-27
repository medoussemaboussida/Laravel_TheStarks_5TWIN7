@extends('layouts.public')

@section('title', $projet->nom . ' - UrbanGreen')
@section('description', Str::limit($projet->description, 160))

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background" data-aos="fade">
    <div class="container position-relative">
      <h1>{{ $projet->nom }}</h1>
      <p>{{ $projet->localisation }}</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('public.home') }}">Accueil</a></li>
          <li><a href="{{ route('public.projets.index') }}">Projets</a></li>
          <li class="current">{{ $projet->nom }}</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Projet Details Section -->
  <section id="projet-details" class="service-details section">
    <div class="container">
      <div class="row gy-5">

        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
          
          <!-- Statut et informations principales -->
          <div class="card mb-4">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                  <span class="badge bg-{{ $projet->statut == 'en_cours' ? 'success' : ($projet->statut == 'planifie' ? 'warning' : 'secondary') }} fs-6">
                    {{ ucfirst(str_replace('_', ' ', $projet->statut)) }}
                  </span>
                </div>
                <div class="text-end">
                  <small class="text-muted">
                    Créé le {{ $projet->created_at->format('d/m/Y') }}
                  </small>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <p><strong><i class="bi bi-calendar"></i> Date de début:</strong><br>
                  {{ $projet->date_debut ? $projet->date_debut->format('d/m/Y') : 'Non définie' }}</p>
                </div>
                <div class="col-md-6">
                  <p><strong><i class="bi bi-calendar-check"></i> Date de fin:</strong><br>
                  {{ $projet->date_fin ? $projet->date_fin->format('d/m/Y') : 'Non définie' }}</p>
                </div>
                <div class="col-md-6">
                  <p><strong><i class="bi bi-geo-alt"></i> Localisation:</strong><br>
                  {{ $projet->localisation }}</p>
                </div>
                @if($projet->budget)
                <div class="col-md-6">
                  <p><strong><i class="bi bi-currency-euro"></i> Budget:</strong><br>
                  {{ number_format($projet->budget, 0, ',', ' ') }}€</p>
                </div>
                @endif
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="card mb-4">
            <div class="card-header">
              <h4><i class="bi bi-info-circle"></i> Description du projet</h4>
            </div>
            <div class="card-body">
              <p>{{ $projet->description }}</p>
            </div>
          </div>

          <!-- Événements associés -->
          @if($projet->evenements->count() > 0)
          <div class="card">
            <div class="card-header">
              <h4><i class="bi bi-calendar-event"></i> Événements associés ({{ $projet->evenements->count() }})</h4>
            </div>
            <div class="card-body">
              <div class="row">
                @foreach($projet->evenements as $evenement)
                <div class="col-md-6 mb-3">
                  <div class="card border-start border-success border-3">
                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="card-title">{{ $evenement->nom }}</h6>
                        <span class="badge bg-{{ $evenement->statut == 'planifie' ? 'warning' : ($evenement->statut == 'en_cours' ? 'success' : 'secondary') }}">
                          {{ ucfirst($evenement->statut) }}
                        </span>
                      </div>
                      
                      <p class="card-text small">{{ Str::limit($evenement->description, 80) }}</p>
                      
                      <div class="mb-2">
                        <small class="text-muted">
                          <i class="bi bi-calendar"></i> {{ $evenement->date_debut ? $evenement->date_debut->format('d/m/Y H:i') : 'Date non définie' }}<br>
                          <i class="bi bi-geo-alt"></i> {{ $evenement->lieu }}<br>
                          @if($evenement->nombre_participants_max)
                            <i class="bi bi-people"></i> {{ $evenement->nombre_participants }}/{{ $evenement->nombre_participants_max }} participants
                          @else
                            <i class="bi bi-people"></i> {{ $evenement->nombre_participants }} participants
                          @endif
                        </small>
                      </div>
                      
                      <a href="{{ route('public.evenements.show', $evenement) }}" class="btn btn-outline-success btn-sm">
                        Voir détails
                      </a>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
          @endif

        </div>

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">

          <!-- Actions rapides -->
          <div class="card mb-4">
            <div class="card-header">
              <h5><i class="bi bi-lightning"></i> Actions rapides</h5>
            </div>
            <div class="card-body">
              @if($evenements_a_venir->count() > 0)
                <p class="text-success mb-3">
                  <i class="bi bi-calendar-plus"></i> 
                  {{ $evenements_a_venir->count() }} événement(s) à venir
                </p>
                <a href="{{ route('public.evenements.show', $evenements_a_venir->first()) }}" class="btn btn-success w-100 mb-2">
                  <i class="bi bi-calendar-event"></i> Prochain événement
                </a>
              @endif
              
              <a href="{{ route('public.evenements.index') }}?projet={{ $projet->id }}" class="btn btn-outline-success w-100 mb-2">
                <i class="bi bi-list"></i> Tous les événements
              </a>
              
              <a href="{{ route('public.contact') }}" class="btn btn-outline-primary w-100">
                <i class="bi bi-envelope"></i> Nous contacter
              </a>
            </div>
          </div>

          <!-- Statistiques du projet -->
          <div class="card mb-4">
            <div class="card-header">
              <h5><i class="bi bi-graph-up"></i> Statistiques</h5>
            </div>
            <div class="card-body">
              <div class="row text-center">
                <div class="col-6 border-end">
                  <h4 class="text-success">{{ $projet->evenements->count() }}</h4>
                  <small class="text-muted">Événements</small>
                </div>
                <div class="col-6">
                  <h4 class="text-success">
                    {{ $projet->evenements->sum(function($evenement) { return $evenement->nombre_participants; }) }}
                  </h4>
                  <small class="text-muted">Participants</small>
                </div>
              </div>
              
              @if($projet->evenements->count() > 0)
              <hr>
              <div class="row text-center">
                <div class="col-12">
                  <small class="text-muted">Durée moyenne des événements</small><br>
                  <strong>
                    {{ round($projet->evenements->avg(function($evenement) { 
                      return $evenement->date_debut->diffInHours($evenement->date_fin); 
                    })) }}h
                  </strong>
                </div>
              </div>
              @endif
            </div>
          </div>

          <!-- Projets similaires -->
          <div class="card">
            <div class="card-header">
              <h5><i class="bi bi-collection"></i> Projets similaires</h5>
            </div>
            <div class="card-body">
              @php
                $projets_similaires = \App\Models\Projet::where('id', '!=', $projet->id)
                  ->where('statut', '!=', 'suspendu')
                  ->latest()
                  ->take(3)
                  ->get();
              @endphp
              
              @if($projets_similaires->count() > 0)
                @foreach($projets_similaires as $projet_similaire)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                  <div class="flex-shrink-0">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                      <i class="bi bi-tree text-white"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">
                      <a href="{{ route('public.projets.show', $projet_similaire) }}" class="text-decoration-none">
                        {{ Str::limit($projet_similaire->nom, 30) }}
                      </a>
                    </h6>
                    <small class="text-muted">{{ $projet_similaire->localisation }}</small>
                  </div>
                </div>
                @endforeach
              @else
                <p class="text-muted">Aucun autre projet disponible pour le moment.</p>
              @endif
              
              <a href="{{ route('public.projets.index') }}" class="btn btn-outline-success btn-sm w-100">
                Voir tous les projets
              </a>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section><!-- /Projet Details Section -->

@endsection

@section('styles')
<style>
.page-title {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset("frontend/assets/img/features/features-4.webp") }}') center center;
    background-size: cover;
    padding: 120px 0 60px 0;
    color: white;
}

.border-start {
    border-left-width: 4px !important;
}
</style>
@endsection
