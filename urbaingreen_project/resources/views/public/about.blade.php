@extends('layouts.public')

@section('title', 'À propos - UrbanGreen')
@section('description', 'Découvrez UrbanGreen, notre mission de végétalisation urbaine et notre équipe passionnée par l\'écologie urbaine.')

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background" data-aos="fade">
    <div class="container position-relative">
      <h1>À propos d'UrbanGreen</h1>
      <p>Notre mission : végétaliser les villes pour un avenir durable</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('public.home') }}">Accueil</a></li>
          <li class="current">À propos</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- About Section -->
  <section id="about" class="about section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-xl-center gy-5">
        <div class="col-xl-5 content">
          <h3>Notre vision</h3>
          <h2>Des villes vertes et durables</h2>
          <p>UrbanGreen est née de la conviction que nos villes peuvent et doivent devenir plus vertes. Face aux défis environnementaux actuels, nous croyons en la force collective des citoyens pour transformer nos espaces urbains.</p>
          <p>Notre plateforme connecte les passionnés d'écologie urbaine, les associations, les collectivités et tous ceux qui souhaitent contribuer à un avenir plus vert.</p>
        </div>

        <div class="col-xl-7">
          <div class="row gy-4 icon-boxes">
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="icon-box">
                <i class="bi bi-tree-fill"></i>
                <h3>Biodiversité urbaine</h3>
                <p>Créer des écosystèmes urbains riches et diversifiés pour favoriser la faune et la flore en ville.</p>
              </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="icon-box">
                <i class="bi bi-people-fill"></i>
                <h3>Communauté engagée</h3>
                <p>Rassembler les citoyens autour de projets concrets de végétalisation et de sensibilisation.</p>
              </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="icon-box">
                <i class="bi bi-lightbulb"></i>
                <h3>Innovation verte</h3>
                <p>Promouvoir les solutions innovantes et durables pour la végétalisation urbaine.</p>
              </div>
            </div>
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="icon-box">
                <i class="bi bi-heart-fill"></i>
                <h3>Bien-être urbain</h3>
                <p>Améliorer la qualité de vie en ville grâce aux espaces verts et à la nature urbaine.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /About Section -->

  <!-- Stats Section -->
  <section id="stats" class="stats section light-background">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
          <i class="bi bi-tree-fill"></i>
          <div class="stats-item">
            <span data-purecounter-start="0" data-purecounter-end="{{ \App\Models\Projet::count() }}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Projets réalisés</p>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
          <i class="bi bi-calendar-event"></i>
          <div class="stats-item">
            <span data-purecounter-start="0" data-purecounter-end="{{ \App\Models\Evenement::count() }}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Événements organisés</p>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
          <i class="bi bi-people"></i>
          <div class="stats-item">
            <span data-purecounter-start="0" data-purecounter-end="{{ \App\Models\Inscription::where('statut', 'confirmee')->count() }}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Participants engagés</p>
          </div>
        </div><!-- End Stats Item -->

        <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
          <i class="bi bi-geo-alt"></i>
          <div class="stats-item">
            <span data-purecounter-start="0" data-purecounter-end="{{ \App\Models\Projet::distinct('localisation')->count() }}" data-purecounter-duration="1" class="purecounter"></span>
            <p>Villes impliquées</p>
          </div>
        </div><!-- End Stats Item -->
      </div>
    </div>
  </section><!-- /Stats Section -->

  <!-- Team Section -->
  <section id="team" class="team section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Notre équipe</h2>
      <p>Des passionnés d'écologie urbaine au service de votre ville</p>
    </div>

    <div class="container">
      <div class="row gy-4">

        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="team-member">
            <div class="member-img">
              <img src="{{ asset('frontend/assets/img/person/person-f-7.webp') }}" class="img-fluid" alt="">
              <div class="social">
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4>Marie Dubois</h4>
              <span>Directrice générale</span>
              <p>Experte en développement durable avec 15 ans d'expérience dans l'écologie urbaine.</p>
            </div>
          </div>
        </div><!-- End Team Member -->

        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="team-member">
            <div class="member-img">
              <img src="{{ asset('frontend/assets/img/person/person-m-7.webp') }}" class="img-fluid" alt="">
              <div class="social">
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4>Pierre Martin</h4>
              <span>Chef de projet</span>
              <p>Architecte paysagiste spécialisé dans la conception d'espaces verts urbains innovants.</p>
            </div>
          </div>
        </div><!-- End Team Member -->

        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="team-member">
            <div class="member-img">
              <img src="{{ asset('frontend/assets/img/person/person-f-8.webp') }}" class="img-fluid" alt="">
              <div class="social">
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4>Sophie Leroy</h4>
              <span>Responsable communauté</span>
              <p>Animatrice passionnée, elle coordonne les événements et fédère notre communauté.</p>
            </div>
          </div>
        </div><!-- End Team Member -->

        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="team-member">
            <div class="member-img">
              <img src="{{ asset('frontend/assets/img/person/person-m-8.webp') }}" class="img-fluid" alt="">
              <div class="social">
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
            <div class="member-info">
              <h4>Thomas Rousseau</h4>
              <span>Développeur</span>
              <p>Développeur full-stack engagé pour l'environnement, créateur de cette plateforme.</p>
            </div>
          </div>
        </div><!-- End Team Member -->

      </div>
    </div>
  </section><!-- /Team Section -->

  <!-- Values Section -->
  <section id="values" class="features section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Nos valeurs</h2>
      <p>Les principes qui guident notre action quotidienne</p>
    </div>

    <div class="container">
      <div class="row gy-4">

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="features-item">
            <i class="bi bi-shield-check" style="color: #28a745;"></i>
            <h3><a href="" class="stretched-link">Transparence</a></h3>
            <p>Nous croyons en la transparence totale de nos actions, de nos financements et de nos résultats.</p>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="features-item">
            <i class="bi bi-recycle" style="color: #28a745;"></i>
            <h3><a href="" class="stretched-link">Durabilité</a></h3>
            <p>Tous nos projets sont conçus dans une démarche de développement durable et de respect de l'environnement.</p>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="features-item">
            <i class="bi bi-people-fill" style="color: #28a745;"></i>
            <h3><a href="" class="stretched-link">Inclusion</a></h3>
            <p>Nos projets sont ouverts à tous, sans distinction, pour créer une communauté diverse et engagée.</p>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="features-item">
            <i class="bi bi-lightbulb-fill" style="color: #28a745;"></i>
            <h3><a href="" class="stretched-link">Innovation</a></h3>
            <p>Nous encourageons l'innovation et l'expérimentation pour trouver les meilleures solutions vertes.</p>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
          <div class="features-item">
            <i class="bi bi-hand-thumbs-up-fill" style="color: #28a745;"></i>
            <h3><a href="" class="stretched-link">Collaboration</a></h3>
            <p>Le travail en équipe et la collaboration sont au cœur de notre approche pour maximiser l'impact.</p>
          </div>
        </div><!-- End Feature Item -->

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
          <div class="features-item">
            <i class="bi bi-award-fill" style="color: #28a745;"></i>
            <h3><a href="" class="stretched-link">Excellence</a></h3>
            <p>Nous visons l'excellence dans tous nos projets pour garantir un impact positif durable.</p>
          </div>
        </div><!-- End Feature Item -->

      </div>
    </div>
  </section><!-- /Values Section -->

@endsection

@section('styles')
<style>
.page-title {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset("frontend/assets/img/about/about-11.webp") }}') center center;
    background-size: cover;
    padding: 120px 0 60px 0;
    color: white;
}

.team-member {
    text-align: center;
    margin-bottom: 30px;
}

.team-member .member-img {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
}

.team-member .member-img img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.team-member .social {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(40, 167, 69, 0.9);
    padding: 10px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.team-member:hover .social {
    transform: translateY(0);
}

.team-member .social a {
    color: white;
    margin: 0 5px;
    font-size: 18px;
}

.team-member .member-info {
    padding: 20px 0;
}

.team-member .member-info h4 {
    color: #28a745;
    margin-bottom: 5px;
}

.team-member .member-info span {
    color: #666;
    font-weight: 500;
}

.features-item {
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.features-item:hover {
    transform: translateY(-5px);
}

.features-item i {
    font-size: 3rem;
    margin-bottom: 20px;
}
</style>
@endsection
