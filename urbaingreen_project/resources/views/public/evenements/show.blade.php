@extends('layouts.public')

@section('title', $evenement->nom . ' - UrbanGreen')
@section('description', Str::limit($evenement->description, 160))

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background" data-aos="fade">
    <div class="container position-relative">
      <h1>{{ $evenement->nom }}</h1>
      <p>{{ $evenement->date_debut ? $evenement->date_debut->format('d F Y à H:i') : 'Date non définie' }} - {{ $evenement->lieu }}</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('public.home') }}">Accueil</a></li>
          <li><a href="{{ route('public.evenements.index') }}">Événements</a></li>
          <li class="current">{{ $evenement->nom }}</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Événement Details Section -->
  <section id="evenement-details" class="service-details section">
    <div class="container">
      <div class="row gy-5">

        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
          
          <!-- Statut et informations principales -->
          <div class="card mb-4">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                  <span class="badge bg-{{ $evenement->statut == 'planifie' ? 'warning' : ($evenement->statut == 'en_cours' ? 'success' : 'secondary') }} fs-6">
                    {{ ucfirst($evenement->statut) }}
                  </span>
                  @if($evenement->isComplet())
                    <span class="badge bg-danger fs-6 ms-2">Complet</span>
                  @endif
                </div>
                <div class="text-end">
                  <small class="text-muted">
                    Créé le {{ $evenement->created_at->format('d/m/Y') }}
                  </small>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <p><strong><i class="bi bi-calendar"></i> Date et heure:</strong><br>
                  {{ $evenement->date_debut ? $evenement->date_debut->format('d/m/Y à H:i') : 'Date non définie' }}</p>
                  @if($evenement->date_fin)
                    <p><strong><i class="bi bi-calendar-check"></i> Fin prévue:</strong><br>
                    {{ $evenement->date_fin->format('d/m/Y à H:i') }}</p>
                  @endif
                </div>
                <div class="col-md-6">
                  <p><strong><i class="bi bi-geo-alt"></i> Lieu:</strong><br>
                  {{ $evenement->lieu }}</p>
                  @if($evenement->nombre_participants_max)
                    <p><strong><i class="bi bi-people"></i> Participants:</strong><br>
                    {{ $evenement->nombre_participants }}/{{ $evenement->nombre_participants_max }}</p>
                  @else
                    <p><strong><i class="bi bi-people"></i> Participants:</strong><br>
                    {{ $evenement->nombre_participants }}</p>
                  @endif
                </div>
              </div>
              
              <!-- Projet associé -->
              <div class="mt-3 p-3 bg-light rounded">
                <h6><i class="bi bi-folder"></i> Projet associé</h6>
                <a href="{{ route('public.projets.show', $evenement->projet) }}" class="text-decoration-none">
                  <strong>{{ $evenement->projet->nom }}</strong>
                </a>
                <p class="mb-0 small text-muted">{{ Str::limit($evenement->projet->description, 100) }}</p>
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="card mb-4">
            <div class="card-header">
              <h4><i class="bi bi-info-circle"></i> Description de l'événement</h4>
            </div>
            <div class="card-body">
              <p>{{ $evenement->description }}</p>
            </div>
          </div>

          <!-- Participants inscrits -->
          @if($evenement->inscriptions->where('statut', 'confirmee')->count() > 0)
          <div class="card">
            <div class="card-header">
              <h4><i class="bi bi-people"></i> Participants confirmés ({{ $evenement->inscriptions->where('statut', 'confirmee')->count() }})</h4>
            </div>
            <div class="card-body">
              <div class="row">
                @foreach($evenement->inscriptions->where('statut', 'confirmee')->take(12) as $inscription)
                <div class="col-md-4 col-sm-6 mb-2">
                  <div class="d-flex align-items-center">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                      <i class="bi bi-person text-white small"></i>
                    </div>
                    <span class="small">{{ $inscription->user->name }}</span>
                  </div>
                </div>
                @endforeach
              </div>
              
              @if($evenement->inscriptions->where('statut', 'confirmee')->count() > 12)
                <p class="text-muted small mt-2">
                  Et {{ $evenement->inscriptions->where('statut', 'confirmee')->count() - 12 }} autres participants...
                </p>
              @endif
            </div>
          </div>
          @endif

        </div>

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">

          <!-- Inscription -->
          <div class="card mb-4">
            <div class="card-header">
              <h5><i class="bi bi-calendar-plus"></i> Inscription</h5>
            </div>
            <div class="card-body">
              @guest
                <p class="text-muted mb-3">Vous devez être connecté pour vous inscrire à cet événement.</p>
                <a href="{{ route('login') }}" class="btn btn-success w-100 mb-2">
                  <i class="bi bi-box-arrow-in-right"></i> Se connecter
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-success w-100">
                  <i class="bi bi-person-plus"></i> Créer un compte
                </a>
              @else
                @if($user_inscription)
                  <!-- Utilisateur déjà inscrit -->
                  <div class="alert alert-{{ $user_inscription->statut == 'confirmee' ? 'success' : ($user_inscription->statut == 'en_attente' ? 'warning' : 'danger') }}">
                    <i class="bi bi-{{ $user_inscription->statut == 'confirmee' ? 'check-circle' : ($user_inscription->statut == 'en_attente' ? 'clock' : 'x-circle') }}"></i>
                    <strong>
                      @if($user_inscription->statut == 'confirmee')
                        Inscription confirmée
                      @elseif($user_inscription->statut == 'en_attente')
                        Inscription en attente
                      @else
                        Inscription annulée
                      @endif
                    </strong>
                  </div>
                  
                  @if($user_inscription->commentaire)
                    <p class="small text-muted">
                      <strong>Votre commentaire:</strong><br>
                      {{ $user_inscription->commentaire }}
                    </p>
                  @endif
                  
                  @if($user_inscription->statut != 'annulee')
                    <form method="POST" action="{{ route('public.evenements.annuler', $evenement) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger w-100" 
                              onclick="return confirm('Êtes-vous sûr de vouloir annuler votre inscription ?')">
                        <i class="bi bi-x-circle"></i> Annuler l'inscription
                      </button>
                    </form>
                  @endif
                @else
                  <!-- Formulaire d'inscription -->
                  @if($evenement->isComplet())
                    <div class="alert alert-warning">
                      <i class="bi bi-exclamation-triangle"></i>
                      <strong>Événement complet</strong><br>
                      Cet événement a atteint sa capacité maximale.
                    </div>
                  @elseif($evenement->date_debut < now())
                    <div class="alert alert-info">
                      <i class="bi bi-clock"></i>
                      <strong>Événement passé</strong><br>
                      Cet événement a déjà eu lieu.
                    </div>
                  @else
                    <form method="POST" action="{{ route('public.evenements.inscrire', $evenement) }}">
                      @csrf
                      <div class="mb-3">
                        <label for="commentaire" class="form-label">Commentaire (optionnel)</label>
                        <textarea class="form-control" id="commentaire" name="commentaire" rows="3" 
                                  placeholder="Dites-nous pourquoi vous souhaitez participer..."></textarea>
                      </div>
                      <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-calendar-plus"></i> S'inscrire à l'événement
                      </button>
                    </form>
                  @endif
                @endif
              @endauth
            </div>
          </div>

          <!-- Informations pratiques -->
          <div class="card mb-4">
            <div class="card-header">
              <h5><i class="bi bi-info-circle"></i> Informations pratiques</h5>
            </div>
            <div class="card-body">
              <div class="mb-3">
                <strong>Durée estimée:</strong><br>
                @if($evenement->date_fin)
                  {{ $evenement->date_debut->diffForHumans($evenement->date_fin, true) }}
                @else
                  Non spécifiée
                @endif
              </div>
              
              <div class="mb-3">
                <strong>Matériel nécessaire:</strong><br>
                <small class="text-muted">
                  Vêtements adaptés au jardinage, gants (fournis si besoin)
                </small>
              </div>
              
              <div class="mb-3">
                <strong>Accessibilité:</strong><br>
                <small class="text-muted">
                  Événement ouvert à tous, aucune expérience requise
                </small>
              </div>
              
              <div>
                <strong>Contact:</strong><br>
                <a href="{{ route('public.contact') }}" class="btn btn-outline-primary btn-sm">
                  <i class="bi bi-envelope"></i> Nous contacter
                </a>
              </div>
            </div>
          </div>

          <!-- Événements similaires -->
          <div class="card">
            <div class="card-header">
              <h5><i class="bi bi-calendar-event"></i> Autres événements</h5>
            </div>
            <div class="card-body">
              @php
                $autres_evenements = \App\Models\Evenement::where('id', '!=', $evenement->id)
                  ->where('date_debut', '>', now())
                  ->orderBy('date_debut')
                  ->take(3)
                  ->get();
              @endphp
              
              @if($autres_evenements->count() > 0)
                @foreach($autres_evenements as $autre_evenement)
                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                  <div class="flex-shrink-0">
                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                      <i class="bi bi-calendar text-white"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">
                      <a href="{{ route('public.evenements.show', $autre_evenement) }}" class="text-decoration-none">
                        {{ Str::limit($autre_evenement->nom, 25) }}
                      </a>
                    </h6>
                    <small class="text-muted">
                      {{ $autre_evenement->date_debut ? $autre_evenement->date_debut->format('d/m H:i') : 'Date non définie' }} - {{ $autre_evenement->lieu }}
                    </small>
                  </div>
                </div>
                @endforeach
              @else
                <p class="text-muted">Aucun autre événement à venir pour le moment.</p>
              @endif
              
              <a href="{{ route('public.evenements.index') }}" class="btn btn-outline-success btn-sm w-100">
                Voir tous les événements
              </a>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section><!-- /Événement Details Section -->

@endsection

@section('styles')
<style>
.page-title {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset("frontend/assets/img/services/services-1.webp") }}') center center;
    background-size: cover;
    padding: 120px 0 60px 0;
    color: white;
}
</style>
@endsection
