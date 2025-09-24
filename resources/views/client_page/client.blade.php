<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'Landify') }} - Espace Vert</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('favicon.ico') }}" rel="icon">
    <link href="{{ asset('apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect crossorigin">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    @vite([
        'resources/clientPageAssets/vendor/bootstrap/css/bootstrap.min.css',
        'resources/clientPageAssets/vendor/bootstrap-icons/bootstrap-icons.css',
        'resources/clientPageAssets/vendor/glightbox/css/glightbox.min.css',
        'resources/clientPageAssets/vendor/swiper/swiper-bundle.min.css'
    ])

    <!-- Main CSS File -->
    @vite(['resources/clientPageAssets/css/main.css'])

    <!-- Debug CSS -->
    <style>
        .main { display: block !important; }
        .section { display: block !important; }
        .horizontal-scroll {
            overflow-x: auto;
            white-space: nowrap;
            padding: 20px 0;
        }
        .horizontal-scroll .card {
            display: inline-block;
            margin-right: 15px;
            width: 300px;
            position: relative;
            overflow: hidden;
        }
        .horizontal-scroll .card:last-child {
            margin-right: 0;
        }
        .status-bar {
            position: absolute;
            top: 0;
            right: 0;
            width: 10px;
            height: 100%;
            background-color: #ccc; /* Default gray for fallback */
        }
        .status-bar.bon {
            background-color: #28a745; /* Green for "bon" */
        }
        .status-bar.moyen {
            background-color: #ffc107; /* Yellow for "moyen" */
        }
        .status-bar.mauvais {
            background-color: #dc3545; /* Red for "mauvais" */
        }
    </style>
</head>
<body class="index-page">

    <div id="wrapper">
        <!-- Navbar -->
        @include('client_page.partials.navbar')

        <!-- Main Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Main Content -->
                <main class="main">
                    <!-- Hero Section -->
                    <section id="hero" class="hero section">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6 order-2 order-lg-1">
                                    <div class="hero-content">
                                        <h1 class="hero-title">Creating Digital Experiences That Matter</h1>
                                        <p class="hero-description">We craft beautiful, functional, and meaningful digital solutions that help businesses connect with their audiences in authentic ways.</p>
                                        <div class="hero-actions">
                                            <a href="#about" class="btn-primary">Start Your Journey</a>
                                            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn-secondary glightbox">
                                                <i class="bi bi-play-circle"></i>
                                                <span>Watch Our Story</span>
                                            </a>
                                        </div>
                                        <div class="hero-stats">
                                            <div class="stat-item">
                                                <span class="stat-number">150+</span>
                                                <span class="stat-label">Projects Completed</span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-number">98%</span>
                                                <span class="stat-label">Client Satisfaction</span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-number">24/7</span>
                                                <span class="stat-label">Support Available</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 order-1 order-lg-2">
                                    <div class="hero-visual">
                                        <div class="hero-image-wrapper">
                                            <img src="{{ asset('img/illustration/illustration-15.webp') }}" class="img-fluid hero-image" alt="Hero Image">
                                            <div class="floating-elements">
                                                <div class="floating-card card-1">
                                                    <i class="bi bi-lightbulb"></i>
                                                    <span>Innovation</span>
                                                </div>
                                                <div class="floating-card card-2">
                                                    <i class="bi bi-award"></i>
                                                    <span>Excellence</span>
                                                </div>
                                                <div class="floating-card card-3">
                                                    <i class="bi bi-people"></i>
                                                    <span>Collaboration</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section><!-- /Hero Section -->

                    <!-- Espace Vert Cards Section -->
                    <section id="espace-verts" class="section">
                        <div class="container">
                            <h2 class="text-center mb-4">Projets Espaces Verts</h2>
                            <div class="horizontal-scroll">
                                @forelse ($espacesVerts as $espaceVert)
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $espaceVert->nom }}</h5>
                                            <p class="card-text">
                                                Type: {{ $espaceVert->type }}<br>
                                                Superficie: {{ $espaceVert->superficie }} m²<br>
                                                État: {{ $espaceVert->etat }}
                                            </p>
                                        </div>
                                        <div class="status-bar {{ $espaceVert->etat }}"></div>
                                    </div>
                                @empty
                                    <p class="text-center">No green spaces available.</p>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>

        <!-- Footer -->
        @include('client_page.partials.footer')

    </div>

    <!-- Vendor JS Files -->
    @vite([
        'resources/clientPageAssets/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'resources/clientPageAssets/vendor/php-email-form/validate.js',
        'resources/clientPageAssets/vendor/glightbox/js/glightbox.min.js',
        'resources/clientPageAssets/vendor/swiper/swiper-bundle.min.js',
        'resources/clientPageAssets/vendor/purecounter/purecounter_vanilla.js'
    ])

    <!-- Main JS File -->
    @vite(['resources/clientPageAssets/js/main.js'])

</body>
</html>