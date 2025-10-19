<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name', 'Landify') }} - Espace Vert</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

        /* Grille compacte pour les bâtiments - remplacée par défilement horizontal */
        .batiments-grid {
            overflow-x: auto;
            white-space: nowrap;
            padding: 20px 0;
            display: flex;
            gap: 15px;
        }

        .batiments-grid .batiment-item {
            display: inline-block;
            min-width: 320px;
            width: fit-content;
            max-width: 500px;
            flex-shrink: 0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .batiments-grid .batiment-item:hover {
            transform: translateY(-2px);
        }

        .batiments-grid .card {
            border: 1px solid rgba(0,0,0,0.08);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            min-height: auto;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        .batiments-grid .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: rgba(28, 200, 138, 0.2);
        }

        /* Responsive adjustments pour le défilement horizontal */
        @media (max-width: 576px) {
            .batiments-grid .batiment-item {
                min-width: 280px;
                width: fit-content;
                max-width: 400px;
            }
        }

        /* Pagination styling */
        .pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
}

.pagination .page-item {
    margin: 0 4px;
}

.pagination .page-link {
    color: #008B8B;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 6px 12px;
    font-size: 14px;
    transition: all 0.2s ease;
}

.pagination .page-link:hover {
    background-color: #008B8B;
    color: white;
}

.pagination .page-item.active .page-link {
    background-color: #008B8B;
    color: white;
    border-color: #008B8B;
}

