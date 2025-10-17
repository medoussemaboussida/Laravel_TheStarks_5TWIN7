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

                    <!-- Publications Section -->
                    <section id="publications" class="section py-5" style="background: #f8f9fa;">
                        <div class="container">
                            <h2 class="text-center mb-4" style="font-family: 'Rubik', sans-serif; color: #1cc88a;">Nos Publications</h2>
                            <div class="row justify-content-center mb-4">
                                <div class="col-md-8">
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="text" id="search-publication" class="form-control form-control-lg shadow-sm" placeholder="Rechercher une publication..." style="border-radius: 2rem; font-size: 1.1rem; padding: 0.75rem 1.5rem; border: 2px solid #1cc88a; background: #fff; transition: box-shadow 0.2s;" autocomplete="off">
                                        <select id="sort-publication" class="form-select form-select-lg shadow-sm" style="border-radius:2rem; font-size:1.1rem; padding:0.75rem 1.5rem; border:2px solid #1cc88a; background:#fff; transition:box-shadow 0.2s; max-width:180px;">
                                            <option value="desc" selected>Nouveaux</option>
                                            <option value="asc">Anciens</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap justify-content-center gap-4" id="publications-list">
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const searchInput = document.getElementById('search-publication');
                            const sortSelect = document.getElementById('sort-publication');
                            const publicationsList = document.getElementById('publications-list');
                            let timer;
                            function fetchPublications() {
                                clearTimeout(timer);
                                timer = setTimeout(() => {
                                    const query = searchInput.value.trim();
                                    const sort = sortSelect.value;
                                    fetch(`/publications?search=${encodeURIComponent(query)}&sort=${sort}`, {
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    })
                                        .then(response => response.text())
                                        .then(html => {
                                            const tempDiv = document.createElement('div');
                                            tempDiv.innerHTML = html;
                                            const newList = tempDiv.querySelector('#publications-list');
                                            if (newList) {
                                                publicationsList.innerHTML = newList.innerHTML;
                                            }
                                        });
                                }, 350);
                            }
                            searchInput.addEventListener('input', fetchPublications);
                            sortSelect.addEventListener('change', fetchPublications);
                        });
                    </script>
                                @include('client_page.partials.publications_list', ['publications' => $publications])

                    <style>
                        .publication-modern-card {
                            background: #fff;
                            border-radius: 1.25rem;
                            box-shadow: 0 4px 24px rgba(44,62,80,0.10), 0 1.5px 8px rgba(78,115,223,0.08);
                            transition: box-shadow .25s, transform .18s;
                            width: 320px;
                            min-width: 280px;
                            max-width: 100%;
                            margin-bottom: 1.5rem;
                            overflow: hidden;
                            position: relative;
                            border: 1.5px solid #e0f7fa;
                        }
                        .publication-modern-card:hover {
                            box-shadow: 0 12px 36px rgba(44,62,80,0.16), 0 4px 16px rgba(78,115,223,0.13);
                            transform: translateY(-6px) scale(1.025);
                            border-color: #1cc88a;
                        }
                        .publication-modern-img {
                            width: 100%;
                            border-radius: 1.25rem 1.25rem 0 0;
                            overflow: hidden;
                            position: relative;
                        }
                        .publication-modern-date {
                            background: linear-gradient(90deg,#1cc88a 0%,#4e73df 100%)!important;
                            color: #fff;
                            border-radius: 1rem;
                            font-weight: 500;
                            letter-spacing: 0.02em;
                            box-shadow: 0 2px 8px rgba(44,62,80,0.08);
                            z-index: 3;
                            font-size: 0.98rem;
                        }
                        @media (max-width: 600px) {
                            .publication-modern-card {
                                width: 98vw;
                                min-width: unset;
                            }
                        }
                    </style>
                </main>

                <!-- Bâtiments Section -->
                <section id="batiments" class="section py-5">
                    <div class="container">
                        <h2 class="text-center mb-4" style="font-family: 'Rubik', sans-serif; color: #1cc88a;">Gestion des Bâtiments</h2>

                        <!-- Champ de recherche -->
                        <div class="d-flex justify-content-center mb-4">
                            <div class="col-md-8">
                                <input type="text" id="search-batiment" class="form-control form-control-lg shadow-sm" placeholder="Rechercher un bâtiment par type, adresse ou zone..." style="border-radius: 2rem; font-size: 1.1rem; padding: 0.75rem 1.5rem; border: 2px solid #1cc88a; background: #fff; transition: box-shadow 0.2s;" autocomplete="off">
                            </div>
                        </div>

                        <!-- Messages de succès/erreur -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Formulaire de création -->
                        <div class="card mb-4">
                            <div class="card-header" style="background: #1cc88a; color: white;">
                                <h5 class="mb-0">Ajouter un Nouveau Bâtiment</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('batiments.store') }}" method="POST" id="batiment-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="type_batiment" class="form-label">Type de Bâtiment</label>
                                            <select name="type_batiment" id="type_batiment" class="form-select" required>
                                                <option value="">Sélectionner un type</option>
                                                <option value="Maison">Maison</option>
                                                <option value="Usine">Usine</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="adresse" class="form-label">Adresse</label>
                                            <input type="text" name="adresse" id="adresse" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row" id="maison-fields" style="display: none;">
                                        <div class="col-md-6 mb-3">
                                            <label for="nbHabitants" class="form-label">Nombre d'Habitants</label>
                                            <input type="number" name="nbHabitants" id="nbHabitants" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row" id="usine-fields" style="display: none;">
                                        <div class="col-md-6 mb-3">
                                            <label for="nbEmployes" class="form-label">Nombre d'Employés</label>
                                            <input type="number" name="nbEmployes" id="nbEmployes" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="typeIndustrie" class="form-label">Type d'Industrie</label>
                                            <input type="text" name="typeIndustrie" id="typeIndustrie" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="zone_id" class="form-label">Zone Urbaine</label>
                                            <select name="zone_id" id="zone_id" class="form-select">
                                                <option value="">Sélectionner une zone</option>
                                                @foreach($zones as $zone)
                                                    <option value="{{ $zone->id }}">{{ $zone->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <h6>Émissions CO2 (t/an)</h6>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[voiture][check]" value="1" class="form-check-input">
                                                    Voiture
                                                </label>
                                                <input type="number" name="emissions[voiture][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[moto][check]" value="1" class="form-check-input">
                                                    Moto
                                                </label>
                                                <input type="number" name="emissions[moto][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[bus][check]" value="1" class="form-check-input">
                                                    Bus
                                                </label>
                                                <input type="number" name="emissions[bus][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[avion][check]" value="1" class="form-check-input">
                                                    Avion
                                                </label>
                                                <input type="number" name="emissions[avion][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[fumeur][check]" value="1" class="form-check-input">
                                                    Fumeur
                                                </label>
                                                <input type="number" name="emissions[fumeur][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[electricite][check]" value="1" class="form-check-input">
                                                    Électricité
                                                </label>
                                                <input type="number" name="emissions[electricite][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[gaz][check]" value="1" class="form-check-input">
                                                    Gaz
                                                </label>
                                                <input type="number" name="emissions[gaz][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[clim][check]" value="1" class="form-check-input">
                                                    Climatisation
                                                </label>
                                                <input type="number" name="emissions[clim][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[machine][check]" value="1" class="form-check-input">
                                                    Machine
                                                </label>
                                                <input type="number" name="emissions[machine][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[camion][check]" value="1" class="form-check-input">
                                                    Camion
                                                </label>
                                                <input type="number" name="emissions[camion][nb]" placeholder="Nombre" class="form-control form-control-sm mt-1">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success">Ajouter le Bâtiment</button>
                                </form>
                            </div>
                        </div>

                        <!-- Liste des bâtiments -->
                        <div class="card">
                            <div class="card-header" style="background: #1cc88a; color: white;">
                                <h5 class="mb-0">Liste des Bâtiments</h5>
                            </div>
                            <div class="card-body batiments-list">
                                @forelse($batiments as $batiment)
                                    <div class="batiment-item border-bottom pb-3 mb-3" data-id="{{ $batiment->id }}">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-2">{{ $batiment->type_batiment }} - {{ $batiment->adresse }}</h6>
                                                <p class="mb-1"><strong>Émission CO2:</strong> {{ $batiment->emissionCO2 }} t/an</p>
                                                <p class="mb-1"><strong>Émission Réelle:</strong> {{ $batiment->emissionReelle }} t/an</p>
                                                <p class="mb-1"><strong>% Renouvelable:</strong> {{ $batiment->pourcentageRenouvelable }}%</p>
                                                <p class="mb-1"><strong>Arbres Besoin:</strong> {{ $batiment->nbArbresBesoin }}</p>
                                                @if($batiment->zone)
                                                    <p class="mb-0"><strong>Zone:</strong> {{ $batiment->zone->nom }}</p>
                                                @endif
                                                @if($batiment->type_batiment === 'Maison' && $batiment->nbHabitants)
                                                    <p class="mb-0"><strong>Habitants:</strong> {{ $batiment->nbHabitants }}</p>
                                                @elseif($batiment->type_batiment === 'Usine' && $batiment->nbEmployes)
                                                    <p class="mb-0"><strong>Employés:</strong> {{ $batiment->nbEmployes }} | <strong>Industrie:</strong> {{ $batiment->typeIndustrie }}</p>
                                                @endif
                                            </div>
                                            <div class="ms-3">
                                                <button class="btn btn-sm btn-warning me-2 edit-btn" data-id="{{ $batiment->id }}">Modifier</button>
                                                <form action="{{ route('batiments.destroy', $batiment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bâtiment ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-muted">Aucun bâtiment enregistré pour le moment.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>

                <!-- /Bâtiments Section -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeBatiment = document.getElementById('type_batiment');
            const maisonFields = document.getElementById('maison-fields');
            const usineFields = document.getElementById('usine-fields');

            typeBatiment.addEventListener('change', function() {
                if (this.value === 'Maison') {
                    maisonFields.style.display = 'block';
                    usineFields.style.display = 'none';
                } else if (this.value === 'Usine') {
                    maisonFields.style.display = 'none';
                    usineFields.style.display = 'block';
                } else {
                    maisonFields.style.display = 'none';
                    usineFields.style.display = 'none';
                }
            });

            // Recherche des bâtiments
            const searchBatimentInput = document.getElementById('search-batiment');
            if (searchBatimentInput) {
                let batimentTimer;
                searchBatimentInput.addEventListener('input', function() {
                    clearTimeout(batimentTimer);
                    batimentTimer = setTimeout(() => {
                        const query = this.value.trim();
                        fetch(`/client?search_batiment=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                updateBatimentsList(data);
                            })
                            .catch(error => console.error('Erreur lors de la recherche:', error));
                    }, 350);
                });
            }

            function updateBatimentsList(batiments) {
                const container = document.querySelector('.batiments-list');
                if (!container) return;

                if (batiments.length === 0) {
                    container.innerHTML = '<p class="text-center text-muted">Aucun bâtiment trouvé pour cette recherche.</p>';
                    return;
                }

                let html = '';
                batiments.forEach(batiment => {
                    html += `
                        <div class="batiment-item border-bottom pb-3 mb-3" data-id="${batiment.id}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-2">${batiment.type_batiment} - ${batiment.adresse}</h6>
                                    <p class="mb-1"><strong>Émission CO2:</strong> ${batiment.emissionCO2} t/an</p>
                                    <p class="mb-1"><strong>Émission Réelle:</strong> ${batiment.emissionReelle} t/an</p>
                                    <p class="mb-1"><strong>% Renouvelable:</strong> ${batiment.pourcentageRenouvelable}%</p>
                                    <p class="mb-1"><strong>Arbres Besoin:</strong> ${batiment.nbArbresBesoin}</p>
                                    ${batiment.zone ? `<p class="mb-0"><strong>Zone:</strong> ${batiment.zone}</p>` : ''}
                                    ${batiment.type_batiment === 'Maison' && batiment.nbHabitants ? `<p class="mb-0"><strong>Habitants:</strong> ${batiment.nbHabitants}</p>` : ''}
                                    ${batiment.type_batiment === 'Usine' && batiment.nbEmployes ? `<p class="mb-0"><strong>Employés:</strong> ${batiment.nbEmployes} | <strong>Industrie:</strong> ${batiment.typeIndustrie}</p>` : ''}
                                </div>
                                <div class="ms-3">
                                    <button class="btn btn-sm btn-warning me-2 edit-btn" data-id="${batiment.id}">Modifier</button>
                                    <form action="/batiments/${batiment.id}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bâtiment ?')">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').getAttribute('content')}">
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
                });
                container.innerHTML = html;
            }
        });
    </script>
</body>
</html>