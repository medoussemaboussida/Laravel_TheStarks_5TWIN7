<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'UrbanGreen - Végétalisation Urbaine')</title>
  <meta name="description" content="@yield('description', 'UrbanGreen encourage la végétalisation des milieux urbains et permet aux citoyens de participer aux projets écologiques.')">
  <meta name="keywords" content="végétalisation, urbain, écologie, projets verts, environnement">

  <!-- Favicons -->
  <link href="{{ asset('frontend/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('frontend/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('frontend/assets/css/main.css') }}" rel="stylesheet">

  @yield('styles')
</head>

<body class="@yield('body-class', 'index-page')">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="{{ route('public.home') }}" class="logo d-flex align-items-center me-auto me-xl-0">
        <i class="bi bi-tree-fill me-2" style="font-size: 2rem; color: #28a745;"></i>
        <h1 class="sitename">UrbanGreen</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('public.home') }}" class="{{ request()->routeIs('public.home') ? 'active' : '' }}">Accueil</a></li>
          <li><a href="{{ route('public.projets.index') }}" class="{{ request()->routeIs('public.projets.*') ? 'active' : '' }}">Projets</a></li>
          <li><a href="{{ route('public.evenements.index') }}" class="{{ request()->routeIs('public.evenements.*') ? 'active' : '' }}">Événements</a></li>
          <li><a href="{{ route('public.about') }}" class="{{ request()->routeIs('public.about') ? 'active' : '' }}">À propos</a></li>
          <li><a href="{{ route('public.contact') }}" class="{{ request()->routeIs('public.contact') ? 'active' : '' }}">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <div class="header-social-links">
        @guest
          <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Connexion</a>
          <a href="{{ route('register') }}" class="btn btn-success">Inscription</a>
        @else
          <div class="dropdown">
            <a class="btn btn-outline-success dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('public.profile') }}">Mon profil</a></li>
              <li><a class="dropdown-item" href="{{ route('public.mes-inscriptions') }}">Mes inscriptions</a></li>
              @if(auth()->user()->isAdmin() || auth()->user()->isChefProjet())
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Administration</a></li>
              @endif
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">Déconnexion</button>
                </form>
              </li>
            </ul>
          </div>
        @endguest
      </div>

    </div>
  </header>

  <main class="main">
    
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @yield('content')

  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ route('public.home') }}" class="logo d-flex align-items-center">
            <span class="sitename">UrbanGreen</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Encourager la végétalisation des milieux urbains</p>
            <p>pour un environnement plus vert et durable.</p>
            <p class="mt-3"><strong>Téléphone:</strong> <span>+33 1 23 45 67 89</span></p>
            <p><strong>Email:</strong> <span>contact@urbangreen.fr</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Liens utiles</h4>
          <ul>
            <li><a href="{{ route('public.home') }}">Accueil</a></li>
            <li><a href="{{ route('public.about') }}">À propos</a></li>
            <li><a href="{{ route('public.projets.index') }}">Projets</a></li>
            <li><a href="{{ route('public.evenements.index') }}">Événements</a></li>
            <li><a href="{{ route('public.contact') }}">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nos services</h4>
          <ul>
            <li><a href="#">Jardins communautaires</a></li>
            <li><a href="#">Toitures végétalisées</a></li>
            <li><a href="#">Murs végétaux</a></li>
            <li><a href="#">Formations</a></li>
            <li><a href="#">Conseils</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4>Notre Newsletter</h4>
          <p>Abonnez-vous pour recevoir les dernières nouvelles sur nos projets et événements !</p>
          <form action="#" method="post" class="php-email-form">
            <div class="newsletter-form">
              <input type="email" name="email" placeholder="Votre email">
              <input type="submit" value="S'abonner">
            </div>
            <div class="loading">Chargement</div>
            <div class="error-message"></div>
            <div class="sent-message">Votre demande d'abonnement a été envoyée. Merci !</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">UrbanGreen</strong> <span>Tous droits réservés</span></p>
      <div class="credits">
        Conçu avec <i class="bi bi-heart-fill text-danger"></i> pour un avenir plus vert
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('frontend/assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('frontend/assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('frontend/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

  @yield('scripts')

</body>

</html>