.pagination i {
    font-size: 14px; /* <--- réduit la taille des flèches */
    vertical-align: middle;
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
                                <button class="btn btn-link text-white p-0 w-100 text-start text-decoration-none" data-bs-toggle="collapse" data-bs-target="#batiment-form-collapse" aria-expanded="false" aria-controls="batiment-form-collapse">
                                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2" id="batiment-form-icon"></i>Ajouter un Nouveau Bâtiment</h5>
                                </button>
                            </div>
                            <div class="collapse" id="batiment-form-collapse">
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

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="zone_id" class="form-label">État (Gouvernorat)</label>
                                            <select name="zone_id" id="zone_id" class="form-select" required>
                                                <option value="">Sélectionner un gouvernorat</option>
                                                @foreach($zonesUrbaines as $zone)
                                                    <option value="{{ $zone->id }}">{{ $zone->nom }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="type_zone_urbaine" class="form-label">Zone Urbaine</label>
                                            <select name="type_zone_urbaine" id="type_zone_urbaine" class="form-select">
                                                <option value="">Sélectionner une zone</option>
                                                @foreach($typesZoneUrbaine as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
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

                                    <div class="mb-3">
                                        <h6>Émissions (unités mensuelles)</h6>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[voiture][check]" value="1" class="form-check-input">
                                                    Voiture
                                                </label>
                                                <input type="number" name="emissions[voiture][nb]" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[moto][check]" value="1" class="form-check-input">
                                                    Moto
                                                </label>
                                                <input type="number" name="emissions[moto][nb]" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[bus][check]" value="1" class="form-check-input">
                                                    Bus
                                                </label>
                                                <input type="number" name="emissions[bus][nb]" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[avion][check]" value="1" class="form-check-input">
                                                    Avion
                                                </label>
                                                <input type="number" name="emissions[avion][nb]" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[fumeur][check]" value="1" class="form-check-input">
                                                    Fumeur
                                                </label>
                                                <input type="number" name="emissions[fumeur][nb]" placeholder="paquets/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[electricite][check]" value="1" class="form-check-input">
                                                    Électricité
                                                </label>
                                                <input type="number" name="emissions[electricite][nb]" placeholder="kWh/mois" min="0" step="0.1" class="form-control form-control-sm mt-1">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[gaz][check]" value="1" class="form-check-input">
                                                    Gaz
                                                </label>
                                                <input type="number" name="emissions[gaz][nb]" placeholder="m3/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                            </div>
                                             <div class="col-md-3 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="emissions[camion][check]" value="1" class="form-check-input">
                                                    Camion
                                                </label>
                                                <input type="number" name="emissions[camion][nb]" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                            </div>
                                        </div>
                                       
                                    </div>

                        
                                    </div>

                                    <div class="ms-4">
                                    <div class="mb-3">
                                        <label class="form-check-label">
                                           <h6> <input type="checkbox" name="energies_renouvelables[existe]" value="1" class="form-check-input" id="energies-renouvelables-existe">
                                           Énergies Renouvelables
                                        </label></h6>
                                    </div>
                                    <div id="energies-renouvelables-types" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="energies_renouvelables[panneaux_solaires][check]" value="1" class="form-check-input">
                                                    Panneaux Solaires
                                                </label>
                                                <input type="number" name="energies_renouvelables[panneaux_solaires][nb]" placeholder="Quantité de kW produits" class="form-control form-control-sm mt-1" min="0">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="energies_renouvelables[voitures_electriques][check]" value="1" class="form-check-input">
                                                    Voitures Électriques
                                                </label>
                                                <input type="number" name="energies_renouvelables[voitures_electriques][nb]" placeholder="Kilométrage (km/mois)" class="form-control form-control-sm mt-1" min="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="energies_renouvelables[camions_electriques][check]" value="1" class="form-check-input">
                                                    Camions Électriques
                                                </label>
                                                <input type="number" name="energies_renouvelables[camions_electriques][nb]" placeholder="Kilométrage (km/mois)" class="form-control form-control-sm mt-1" min="0">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="energies_renouvelables[energie_eolienne][check]" value="1" class="form-check-input">
                                                    Énergie Éolienne
                                                </label>
                                                <input type="number" name="energies_renouvelables[energie_eolienne][nb]" placeholder="Puissance (MW)" class="form-control form-control-sm mt-1" min="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="energies_renouvelables[energie_hydroelectrique][check]" value="1" class="form-check-input">
                                                    Énergie Hydroélectrique
                                                </label>
                                                <input type="number" name="energies_renouvelables[energie_hydroelectrique][nb]" placeholder="Production (TWh)" class="form-control form-control-sm mt-1" min="0">
                                            </div>
                                        </div>
                                    </div>
                                    </div>

                                      <div class="mb-3 ms-4">                                      <div class="mb-3">
                                            <label class="form-check-label">
                                               <h6> <input type="checkbox" name="recyclage[existe]" value="1" class="form-check-input" id="recyclage-existe">
                                               Recyclage des produits
                                            </label></h6>
                                        </div>
                                        <div id="recyclage-types" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="produit_recycle" class="form-label">Produits Recyclés</label>
                                                    <select name="recyclage[produit_recycle][]" id="produit_recycle" class="form-select" multiple size="4">
                                                        <option value="papier">Papier/Carton</option>
                                                        <option value="plastique">Plastique</option>
                                                        <option value="verre">Verre</option>
                                                        <option value="metal">Métal</option>
                                                        <option value="organique">Déchets Organiques</option>
                                                        <option value="electronique">Déchets Électroniques</option>
                                                        <option value="textile">Textile</option>
                                                        <option value="bois">Bois</option>
                                                        <option value="batteries">Batteries</option>
                                                        <option value="autre">Autre</option>
                                                    </select>
                                                    <small class="form-text text-muted">Maintenez Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs produits</small>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Quantités Recyclées (kg/mois)</label>
                                                    <div id="quantites-container">
                                                        <!-- Inputs cachés pour tous les produits possibles -->
                                                        <input type="hidden" name="recyclage[quantites][papier]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][plastique]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][verre]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][metal]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][organique]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][electronique]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][textile]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][bois]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][batteries]" value="0">
                                                        <input type="hidden" name="recyclage[quantites][autre]" value="0">
                                                        <small class="form-text text-muted">Sélectionnez d'abord les produits pour voir les champs de quantité</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    <button type="submit" class="btn btn-success ms-4">Ajouter le Bâtiment</button>
                                </form>
                            </div>
                        </div>
                    </div>

                        <!-- Liste des bâtiments -->
                        <div class="card">
                            <div class="card-header" style="background: #1cc88a; color: white;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Liste des Bâtiments</h5>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="d-flex align-items-center">
                                            <label for="filter-type-batiment" class="me-2 mb-0" style="font-size: 0.9rem;">Type:</label>
                                            <select id="filter-type-batiment" class="form-select form-select-sm" style="width: 120px;">
                                                <option value="">Tous</option>
                                                <option value="Maison">Maison</option>
                                                <option value="Usine">Usine</option>
                                            </select>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <label for="search-adresse" class="me-2 mb-0" style="font-size: 0.9rem;">Adresse:</label>
                                            <input type="text" id="search-adresse" class="form-control form-control-sm" placeholder="Tapez une adresse..." style="width: 200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body batiments-list">
                                <div class="batiments-grid">
                                    @forelse($batiments as $batiment)
                                        <div class="batiment-item">
                                            <div class="card h-100" style="font-size: 0.9rem;">
                                                <div class="card-body p-3" data-id="{{ $batiment->id }}">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-2" style="font-size: 1rem;">{{ $batiment->type_zone_urbaine }} - {{ $batiment->type_batiment }}</h6>
                                                            <p class="mb-1 small"><strong>Adresse:</strong> {{ $batiment->adresse}}</p>
                                                            <p class="mb-1 small"><strong>Émission CO2:</strong> {{ $batiment->emissionCO2 }} t/an</p>
                                                            <p class="mb-1 small"><strong>Émission Réelle:</strong> {{ $batiment->emission_reelle }} t/an</p>
                                                            <p class="mb-1 small"><strong>Pourcentage Renouvelable:</strong> {{ $batiment->pourcentage_renouvelable }}%</p>
                                                            <p class="mb-1 small"><strong>Arbres Besoin:</strong> {{ $batiment->nbArbresBesoin }}</p>
                                                            @if($batiment->zone)
                                                                <p class="mb-0 small"><strong>Zone:</strong> {{ $batiment->zone->nom }}</p>
                                                            @endif
                                                            @if($batiment->type_batiment === 'Maison' && $batiment->nbHabitants)
                                                                <p class="mb-0 small"><strong>Habitants:</strong> {{ $batiment->nbHabitants }}</p>
                                                            @elseif($batiment->type_batiment === 'Usine' && $batiment->nbEmployes)
                                                                <p class="mb-0 small"><strong>Employés:</strong> {{ $batiment->nbEmployes }} | <strong>Industrie:</strong> {{ $batiment->type_industrie }}</p>
                                                            @endif
                                                           @if($batiment->recyclageExiste)
                                                                        @php
                                                                            $recyclage = $batiment->recyclage_data ?? [];
                                                                            $produits = $recyclage['produit_recycle'] ?? [];
                                                                            $quantites = $recyclage['quantites'] ?? [];

                                                                            $details = [];
                                                                            foreach ($produits as $produit) {
                                                                                $qte = $quantites[$produit] ?? null;
                                                                                if ($qte && $qte > 0) {
                                                                                    $details[] = ucfirst($produit) . ' (' . $qte . ' kg/mois)';
                                                                                } else {
                                                                                    $details[] = ucfirst($produit);
                                                                                }
                                                                            }
                                                                        @endphp

                                                                        <p class="mb-0 small">
                                                                            <strong>♻️ Recyclage :</strong> {{ count($details) ? implode(', ', $details) : 'Aucun détail disponible' }}
                                                                        </p>
                                                                    @endif
                                                            {{-- 🌱 Énergies Renouvelables --}}
                                                            @if(!empty($batiment->energies_renouvelables_data))
                                                                @php
                                                                    $energies = $batiment->energies_renouvelables_data ?? [];
                                                                    $details = [];

                                                                    $labels = [
                                                                        'panneaux_solaires' => ['label' => 'Panneaux Solaires', 'unite' => 'kW'],
                                                                        'voitures_electriques' => ['label' => 'Voitures Électriques', 'unite' => 'km/mois'],
                                                                        'camions_electriques' => ['label' => 'Camions Électriques', 'unite' => 'km/mois'],
                                                                        'energie_eolienne' => ['label' => 'Énergie Éolienne', 'unite' => 'MW'],
                                                                        'energie_hydroelectrique' => ['label' => 'Énergie Hydroélectrique', 'unite' => 'TWh'],
                                                                    ];

                                                                    foreach ($labels as $key => $info) {
                                                                        if (!empty($energies[$key]['check']) && isset($energies[$key]['nb'])) {
                                                                            $nb = $energies[$key]['nb'];
                                                                            $details[] = $info['label'] . ' (' . $nb . ' ' . $info['unite'] . ')';
                                                                        }
                                                                    }
                                                                @endphp

                                                                <p class="mb-0 small">
                                                                    <strong>🌱 Énergies Renouvelables :</strong>
                                                                    {{ count($details) ? implode(', ', $details) : 'Aucune donnée disponible' }}
                                                                </p>
                    @endif


                                                        </div>
                                                        <div class="ms-2 d-flex align-items-center">
                                                            @if($batiment->user_id === auth()->id())
                                                            <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="{{ $batiment->id }}" style="font-size: 0.8rem; padding: 0.25rem 0.5rem;" title="Modifier">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <form action="{{ route('batiments.destroy', $batiment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bâtiment ?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" style="font-size: 0.8rem; padding: 0.25rem 0.5rem;" title="Supprimer">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="batiment-item">
                                            <div class="card h-100">
                                                <div class="card-body p-3 text-center">
                                                    <p class="text-muted mb-0">Aucun bâtiment enregistré pour le moment.</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Modal de modification -->
                        <div class="modal fade" id="editBatimentModal" tabindex="-1" aria-labelledby="editBatimentModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: #1cc88a; color: white;">
                                        <h5 class="modal-title" id="editBatimentModalLabel">Modifier le Bâtiment</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="edit-batiment-form" method="POST">
                                            @csrf
                                            <input type="hidden" id="edit-batiment-id" name="id">

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="edit-type_batiment" class="form-label">Type de Bâtiment</label>
                                                    <select name="type_batiment" id="edit-type_batiment" class="form-select" required>
                                                        <option value="">Sélectionner un type</option>
                                                        <option value="Maison">Maison</option>
                                                        <option value="Usine">Usine</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="edit-adresse" class="form-label">Adresse</label>
                                                    <input type="text" name="adresse" id="edit-adresse" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="edit-zone_id" class="form-label">État (Gouvernorat)</label>
                                                    <select name="zone_id" id="edit-zone_id" class="form-select" required>
                                                        <option value="">Sélectionner un gouvernorat</option>
                                                        @foreach($zonesUrbaines as $zone)
                                                            <option value="{{ $zone->id }}">{{ $zone->nom }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="edit-type_zone_urbaine" class="form-label">Zone Urbaine</label>
                                                    <select name="type_zone_urbaine" id="edit-type_zone_urbaine" class="form-select">
                                                        <option value="">Sélectionner une zone</option>
                                                        @foreach($typesZoneUrbaine as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row" id="edit-maison-fields" style="display: none;">
                                                <div class="col-md-6 mb-3">
                                                    <label for="edit-nbHabitants" class="form-label">Nombre d'Habitants</label>
                                                    <input type="number" name="nbHabitants" id="edit-nbHabitants" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row" id="edit-usine-fields" style="display: none;">
                                                <div class="col-md-6 mb-3">
                                                    <label for="edit-nbEmployes" class="form-label">Nombre d'Employés</label>
                                                    <input type="number" name="nbEmployes" id="edit-nbEmployes" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="edit-typeIndustrie" class="form-label">Type d'Industrie</label>
                                                    <input type="text" name="typeIndustrie" id="edit-typeIndustrie" class="form-control">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <h6>Émissions (unités mensuelles)</h6>
                                                <div class="row">
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="emissions[voiture][check]" value="1" class="form-check-input" id="edit-emissions-voiture-check">
                                                            Voiture
                                                        </label>
                                                        <input type="number" name="emissions[voiture][nb]" id="edit-emissions-voiture-nb" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="emissions[moto][check]" value="1" class="form-check-input" id="edit-emissions-moto-check">
                                                            Moto
                                                        </label>
                                                        <input type="number" name="emissions[moto][nb]" id="edit-emissions-moto-nb" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="emissions[bus][check]" value="1" class="form-check-input" id="edit-emissions-bus-check">
                                                            Bus
                                                        </label>
                                                        <input type="number" name="emissions[bus][nb]" id="edit-emissions-bus-nb" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="emissions[avion][check]" value="1" class="form-check-input" id="edit-emissions-avion-check">
                                                            Avion
                                                        </label>
                                                        <input type="number" name="emissions[avion][nb]" id="edit-emissions-avion-nb" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="emissions[fumeur][check]" value="1" class="form-check-input" id="edit-emissions-fumeur-check">
                                                            Fumeur
                                                        </label>
                                                        <input type="number" name="emissions[fumeur][nb]" id="edit-emissions-fumeur-nb" placeholder="paquets/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="emissions[electricite][check]" value="1" class="form-check-input" id="edit-emissions-electricite-check">
                                                            Électricité
                                                        </label>
                                                        <input type="number" name="emissions[electricite][nb]" id="edit-emissions-electricite-nb" placeholder="kWh/mois" min="0" step="0.1" class="form-control form-control-sm mt-1">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="emissions[gaz][check]" value="1" class="form-check-input" id="edit-emissions-gaz-check">
                                                            Gaz
                                                        </label>
                                                        <input type="number" name="emissions[gaz][nb]" id="edit-emissions-gaz-nb" placeholder="m3/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                                    </div>
                                                    <div class="col-md-3 mb-2">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="emissions[camion][check]" value="1" class="form-check-input" id="edit-emissions-camion-check">
                                                            Camion
                                                        </label>
                                                        <input type="number" name="emissions[camion][nb]" id="edit-emissions-camion-nb" placeholder="km/mois" min="0" step="1" class="form-control form-control-sm mt-1">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="ms-4">
                                                <div class="mb-3">
                                                    <label class="form-check-label">
                                                        <h6><input type="checkbox" name="energies_renouvelables[existe]" value="1" class="form-check-input" id="edit-energies-renouvelables-existe">
                                                        Énergies Renouvelables</h6>
                                                    </label>
                                                </div>
                                                <div id="edit-energies-renouvelables-types" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="energies_renouvelables[panneaux_solaires][check]" value="1" class="form-check-input" id="edit-panneaux-solaires-check">
                                                                Panneaux Solaires
                                                            </label>
                                                            <input type="number" name="energies_renouvelables[panneaux_solaires][nb]" id="edit-panneaux-solaires-nb" placeholder="Quantité de kW produits" class="form-control form-control-sm mt-1" min="0">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="energies_renouvelables[voitures_electriques][check]" value="1" class="form-check-input" id="edit-voitures-electriques-check">
                                                                Voitures Électriques
                                                            </label>
                                                            <input type="number" name="energies_renouvelables[voitures_electriques][nb]" id="edit-voitures-electriques-nb" placeholder="Kilométrage (km/mois)" class="form-control form-control-sm mt-1" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="energies_renouvelables[camions_electriques][check]" value="1" class="form-check-input" id="edit-camions-electriques-check">
                                                                Camions Électriques
                                                            </label>
                                                            <input type="number" name="energies_renouvelables[camions_electriques][nb]" id="edit-camions-electriques-nb" placeholder="Kilométrage (km/mois)" class="form-control form-control-sm mt-1" min="0">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="energies_renouvelables[energie_eolienne][check]" value="1" class="form-check-input" id="edit-energie-eolienne-check">
                                                                Énergie Éolienne
                                                            </label>
                                                            <input type="number" name="energies_renouvelables[energie_eolienne][nb]" id="edit-energie-eolienne-nb" placeholder="Puissance (MW)" class="form-control form-control-sm mt-1" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" name="energies_renouvelables[energie_hydroelectrique][check]" value="1" class="form-check-input" id="edit-energie-hydroelectrique-check">
                                                                Énergie Hydroélectrique
                                                            </label>
                                                            <input type="number" name="energies_renouvelables[energie_hydroelectrique][nb]" id="edit-energie-hydroelectrique-nb" placeholder="Production (TWh)" class="form-control form-control-sm mt-1" min="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 ms-4">
                                                <div class="mb-3">
                                                    <label class="form-check-label">
                                                        <h6><input type="checkbox" name="recyclage[existe]" value="1" class="form-check-input" id="edit-recyclage-existe">
                                                        Recyclage des produits</h6>
                                                    </label>
                                                </div>
                                                <div id="edit-recyclage-types" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="edit-produit_recycle" class="form-label">Produits Recyclés</label>
                                                            <select name="recyclage[produit_recycle][]" id="edit-produit_recycle" class="form-select" multiple size="4">
                                                                <option value="papier">Papier/Carton</option>
                                                                <option value="plastique">Plastique</option>
                                                                <option value="verre">Verre</option>
                                                                <option value="metal">Métal</option>
                                                                <option value="organique">Déchets Organiques</option>
                                                                <option value="electronique">Déchets Électroniques</option>
                                                                <option value="textile">Textile</option>
                                                                <option value="bois">Bois</option>
                                                                <option value="batteries">Batteries</option>
                                                                <option value="autre">Autre</option>
                                                            </select>
                                                            <small class="form-text text-muted">Maintenez Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs produits</small>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Quantités Recyclées (kg/mois)</label>
                                                            <div id="edit-quantites-container">
                                                                <input type="hidden" name="recyclage[quantites][papier]" value="0" id="edit-quantites-papier">
                                                                <input type="hidden" name="recyclage[quantites][plastique]" value="0" id="edit-quantites-plastique">
                                                                <input type="hidden" name="recyclage[quantites][verre]" value="0" id="edit-quantites-verre">
                                                                <input type="hidden" name="recyclage[quantites][metal]" value="0" id="edit-quantites-metal">
                                                                <input type="hidden" name="recyclage[quantites][organique]" value="0" id="edit-quantites-organique">
                                                                <input type="hidden" name="recyclage[quantites][electronique]" value="0" id="edit-quantites-electronique">
                                                                <input type="hidden" name="recyclage[quantites][textile]" value="0" id="edit-quantites-textile">
                                                                <input type="hidden" name="recyclage[quantites][bois]" value="0" id="edit-quantites-bois">
                                                                <input type="hidden" name="recyclage[quantites][batteries]" value="0" id="edit-quantites-batteries">
                                                                <input type="hidden" name="recyclage[quantites][autre]" value="0" id="edit-quantites-autre">
                                                                <small class="form-text text-muted">Sélectionnez d'abord les produits pour voir les champs de quantité</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" form="edit-batiment-form" class="btn btn-success">Modifier le Bâtiment</button>
                                    </div>
                                </div>
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

            // Gestion du bouton collapse du formulaire
            const batimentFormCollapse = document.getElementById('batiment-form-collapse');
            const batimentFormIcon = document.getElementById('batiment-form-icon');

            if (batimentFormCollapse && batimentFormIcon) {
                batimentFormCollapse.addEventListener('show.bs.collapse', function () {
                    batimentFormIcon.className = 'bi bi-dash-circle me-2';
                });

                batimentFormCollapse.addEventListener('hide.bs.collapse', function () {
                    batimentFormIcon.className = 'bi bi-plus-circle me-2';
                });
            }

            // Gestion des filtres
            const searchAdresse = document.getElementById('search-adresse');
            const filterTypeBatiment = document.getElementById('filter-type-batiment');
            const batimentsCards = document.querySelectorAll('.batiments-list .card');

            function filterBatiments() {
                const searchTerm = searchAdresse ? searchAdresse.value.toLowerCase().trim() : '';
                const typeFilter = filterTypeBatiment ? filterTypeBatiment.value : '';

                // Faire une requête AJAX pour rechercher côté serveur
                const url = new URL(window.location.href);
                if (searchTerm) {
                    url.searchParams.set('search_batiment', searchTerm);
                } else {
                    url.searchParams.delete('search_batiment');
                }
                if (typeFilter) {
                    url.searchParams.set('filter_type', typeFilter);
                } else {
                    url.searchParams.delete('filter_type');
                }

                fetch(url.toString(), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Mettre à jour la liste des bâtiments avec les résultats filtrés
                    updateBatimentsList(data.batiments);
                })
                .catch(error => console.error('Erreur lors de la recherche:', error));
            }

            if (searchAdresse) {
                searchAdresse.addEventListener('input', filterBatiments);
            }

            if (filterTypeBatiment) {
                filterTypeBatiment.addEventListener('change', filterBatiments);
            }

            // Gestion du recyclage
            const recyclageExiste = document.getElementById('recyclage-existe');
            const recyclageTypes = document.getElementById('recyclage-types');
            const produitRecycle = document.getElementById('produit_recycle');
            const quantitesContainer = document.getElementById('quantites-container');

            const typeNames = {
                papier: 'Papier/Carton',
                plastique: 'Plastique',
                verre: 'Verre',
                metal: 'Métal',
                organique: 'Déchets Organiques',
                electronique: 'Déchets Électroniques',
                textile: 'Textile',
                bois: 'Bois',
                batteries: 'Batteries',
                autre: 'Autre'
            };

            function updateQuantitesInputs() {
                const selectedOptions = Array.from(produitRecycle.selectedOptions);
                const quantiteInputs = quantitesContainer.querySelectorAll('input[type="number"]');
                const hiddenInputs = quantitesContainer.querySelectorAll('input[type="hidden"]');

                // Cacher tous les inputs visibles
                quantiteInputs.forEach(input => {
                    input.style.display = 'none';
                });

                // Montrer seulement les inputs pour les produits sélectionnés
                selectedOptions.forEach(option => {
                    const produitValue = option.value;
                    const input = quantitesContainer.querySelector(`input[name="recyclage[quantites][${produitValue}]"]`);
                    if (input) {
                        input.type = 'number';
                        input.style.display = 'block';
                        input.placeholder = 'Quantité en kg/mois';
                        input.className = 'form-control form-control-sm';
                        input.min = '0';
                        input.step = '0.1';

                        // Créer le label si nécessaire
                        let label = input.previousElementSibling;
                        if (!label || label.tagName !== 'LABEL') {
                            label = document.createElement('label');
                            label.className = 'form-label';
                            label.textContent = typeNames[produitValue] || produitValue;
                            input.parentNode.insertBefore(label, input);
                        }
                    }
                });

                // Si aucun produit sélectionné, montrer le message
                if (selectedOptions.length === 0) {
                    const message = quantitesContainer.querySelector('small');
                    if (message) message.style.display = 'block';
                } else {
                    const message = quantitesContainer.querySelector('small');
                    if (message) message.style.display = 'none';
                }
            }

            if (recyclageExiste && recyclageTypes) {
                recyclageExiste.addEventListener('change', function() {
                    if (this.checked) {
                        recyclageTypes.style.display = 'block';
                        updateQuantitesInputs();
                    } else {
                        recyclageTypes.style.display = 'none';
                        // Réinitialiser les champs de recyclage
                        Array.from(produitRecycle.options).forEach(option => option.selected = false);
                        // Cacher tous les inputs de quantité et remettre à 0
                        const allQuantiteInputs = quantitesContainer.querySelectorAll('input[name^="recyclage[quantites]"]');
                        allQuantiteInputs.forEach(input => {
                            input.value = '0';
                            if (input.type === 'number') {
                                input.style.display = 'none';
                            }
                        });
                        const message = quantitesContainer.querySelector('small');
                        if (message) message.style.display = 'block';
                    }
                });

                // Mettre à jour les inputs de quantité quand la sélection change
                produitRecycle.addEventListener('change', updateQuantitesInputs);
            }

            // Gestion des énergies renouvelables
            const energiesRenouvelablesExiste = document.getElementById('energies-renouvelables-existe');
            const energiesRenouvelablesTypes = document.getElementById('energies-renouvelables-types');

            if (energiesRenouvelablesExiste && energiesRenouvelablesTypes) {
                energiesRenouvelablesExiste.addEventListener('change', function() {
                    if (this.checked) {
                        energiesRenouvelablesTypes.style.display = 'block';
                    } else {
                        energiesRenouvelablesTypes.style.display = 'none';
                        // Réinitialiser les champs d'énergies renouvelables
                        const energieCheckboxes = energiesRenouvelablesTypes.querySelectorAll('input[type="checkbox"]');
                        const energieInputs = energiesRenouvelablesTypes.querySelectorAll('input[type="number"]');
                        energieCheckboxes.forEach(checkbox => checkbox.checked = false);
                        energieInputs.forEach(input => input.value = '');
                    }
                });
            }

            // Gestion du modal de modification
            function openEditModal(batimentId) {
                // Récupérer les données du bâtiment via AJAX
                fetch(`/client/batiment/${batimentId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const batiment = data.batiment;

                    // Debug: afficher les données récupérées
                    console.log('Batiment data:', batiment);

                    // Remplir les champs de base
                    document.getElementById('edit-batiment-id').value = batiment.id;
                    document.getElementById('edit-type_batiment').value = batiment.type_batiment;
                    document.getElementById('edit-adresse').value = batiment.adresse;
                    document.getElementById('edit-zone_id').value = batiment.zone_id;
                    document.getElementById('edit-type_zone_urbaine').value = batiment.type_zone_urbaine;

                    // Gérer les champs spécifiques au type de bâtiment
                    const editMaisonFields = document.getElementById('edit-maison-fields');
                    const editUsineFields = document.getElementById('edit-usine-fields');

                    if (batiment.type_batiment === 'Maison') {
                        editMaisonFields.style.display = 'block';
                        editUsineFields.style.display = 'none';
                        document.getElementById('edit-nbHabitants').value = batiment.nbHabitants || '';
                    } else if (batiment.type_batiment === 'Usine') {
                        editMaisonFields.style.display = 'none';
                        editUsineFields.style.display = 'block';
                        document.getElementById('edit-nbEmployes').value = batiment.nbEmployes || '';
                        document.getElementById('edit-typeIndustrie').value = batiment.typeIndustrie || '';
                    } else {
                        editMaisonFields.style.display = 'none';
                        editUsineFields.style.display = 'none';
                    }

                    // Remplir les émissions
                    const emissions = batiment.emissions_data || {};
                    const emissionTypes = ['voiture', 'moto', 'bus', 'avion', 'fumeur', 'electricite', 'gaz', 'camion'];

                    emissionTypes.forEach(type => {
                        const checkElement = document.getElementById(`edit-emissions-${type}-check`);
                        const nbElement = document.getElementById(`edit-emissions-${type}-nb`);

                        if (emissions[type]) {
                            checkElement.checked = emissions[type].check == 1;
                            nbElement.value = emissions[type].nb || '';
                        } else {
                            checkElement.checked = false;
                            nbElement.value = '';
                        }
                    });

                    // Remplir les énergies renouvelables
                    const energies = batiment.energies_renouvelables_data || {};
                    const energiesExiste = document.getElementById('edit-energies-renouvelables-existe');
                    const energiesTypes = document.getElementById('edit-energies-renouvelables-types');

                    const hasEnergies = Object.keys(energies).length > 0;
                    energiesExiste.checked = hasEnergies;
                    energiesTypes.style.display = hasEnergies ? 'block' : 'none';

                    const energyTypes = ['panneaux_solaires', 'voitures_electriques', 'camions_electriques', 'energie_eolienne', 'energie_hydroelectrique'];
                    energyTypes.forEach(type => {
                        const checkElement = document.getElementById(`edit-${type.replace('_', '-')}-check`);
                        const nbElement = document.getElementById(`edit-${type.replace('_', '-')}-nb`);

                        if (energies[type]) {
                            checkElement.checked = energies[type].check == 1;
                            nbElement.value = energies[type].nb || '';
                        } else {
                            checkElement.checked = false;
                            nbElement.value = '';
                        }
                    });

                    // Remplir le recyclage
                    const recyclage = batiment.recyclage_data || {};
                    const recyclageExiste = document.getElementById('edit-recyclage-existe');
                    const recyclageTypes = document.getElementById('edit-recyclage-types');
                    const produitRecycle = document.getElementById('edit-produit_recycle');

                    const hasRecyclage = recyclage.existe == 1;
                    recyclageExiste.checked = hasRecyclage;
                    recyclageTypes.style.display = hasRecyclage ? 'block' : 'none';

                    if (hasRecyclage && recyclage.produit_recycle) {
                        // Sélectionner les produits recyclés
                        Array.from(produitRecycle.options).forEach(option => {
                            option.selected = recyclage.produit_recycle.includes(option.value);
                        });

                        // Mettre à jour les quantités
                        updateEditQuantitesInputs();

                        // Remplir les quantités
                        if (recyclage.quantites) {
                            Object.keys(recyclage.quantites).forEach(produit => {
                                const input = document.getElementById(`edit-quantites-${produit}`);
                                if (input) {
                                    input.value = recyclage.quantites[produit] || 0;
                                }
                            });
                        }
                    }

                    // Ouvrir le modal
                    const modal = new bootstrap.Modal(document.getElementById('editBatimentModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des données du bâtiment:', error);
                    alert('Erreur lors du chargement des données du bâtiment');
                });
            }

            // Gestion des événements des boutons modifier
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-btn')) {
                    e.preventDefault();
                    const batimentId = e.target.getAttribute('data-id');
                    if (batimentId) {
                        openEditModal(batimentId);
                    }
                }
            });

            // Gestion du formulaire de modification
            document.getElementById('edit-batiment-form').addEventListener('submit', function(e) {
                e.preventDefault();

                // Validation côté client
                const typeBatiment = document.getElementById('edit-type_batiment').value;
                if (!typeBatiment) {
                    alert('Veuillez sélectionner un type de bâtiment');
                    return;
                }

                const formData = new FormData(this);
                const batimentId = document.getElementById('edit-batiment-id').value;

                // Debug: afficher les données du formulaire
                console.log('FormData contents:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                fetch(`/batiments/${batimentId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        // Si la réponse n'est pas ok, essayer de parser l'erreur
                        return response.text().then(text => {
                            try {
                                const errorData = JSON.parse(text);
                                throw new Error(errorData.message || 'Erreur lors de la modification');
                            } catch (e) {
                                throw new Error(text || 'Erreur lors de la modification');
                            }
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Fermer le modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editBatimentModal'));
                        modal.hide();

                        // Recharger la page pour afficher les modifications
                        location.reload();
                    } else {
                        alert('Erreur lors de la modification: ' + (data.message || 'Erreur inconnue'));
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la modification:', error);
                    alert('Erreur lors de la modification du bâtiment: ' + error.message);
                });
            });

            // Fonctions pour gérer les champs du modal de modification
            function updateEditQuantitesInputs() {
                const produitRecycle = document.getElementById('edit-produit_recycle');
                const quantitesContainer = document.getElementById('edit-quantites-container');
                const selectedOptions = Array.from(produitRecycle.selectedOptions);

                // Montrer seulement les inputs pour les produits sélectionnés
                selectedOptions.forEach(option => {
                    const produitValue = option.value;
                    const input = document.getElementById(`edit-quantites-${produitValue}`);
                    if (input) {
                        input.type = 'number';
                        input.style.display = 'block';
                        input.placeholder = 'Quantité en kg/mois';
                        input.className = 'form-control form-control-sm';
                        input.min = '0';
                        input.step = '0.1';
                    }
                });

                // Cacher les inputs non sélectionnés
                const allInputs = quantitesContainer.querySelectorAll('input[type="number"]');
                allInputs.forEach(input => {
                    const produitValue = input.id.replace('edit-quantites-', '');
                    const isSelected = selectedOptions.some(option => option.value === produitValue);
                    if (!isSelected) {
                        input.style.display = 'none';
                    }
                });
            }

            // Gestion du recyclage dans le modal de modification
            const editRecyclageExiste = document.getElementById('edit-recyclage-existe');
            const editRecyclageTypes = document.getElementById('edit-recyclage-types');
            const editProduitRecycle = document.getElementById('edit-produit_recycle');

            if (editRecyclageExiste && editRecyclageTypes) {
                editRecyclageExiste.addEventListener('change', function() {
                    if (this.checked) {
                        editRecyclageTypes.style.display = 'block';
                        updateEditQuantitesInputs();
                    } else {
                        editRecyclageTypes.style.display = 'none';
                    }
                });

                editProduitRecycle.addEventListener('change', updateEditQuantitesInputs);
            }

            // Gestion des énergies renouvelables dans le modal de modification
            const editEnergiesRenouvelablesExiste = document.getElementById('edit-energies-renouvelables-existe');
            const editEnergiesRenouvelablesTypes = document.getElementById('edit-energies-renouvelables-types');

            if (editEnergiesRenouvelablesExiste && editEnergiesRenouvelablesTypes) {
                editEnergiesRenouvelablesExiste.addEventListener('change', function() {
                    if (this.checked) {
                        editEnergiesRenouvelablesTypes.style.display = 'block';
                    } else {
                        editEnergiesRenouvelablesTypes.style.display = 'none';
                        // Réinitialiser les champs
                        const energieCheckboxes = editEnergiesRenouvelablesTypes.querySelectorAll('input[type="checkbox"]');
                        const energieInputs = editEnergiesRenouvelablesTypes.querySelectorAll('input[type="number"]');
                        energieCheckboxes.forEach(checkbox => checkbox.checked = false);
                        energieInputs.forEach(input => input.value = '');
                    }
                });
            }

            // Gestion du type de bâtiment dans le modal de modification
            const editTypeBatiment = document.getElementById('edit-type_batiment');
            const editMaisonFields = document.getElementById('edit-maison-fields');
            const editUsineFields = document.getElementById('edit-usine-fields');

            if (editTypeBatiment) {
                editTypeBatiment.addEventListener('change', function() {
                    if (this.value === 'Maison') {
                        editMaisonFields.style.display = 'block';
                        editUsineFields.style.display = 'none';
                    } else if (this.value === 'Usine') {
                        editMaisonFields.style.display = 'none';
                        editUsineFields.style.display = 'block';
                    } else {
                        editMaisonFields.style.display = 'none';
                        editUsineFields.style.display = 'none';
                    }
                });
            }

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
                                updateBatimentsList(data.batiments);
                            })
                            .catch(error => console.error('Erreur lors de la recherche:', error));
                    }, 350);
                });
            }

            function updateBatimentsList(batiments) {
                const container = document.querySelector('.batiments-list');
                if (!container) return;

                if (batiments.length === 0) {
                    container.innerHTML = '<div class="batiments-grid"><div class="batiment-item"><div class="card h-100"><div class="card-body p-3 text-center text-muted">Aucun bâtiment trouvé pour cette recherche.</div></div></div></div>';
                    return;
                }

                let html = '<div class="batiments-grid">';
                batiments.forEach(batiment => {
                    html += `
                        <div class="batiment-item">
                            <div class="card h-100" style="font-size: 0.9rem;">
                                <div class="card-body p-3" data-id="${batiment.id}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-2" style="font-size: 1rem;">${batiment.type_batiment} - ${batiment.adresse}</h6>
                                            <p class="mb-1 small"><strong>Émission CO2:</strong> ${batiment.emissionCO2} t/an</p>
                                            <p class="mb-1 small"><strong>Émission Réelle:</strong> ${batiment.emissionReelle} t/an</p>
                                            <p class="mb-1 small"><strong>% Renouvelable:</strong> ${batiment.pourcentageRenouvelable}%</p>
                                            <p class="mb-1 small"><strong>Arbres Besoin:</strong> ${batiment.nbArbresBesoin}</p>
                                            ${batiment.zone ? `<p class="mb-0 small"><strong>Zone:</strong> ${batiment.zone}</p>` : ''}
                                            ${batiment.type_batiment === 'Maison' && batiment.nbHabitants ? `<p class="mb-0 small"><strong>Habitants:</strong> ${batiment.nbHabitants}</p>` : ''}
                                            ${batiment.type_batiment === 'Usine' && batiment.nbEmployes ? `<p class="mb-0 small"><strong>Employés:</strong> ${batiment.nbEmployes} | <strong>Industrie:</strong> ${batiment.typeIndustrie}</p>` : ''}
                                            ${batiment.recyclageExiste ? `<p class="mb-0 small"><strong>♻️ Recyclage:</strong> ${(() => {
                                                const typeNames = {
                                                    papier: 'Papier/Carton',
                                                    plastique: 'Plastique',
                                                    verre: 'Verre',
                                                    metal: 'Métal',
                                                    organique: 'Déchets Organiques',
                                                    electronique: 'Déchets Électroniques',
                                                    textile: 'Textile',
                                                    bois: 'Bois',
                                                    batteries: 'Batteries',
                                                    autre: 'Autre'
                                                };
                                                const produits = batiment.recyclageData.produit_recycle || [];
                                                const quantites = batiment.recyclageData.quantites || {};
                                                let produitDetails = [];
                                                if (Array.isArray(produits) && produits.length > 0) {
                                                    produits.forEach(produit => {
                                                        const produitLabel = typeNames[produit] || produit;
                                                        const quantite = quantites[produit] ? parseFloat(quantites[produit]) : 0;
                                                        if (quantite > 0) {
                                                            produitDetails.push(produitLabel + ' (' + quantite + ' kg/mois)');
                                                        } else {
                                                            produitDetails.push(produitLabel);
                                                        }
                                                    });
                                                }
                                                return produitDetails.join(', ');
                                            })()}</p>` : ''}
                                            ${batiment.energiesRenouvelablesExiste ? `<p class="mb-0 small"><strong>🌱 Énergies Renouvelables:</strong> ${(() => {
                                                const energiesData = batiment.energiesRenouvelablesData || {};
                                                let energiesDetails = [];
                                                
                                                if (energiesData.panneaux_solaires && energiesData.panneaux_solaires.check && energiesData.panneaux_solaires.nb) {
                                                    energiesDetails.push('Panneaux Solaires (' + energiesData.panneaux_solaires.nb + ' kW)');
                                                }
                                                if (energiesData.voitures_electriques && energiesData.voitures_electriques.check && energiesData.voitures_electriques.nb) {
                                                    energiesDetails.push('Voitures Électriques (' + energiesData.voitures_electriques.nb + ' km/mois)');
                                                }
                                                if (energiesData.camions_electriques && energiesData.camions_electriques.check && energiesData.camions_electriques.nb) {
                                                    energiesDetails.push('Camions Électriques (' + energiesData.camions_electriques.nb + ' km/mois)');
                                                }
                                                if (energiesData.energie_eolienne && energiesData.energie_eolienne.check && energiesData.energie_eolienne.nb) {
                                                    energiesDetails.push('Énergie Éolienne (' + energiesData.energie_eolienne.nb + ' MW)');
                                                }
                                                if (energiesData.energie_hydroelectrique && energiesData.energie_hydroelectrique.check && energiesData.energie_hydroelectrique.nb) {
                                                    energiesDetails.push('Énergie Hydroélectrique (' + energiesData.energie_hydroelectrique.nb + ' TWh)');
                                                }
                                                
                                                return energiesDetails.join(', ');
                                            })()}</p>` : ''}
                                        </div>
                                        <div class="ms-2 d-flex align-items-center">
                                            <button class="btn btn-sm btn-warning me-1 edit-btn" data-id="${batiment.id}" style="font-size: 0.8rem; padding: 0.25rem 0.5rem;" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="/batiments/${batiment.id}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bâtiment ?')">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').getAttribute('content')}">
                                                <button type="submit" class="btn btn-sm btn-danger" style="font-size: 0.8rem; padding: 0.25rem 0.5rem;" title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                container.innerHTML = html;
            }
        });
    </script>
</body>
</html>