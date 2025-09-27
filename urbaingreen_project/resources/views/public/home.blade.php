@extends('layouts.public')

@section('title', 'UrbanGreen - Végétalisation Urbaine')
@section('description', 'Rejoignez UrbanGreen pour participer à la végétalisation des milieux urbains. Découvrez nos projets écologiques et inscrivez-vous à nos événements.')

@section('content')

  <!-- Hero Section -->
  <section id="hero" class="hero section dark-background">
    <img src="{{ asset('frontend/assets/img/features/features-1.webp') }}" alt="" data-aos="fade-in">

    <div class="container">
      <div class="row justify-content-center text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="col-xl-6 col-lg-8">
          <h2>Végétalisons nos villes ensemble<span>.</span></h2>
          <p>Rejoignez UrbanGreen et participez à la transformation écologique de nos espaces urbains. Ensemble, créons un avenir plus vert et durable.</p>
        </div>
      </div>

      <div class="row gy-4 mt-5 justify-content-center" data-aos="fade-up" data-aos-delay="200">
        <div class="col-xl-2 col-md-3 col-6">
          <div class="icon-box">
            <i class="bi bi-tree-fill"></i>
            <h3><a href="">{{ $stats['total_projets'] }}</a></h3>
            <p>Projets actifs</p>
          </div>
        </div>
        <div class="col-xl-2 col-md-3 col-6">
          <div class="icon-box">
            <i class="bi bi-calendar-event"></i>
            <h3><a href="">{{ $stats['total_evenements'] }}</a></h3>
            <p>Événements</p>
          </div>
        </div>
        <div class="col-xl-2 col-md-3 col-6">
          <div class="icon-box">
            <i class="bi bi-people-fill"></i>
            <h3><a href="">{{ $stats['participants_total'] }}</a></h3>
            <p>Participants</p>
          </div>
        </div>
        <div class="col-xl-2 col-md-3 col-6">
          <div class="icon-box">
            <i class="bi bi-geo-alt-fill"></i>
            <h3><a href="">{{ $stats['projets_actifs'] }}</a></h3>
            <p>Zones vertes</p>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /Hero Section -->

  <!-- About Section -->
  <section id="about" class="about section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-xl-center gy-5">
        <div class="col-xl-5 content">
          <h3>À propos d'UrbanGreen</h3>
          <h2>Transformons nos villes en espaces verts</h2>
          <p>UrbanGreen est une plateforme collaborative qui encourage la végétalisation des milieux urbains. Nous connectons les citoyens, les associations et les collectivités pour créer ensemble des projets écologiques durables.</p>
          <a href="{{ route('public.about') }}" class="read-more"><span>En savoir plus</span><i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="col-xl-7">
          <div class="row gy-4 icon-boxes">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="icon-box">
                <i class="bi bi-buildings"></i>
                <h3>Jardins urbains</h3>
                <p>Création de jardins communautaires dans les espaces urbains délaissés pour favoriser la biodiversité et le lien social.</p>
              </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="icon-box">
                <i class="bi bi-clipboard-pulse"></i>
                <h3>Toitures végétalisées</h3>
                <p>Installation de toitures vertes pour améliorer l'isolation thermique et créer de nouveaux écosystèmes urbains.</p>
              </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="icon-box">
                <i class="bi bi-command"></i>
                <h3>Murs végétaux</h3>
                <p>Développement de murs végétalisés pour purifier l'air et embellir les façades urbaines.</p>
              </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="icon-box">
                <i class="bi bi-graph-up-arrow"></i>
                <h3>Sensibilisation</h3>
                <p>Organisation d'ateliers et d'événements pour sensibiliser à l'importance de la végétalisation urbaine.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

  <!-- Projets en vedette -->
  <section id="projets" class="services section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Nos projets</h2>
      <p>Découvrez nos projets de végétalisation urbaine en cours</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        @foreach($projets_featured as $projet)
        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
          <div class="service-item position-relative">
            <div class="icon">
              <i class="bi bi-tree-fill icon"></i>
            </div>
            <h4><a href="{{ route('public.projets.show', $projet) }}" class="stretched-link">{{ $projet->nom }}</a></h4>
            <p>{{ Str::limit($projet->description, 120) }}</p>
            <div class="mt-3">
              <small class="text-muted">
                <i class="bi bi-calendar"></i> {{ $projet->date_debut->format('d/m/Y') }}
                @if($projet->evenements->count() > 0)
                  | <i class="bi bi-calendar-event"></i> {{ $projet->evenements->count() }} événement(s)
                @endif
              </small>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="600">
        <a href="{{ route('public.projets.index') }}" class="btn btn-success btn-lg">Voir tous les projets</a>
      </div>
    </div>
  </section><!-- /Projets Section -->

  <!-- Événements à venir -->
  <section id="evenements" class="portfolio section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Événements à venir</h2>
      <p>Participez à nos prochains événements de végétalisation</p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        @foreach($evenements_a_venir as $evenement)
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ 200 + $loop->index * 100 }}">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <h5 class="card-title">{{ $evenement->nom }}</h5>
                <span class="badge bg-success">{{ ucfirst($evenement->statut) }}</span>
              </div>
              
              <p class="card-text">{{ Str::limit($evenement->description, 100) }}</p>
              
              <div class="mb-3">
                <small class="text-muted">
                  <i class="bi bi-calendar"></i> {{ $evenement->date_debut->format('d/m/Y H:i') }}<br>
                  <i class="bi bi-geo-alt"></i> {{ $evenement->lieu }}<br>
                  <i class="bi bi-folder"></i> {{ $evenement->projet->nom }}
                </small>
              </div>
              
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                  @if($evenement->nombre_participants_max)
                    {{ $evenement->nombre_participants }}/{{ $evenement->nombre_participants_max }} participants
                  @else
                    {{ $evenement->nombre_participants }} participants
                  @endif
                </small>
                <a href="{{ route('public.evenements.show', $evenement) }}" class="btn btn-outline-success btn-sm">
                  Voir détails
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="600">
        <a href="{{ route('public.evenements.index') }}" class="btn btn-success btn-lg">Voir tous les événements</a>
      </div>
    </div>
  </section><!-- /Événements Section -->

  <!-- Call To Action Section -->
  <section id="call-to-action" class="call-to-action section dark-background">
    <img src="{{ asset('frontend/assets/img/features/features-2.webp') }}" alt="">

    <div class="container">
      <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
        <div class="col-xl-10">
          <div class="text-center">
            <h3>Rejoignez le mouvement UrbanGreen</h3>
            <p>Ensemble, créons des villes plus vertes et durables. Inscrivez-vous dès maintenant pour participer à nos projets de végétalisation urbaine.</p>
            @guest
              <a class="cta-btn" href="{{ route('register') }}">Rejoindre UrbanGreen</a>
            @else
              <a class="cta-btn" href="{{ route('public.projets.index') }}">Découvrir les projets</a>
            @endguest
          </div>
        </div>
      </div>
    </div>
  </section><!-- /Call To Action Section -->

@endsection
