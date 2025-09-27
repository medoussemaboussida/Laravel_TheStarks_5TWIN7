@extends('layouts.public')

@section('title', 'Nos projets - UrbanGreen')
@section('description', 'Découvrez tous nos projets de végétalisation urbaine. Participez à la transformation écologique de votre ville.')

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background" data-aos="fade">
    <div class="container position-relative">
      <h1>Nos projets</h1>
      <p>Découvrez tous nos projets de végétalisation urbaine en cours et à venir</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('public.home') }}">Accueil</a></li>
          <li class="current">Projets</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Projets Section -->
  <section id="projets" class="portfolio section">
    <div class="container">
      
      <!-- Filtres -->
      <div class="row mb-4" data-aos="fade-up">
        <div class="col-12">
          <div class="d-flex justify-content-center">
            <div class="btn-group" role="group" aria-label="Filtres de statut">
              <button type="button" class="btn btn-outline-success active" data-filter="*">Tous</button>
              <button type="button" class="btn btn-outline-success" data-filter=".planifie">Planifiés</button>
              <button type="button" class="btn btn-outline-success" data-filter=".en_cours">En cours</button>
              <button type="button" class="btn btn-outline-success" data-filter=".termine">Terminés</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Grille des projets -->
      <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
        @foreach($projets as $projet)
        <div class="col-lg-4 col-md-6 portfolio-item isotope-item {{ $projet->statut }}">
          <div class="card h-100 shadow-sm">
            <div class="card-header bg-success text-white">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ $projet->nom }}</h5>
                <span class="badge bg-light text-dark">
                  {{ ucfirst(str_replace('_', ' ', $projet->statut)) }}
                </span>
              </div>
            </div>
            
            <div class="card-body d-flex flex-column">
              <p class="card-text flex-grow-1">{{ Str::limit($projet->description, 120) }}</p>
              
              <div class="mb-3">
                <small class="text-muted">
                  @if($projet->date_debut && $projet->date_fin)
                    <i class="bi bi-calendar"></i> Du {{ $projet->date_debut->format('d/m/Y') }}
                    au {{ $projet->date_fin->format('d/m/Y') }}<br>
                  @elseif($projet->date_debut)
                    <i class="bi bi-calendar"></i> Début: {{ $projet->date_debut->format('d/m/Y') }}<br>
                  @endif
                  <i class="bi bi-geo-alt"></i> {{ $projet->localisation }}<br>
                  @if($projet->budget)
                    <i class="bi bi-currency-euro"></i> Budget: {{ number_format($projet->budget, 0, ',', ' ') }}€<br>
                  @endif
                  <i class="bi bi-calendar-event"></i> {{ $projet->evenements->count() }} événement(s)
                </small>
              </div>
              
              <div class="d-flex justify-content-between align-items-center mt-auto">
                <div>
                  @if($projet->evenements->count() > 0 && $projet->evenements->first()->date_debut)
                    <small class="text-success">
                      <i class="bi bi-clock"></i>
                      Prochain événement: {{ $projet->evenements->first()->date_debut->format('d/m') }}
                    </small>
                  @endif
                </div>
                <a href="{{ route('public.projets.show', $projet) }}" class="btn btn-success btn-sm">
                  Voir détails <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <!-- Pagination -->
      @if($projets->hasPages())
      <div class="row mt-5">
        <div class="col-12 d-flex justify-content-center">
          {{ $projets->links() }}
        </div>
      </div>
      @endif

      <!-- Call to Action -->
      <div class="row mt-5" data-aos="fade-up">
        <div class="col-12 text-center">
          <div class="bg-light p-5 rounded">
            <h3>Vous avez un projet de végétalisation ?</h3>
            <p class="lead">Proposez votre projet et rejoignez notre communauté d'acteurs du changement écologique.</p>
            @auth
              @if(auth()->user()->isChefProjet() || auth()->user()->isAdmin())
                <a href="{{ route('admin.projets.create') }}" class="btn btn-success btn-lg">
                  <i class="bi bi-plus-circle"></i> Créer un projet
                </a>
              @else
                <a href="{{ route('public.contact') }}" class="btn btn-success btn-lg">
                  <i class="bi bi-envelope"></i> Nous contacter
                </a>
              @endif
            @else
              <a href="{{ route('public.contact') }}" class="btn btn-success btn-lg">
                <i class="bi bi-envelope"></i> Nous contacter
              </a>
            @endauth
          </div>
        </div>
      </div>

    </div>
  </section><!-- /Projets Section -->

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage simple des projets
    const filterButtons = document.querySelectorAll('[data-filter]');
    const projectItems = document.querySelectorAll('.portfolio-item');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            projectItems.forEach(item => {
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
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset("frontend/assets/img/features/features-3.webp") }}') center center;
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
</style>
@endsection
