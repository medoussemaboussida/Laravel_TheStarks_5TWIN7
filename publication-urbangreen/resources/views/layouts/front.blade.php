<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - Landify Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


  <!-- =======================================================
  * Template Name: Landify
  * Template URL: https://bootstrapmade.com/landify-bootstrap-landing-page-template/
  * Updated: Aug 04 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header shadow-sm bg-white fixed-top py-2">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center gap-2 text-decoration-none">
        <img src="{{ asset('img/undraw_rocket.svg') }}" alt="Logo" style="height: 38px;">
        <span class="fw-bold fs-4 text-primary">UrbanGreen</span>
      </a>
      <nav class="d-none d-md-block">
        <ul class="nav gap-3">
          <li class="nav-item"><a class="nav-link text-dark fw-semibold" href="#publications">Publications</a></li>
          <li class="nav-item"><a class="nav-link text-dark fw-semibold" href="#contact">Contact</a></li>
        </ul>
      </nav>
      <a class="btn btn-primary rounded-pill px-4 shadow-sm" href="#publications">Découvrir</a>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section Modern -->
    <section class="hero-section d-flex align-items-center justify-content-center text-center" style="min-height: 60vh; background: linear-gradient(120deg, #e0f7fa 0%, #e3ffe6 100%);">
      <div class="container py-5">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <h1 class="display-3 fw-bold mb-3 text-primary" data-aos="fade-down">Bienvenue sur UrbanGreen</h1>
            <p class="lead text-dark mb-4" data-aos="fade-up" data-aos-delay="100">Découvrez, partagez et inspirez-vous des meilleures publications de notre communauté !</p>
            <a href="#publications" class="btn btn-lg btn-success rounded-pill px-5 shadow" data-aos="zoom-in" data-aos-delay="200">Voir les publications</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Section: Publications Grid améliorée -->
    <section id="publications" class="py-5" style="background: #f8f9fa; min-height: 80vh;">
      <div class="container">
        <div class="row mb-4">
          <div class="col text-center">
            <h2 class="display-4 fw-bold gradient-text mb-2" data-aos="fade-down">Nos Publications</h2>
            <p class="lead text-muted" data-aos="fade-up" data-aos-delay="100">Découvrez nos dernières publications, projets et actualités. Chaque publication est soigneusement sélectionnée pour vous inspirer et vous informer.</p>
          </div>
        </div>
        <div class="row g-4">
          @forelse($publications as $publication)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch" data-aos="zoom-in-up" data-aos-delay="{{ 100 + ($loop->index % 4) * 100 }}">
              <a href="{{ route('publications.show', $publication->id) }}" class="text-decoration-none w-100 h-100 publication-link-card">
                <div class="publication-card-glass position-relative w-100 h-100 d-flex flex-column">
                  <div class="publication-img-glass position-relative overflow-hidden">
                    <img src="{{ $publication->image ? asset('storage/' . $publication->image) : asset('img/undraw_posting_photo.svg') }}" class="w-100" alt="{{ $publication->titre }}" style="height: 220px; object-fit: cover; border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem; transition: transform .4s cubic-bezier(.4,2,.6,1);">
                    <span class="badge date-badge-glass position-absolute top-0 end-0 m-2 px-3 py-2 shadow" style="font-size: 0.95rem;">{{ $publication->created_at->format('d/m/Y') }}</span>
                    <div class="img-gradient-overlay position-absolute top-0 start-0 w-100 h-100"></div>
                  </div>
                  <div class="card-body d-flex flex-column flex-grow-1 p-4">
                    <h5 class="card-title fw-bold mb-2 text-dark" style="font-family:'Rubik',sans-serif;">{{ $publication->titre }}</h5>
                    <p class="card-text text-secondary mb-3 flex-grow-1" style="font-size:1.05rem;">{{ $publication->description }}</p>
                    <div class="d-flex align-items-center mt-auto gap-2">
                      <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Auteur" class="rounded-circle border border-2 border-success" width="36" height="36">
                      <span class="text-muted small">Par <b>{{ $publication->user->name ?? 'Admin' }}</b></span>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          @empty
            <div class="col-12">
              <div class="alert alert-info text-center py-5" data-aos="fade-in">
                <i class="bi bi-info-circle fs-2 mb-2"></i><br>
                Aucune publication trouvée pour le moment.
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <style>
      .publication-link-card {
        display: block;
        cursor: pointer;
        transition: box-shadow .2s, transform .2s;
      }
      .publication-link-card:hover {
        text-decoration: none;
        box-shadow: none;
      }
      .gradient-text {
        background: linear-gradient(90deg,#1cc88a 0%,#4e73df 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }
      .publication-card-glass {
        border-radius: 1.5rem;
        background: rgba(255,255,255,0.7);
        box-shadow: 0 8px 32px rgba(76,175,80,0.10), 0 1.5px 8px rgba(78,115,223,0.08);
        backdrop-filter: blur(8px) saturate(1.2);
        transition: box-shadow .3s, transform .2s;
        overflow: hidden;
        position: relative;
      }
      .publication-card-glass:hover {
        box-shadow: 0 16px 48px rgba(76,175,80,0.18), 0 4px 16px rgba(78,115,223,0.13);
        transform: translateY(-8px) scale(1.035);
      }
      .publication-img-glass {
        background: linear-gradient(120deg,#e3ffe6 0%,#e0f7fa 100%);
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        overflow: hidden;
        position: relative;
      }
      .publication-card-glass:hover img {
        transform: scale(1.07) rotate(-1deg);
        filter: brightness(1.08) saturate(1.1);
      }
      .img-gradient-overlay {
        pointer-events: none;
        background: linear-gradient(180deg,rgba(255,255,255,0.0) 60%,rgba(44,62,80,0.08) 100%);
        opacity: 0.7;
        border-top-left-radius: 1.5rem;
        border-top-right-radius: 1.5rem;
        z-index: 2;
      }
      .date-badge-glass {
        background: linear-gradient(90deg,#1cc88a 0%,#4e73df 100%)!important;
        color: #fff;
        border-radius: 1rem;
        font-weight: 500;
        letter-spacing: 0.02em;
        box-shadow: 0 2px 8px rgba(44,62,80,0.08);
        z-index: 3;
      }
      .hero-section {
        background: linear-gradient(120deg, #e0f7fa 0%, #e3ffe6 100%);
      }
      .header {
        transition: box-shadow .2s;
      }
      .header.scrolled {
        box-shadow: 0 2px 16px rgba(44,62,80,0.07);
      }
    </style>



    

    

    

    
    
  </main>

  <footer id="footer" class="footer bg-white border-top pt-5 pb-3 mt-5">
    <div class="container">
      <div class="row gy-4 align-items-center">
        <div class="col-lg-6 text-lg-start text-center mb-3 mb-lg-0">
          <a href="/" class="logo d-inline-flex align-items-center gap-2 text-decoration-none mb-2">
            <img src="{{ asset('img/undraw_rocket.svg') }}" alt="Logo" style="height: 32px;">
            <span class="fw-bold fs-5 text-primary">UrbanGreen</span>
          </a>
          <p class="mb-0 text-muted small">&copy; {{ date('Y') }} UrbanGreen. Tous droits réservés.</p>
        </div>
        <div class="col-lg-6 text-lg-end text-center">
          <div class="social-links d-inline-flex gap-3">
            <a href="#" class="text-primary fs-4"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-info fs-4"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="text-danger fs-4"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-primary fs-4"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>