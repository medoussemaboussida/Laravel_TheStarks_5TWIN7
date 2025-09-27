@extends('layouts.public')

@section('title', 'Nos événements - UrbanGreen')
@section('description', 'Participez à nos événements de végétalisation urbaine. Ateliers, plantations, formations et bien plus encore.')

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background" data-aos="fade">
    <div class="container position-relative">
      <h1>Nos événements</h1>
      <p>Participez à nos événements de végétalisation urbaine</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('public.home') }}">Accueil</a></li>
          <li class="current">Événements</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Événements Section -->
  <section id="evenements" class="portfolio section">
    <div class="container">
      
      <!-- Filtres -->
      <div class="row mb-4" data-aos="fade-up">
        <div class="col-12">
          <div class="d-flex justify-content-center flex-wrap gap-2">
            <div class="btn-group" role="group" aria-label="Filtres de statut">
              <button type="button" class="btn btn-outline-success active" data-filter="*">Tous</button>
              <button type="button" class="btn btn-outline-success" data-filter=".planifie">Planifiés</button>
              <button type="button" class="btn btn-outline-success" data-filter=".en_cours">En cours</button>
              <button type="button" class="btn btn-outline-success" data-filter=".termine">Terminés</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Grille des événements -->
      <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
        @foreach($evenements as $evenement)
        <div class="col-lg-4 col-md-6 portfolio-item isotope-item {{ $evenement->statut }}">
          <div class="card h-100 shadow-sm">
            
            <!-- Header avec date -->
            <div class="card-header bg-success text-white">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h6 class="mb-0">{{ $evenement->date_debut ? $evenement->date_debut->format('d M Y') : 'Date non définie' }}</h6>
                  <small>{{ $evenement->date_debut ? $evenement->date_debut->format('H:i') : '' }}</small>
                </div>
                <span class="badge bg-light text-dark">
                  {{ ucfirst($evenement->statut) }}
                </span>
              </div>
            </div>
            
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $evenement->nom }}</h5>
              <p class="card-text flex-grow-1">{{ Str::limit($evenement->description, 100) }}</p>
              
              <!-- Informations de l'événement -->
              <div class="mb-3">
                <small class="text-muted">
                  <i class="bi bi-geo-alt"></i> {{ $evenement->lieu }}<br>
                  <i class="bi bi-folder"></i> {{ $evenement->projet->nom }}<br>
                  @if($evenement->nombre_participants_max)
                    <i class="bi bi-people"></i> {{ $evenement->nombre_participants }}/{{ $evenement->nombre_participants_max }} participants
                  @else
                    <i class="bi bi-people"></i> {{ $evenement->nombre_participants }} participants
                  @endif
                </small>
              </div>
              
              <!-- Indicateur de disponibilité -->
              @if($evenement->isComplet())
                <div class="alert alert-warning py-2 mb-3">
                  <small><i class="bi bi-exclamation-triangle"></i> Événement complet</small>
                </div>
              @elseif($evenement->date_debut < now())
                <div class="alert alert-info py-2 mb-3">
                  <small><i class="bi bi-clock"></i> Événement passé</small>
                </div>
              @else
                <div class="alert alert-success py-2 mb-3">
                  <small><i class="bi bi-check-circle"></i> Places disponibles</small>
                </div>
              @endif
              
              <!-- Actions -->
              <div class="d-flex justify-content-between align-items-center mt-auto">
                <div>
                  @auth
                    @if($evenement->userIsInscrit(auth()->user()))
                      <small class="text-success">
                        <i class="bi bi-check-circle-fill"></i> Inscrit
                      </small>
                    @endif
                  @endauth
                </div>
                <a href="{{ route('public.evenements.show', $evenement) }}" class="btn btn-success btn-sm">
                  Voir détails <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Pagination -->
      @if($evenements->hasPages())
      <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
          {{ $evenements->links() }}
        </div>
      </div>
      @endif

      <!-- Aucun événement -->
      @if($evenements->count() == 0)
      <div class="row mt-5">
        <div class="col-12 text-center">
          <div class="bg-light p-5 rounded">
            <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
            <h3>Aucun événement à venir</h3>
            <p class="lead">Revenez bientôt pour découvrir nos prochains événements de végétalisation urbaine.</p>
            <a href="{{ route('public.projets.index') }}" class="btn btn-success">
              <i class="bi bi-tree"></i> Découvrir nos projets
            </a>
          </div>
        </div>
      </div>
      @endif

      <!-- Call to Action -->
      <div class="row mt-5" data-aos="fade-up">
        <div class="col-12 text-center">
          <div class="bg-light p-5 rounded">
            <h3>Vous souhaitez organiser un événement ?</h3>
            <p class="lead">Rejoignez notre équipe et proposez vos propres événements de végétalisation.</p>
            @auth
              @if(auth()->user()->isChefProjet() || auth()->user()->isAdmin())
                <a href="{{ route('admin.evenements.create') }}" class="btn btn-success btn-lg">
                  <i class="bi bi-plus-circle"></i> Créer un événement
                </a>
              @else
                <a href="{{ route('public.contact') }}" class="btn btn-success btn-lg">
                  <i class="bi bi-envelope"></i> Nous contacter
                </a>
              @endif
            @else
              <a href="{{ route('register') }}" class="btn btn-success btn-lg me-2">
                <i class="bi bi-person-plus"></i> S'inscrire
              </a>
              <a href="{{ route('public.contact') }}" class="btn btn-outline-success btn-lg">
                <i class="bi bi-envelope"></i> Nous contacter
              </a>
            @endauth
          </div>
        </div>
      </div>

    </div>
  </section><!-- /Événements Section -->

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage simple des événements
    const filterButtons = document.querySelectorAll('[data-filter]');
    const eventItems = document.querySelectorAll('.portfolio-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            eventItems.forEach(item => {
                if (filter === '*' || item.classList.contains(filter.substring(1))) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection

@section('styles')
<style>
.page-title {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset("frontend/assets/img/features/features-6.webp") }}') center center;
    background-size: cover;
    padding: 120px 0 60px 0;
    color: white;
}

.portfolio-item {
    transition: transform 0.3s ease;
}

.portfolio-item:hover {
    transform: translateY(-5px);
}

.card {
    border: none;
    transition: box-shadow 0.3s ease;
}

.card:hover {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}

.alert {
    border: none;
    font-size: 0.875rem;
}
</style>
@endsection
