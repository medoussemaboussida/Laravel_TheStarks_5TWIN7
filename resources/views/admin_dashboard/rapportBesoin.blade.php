<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>UrbanGreen - Rapports Besoins</title>
    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    @vite(['resources/vendor/fontawesome-free/css/all.min.css', 'resources/css/sb-admin-2.min.css'])
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('admin_dashboard.partials.sidebar')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('admin_dashboard.partials.topbar')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Notifications -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Add Button -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Gestion des rapports besoins</h1>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addRapportBesoinModal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter Rapport Besoin
                        </button>
                    </div>

                    <!-- Search Bar -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Rechercher</h6>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" id="searchInput" class="form-control bg-light border-0 small" placeholder="Rechercher par description ou date..." data-sort="{{ request('sort', 'newest') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table of Rapport Besoins -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des rapports besoins</h6>
                            <form method="GET" action="{{ route('rapport-besoins.index') }}" style="display:inline;">
                                <select class="btn btn-sm btn-primary" name="sort" onchange="this.form.submit()">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récent</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus ancien</option>
                                    <option value="date_rapport_asc" {{ request('sort') == 'date_rapport_asc' ? 'selected' : '' }}>Date Asc</option>
                                    <option value="date_rapport_desc" {{ request('sort') == 'date_rapport_desc' ? 'selected' : '' }}>Date Desc</option>
                                    <option value="priorite_asc" {{ request('sort') == 'priorite_asc' ? 'selected' : '' }}>Priorité Asc</option>
                                    <option value="priorite_desc" {{ request('sort') == 'priorite_desc' ? 'selected' : '' }}>Priorité Desc</option>
                                </select>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date Rapport</th>
                                            <th>Description</th>
                                            <th>Priorité</th>
                                            <th>Coût Estimé</th>
                                            <th>Statut</th>
                                            <th>Espace Vert</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @forelse($rapportBesoins as $rapportBesoin)
                                            <tr>
                                                <td>{{ $rapportBesoin->date_rapport }}</td>
                                                <td>{{ Str::limit($rapportBesoin->description, 50) }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $rapportBesoin->priorite == 'élevée' ? 'danger' : ($rapportBesoin->priorite == 'moyenne' ? 'warning' : 'success') }}">
                                                        {{ ucfirst($rapportBesoin->priorite) }}
                                                    </span>
                                                </td>
                                                <td>{{ number_format($rapportBesoin->cout_estime, 2) }} €</td>
                                                <td>
                                                    <span class="badge badge-{{ $rapportBesoin->statut == 'réalisé' ? 'success' : ($rapportBesoin->statut == 'en cours' ? 'warning' : 'secondary') }}">
                                                        {{ ucfirst($rapportBesoin->statut) }}
                                                    </span>
                                                </td>
                                                <td>{{ $rapportBesoin->espaceVert->nom ?? 'N/A' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#editModal-{{ $rapportBesoin->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $rapportBesoin->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editModal-{{ $rapportBesoin->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-{{ $rapportBesoin->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel-{{ $rapportBesoin->id }}">Modifier Rapport Besoin</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('rapport-besoins.update', $rapportBesoin->id) }}" method="POST" id="editForm-{{ $rapportBesoin->id }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-group">
                                                                            <label for="date_rapport-{{ $rapportBesoin->id }}">Date Rapport</label>
                                                                            <input type="date" class="form-control @error('date_rapport') is-invalid @enderror" id="date_rapport-{{ $rapportBesoin->id }}" name="date_rapport" value="{{ old('date_rapport', $rapportBesoin->date_rapport) }}" required>
                                                                            @error('date_rapport')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="description-{{ $rapportBesoin->id }}">Description</label>
                                                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description-{{ $rapportBesoin->id }}" name="description" rows="3" required>{{ old('description', $rapportBesoin->description) }}</textarea>
                                                                            @error('description')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="priorite-{{ $rapportBesoin->id }}">Priorité</label>
                                                                            <select class="form-control @error('priorite') is-invalid @enderror" id="priorite-{{ $rapportBesoin->id }}" name="priorite" required>
                                                                                <option value="faible" {{ old('priorite', $rapportBesoin->priorite) == 'faible' ? 'selected' : '' }}>Faible</option>
                                                                                <option value="moyenne" {{ old('priorite', $rapportBesoin->priorite) == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                                                                <option value="élevée" {{ old('priorite', $rapportBesoin->priorite) == 'élevée' ? 'selected' : '' }}>Élevée</option>
                                                                            </select>
                                                                            @error('priorite')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="cout_estime-{{ $rapportBesoin->id }}">Coût Estimé (DT)</label>
                                                                            <input type="number" step="0.01" class="form-control @error('cout_estime') is-invalid @enderror" id="cout_estime-{{ $rapportBesoin->id }}" name="cout_estime" value="{{ old('cout_estime', $rapportBesoin->cout_estime) }}" required min="0">
                                                                            @error('cout_estime')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="statut-{{ $rapportBesoin->id }}">Statut</label>
                                                                            <select class="form-control @error('statut') is-invalid @enderror" id="statut-{{ $rapportBesoin->id }}" name="statut" required>
                                                                                <option value="en attente" {{ old('statut', $rapportBesoin->statut) == 'en attente' ? 'selected' : '' }}>En Attente</option>
                                                                                <option value="en cours" {{ old('statut', $rapportBesoin->statut) == 'en cours' ? 'selected' : '' }}>En Cours</option>
                                                                                <option value="réalisé" {{ old('statut', $rapportBesoin->statut) == 'réalisé' ? 'selected' : '' }}>Réalisé</option>
                                                                            </select>
                                                                            @error('statut')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="espace_vert_id-{{ $rapportBesoin->id }}">Espace Vert</label>
                                                                            <select class="form-control @error('espace_vert_id') is-invalid @enderror" id="espace_vert_id-{{ $rapportBesoin->id }}" name="espace_vert_id" required>
                                                                                @foreach($espaceVerts as $espaceVert)
                                                                                    <option value="{{ $espaceVert->id }}" {{ old('espace_vert_id', $rapportBesoin->espace_vert_id) == $espaceVert->id ? 'selected' : '' }}>{{ $espaceVert->nom }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            @error('espace_vert_id')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="deleteModal-{{ $rapportBesoin->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $rapportBesoin->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel-{{ $rapportBesoin->id }}">Confirmer Suppression</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Êtes-vous sûr de vouloir supprimer le rapport besoin du {{ $rapportBesoin->date_rapport }} ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                                    <form action="{{ route('rapport-besoins.destroy', $rapportBesoin->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Aucun rapport besoin trouvé.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            @include('admin_dashboard.partials.footer')
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Ready to Leave?</h1>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Rapport Besoin Modal -->
    <div class="modal fade" id="addRapportBesoinModal" tabindex="-1" role="dialog" aria-labelledby="addRapportBesoinModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRapportBesoinModalLabel">Ajouter Nouveau Rapport Besoin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rapport-besoins.store') }}" method="POST" id="addForm">
                        @csrf
                        <div class="form-group">
                            <label for="date_rapport">Date Rapport</label>
                            <input type="date" class="form-control" id="date_rapport" name="date_rapport" value="{{ old('date_rapport') }}" required>
                            <div class="invalid-feedback" style="display: none;">La date est obligatoire ou doit être aujourd'hui ou une date future.</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            <div class="invalid-feedback" style="display: none;">La description est obligatoire ou ne doit pas dépasser 1000 caractères.</div>
                        </div>
                        <div class="form-group">
                            <label for="priorite">Priorité</label>
                            <select class="form-control" id="priorite" name="priorite" required>
                                <option value="">Sélectionner</option>
                                <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                                <option value="moyenne" {{ old('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                <option value="élevée" {{ old('priorite') == 'élevée' ? 'selected' : '' }}>Élevée</option>
                            </select>
                            <div class="invalid-feedback" style="display: none;">La priorité est obligatoire ou doit être faible, moyenne ou élevée.</div>
                        </div>
                        <div class="form-group">
                            <label for="cout_estime">Coût Estimé (DT)</label>
                            <input type="number" step="0.01" class="form-control" id="cout_estime" name="cout_estime" value="{{ old('cout_estime') }}" required min="0">
                            <div class="invalid-feedback" style="display: none;">Le coût estimé doit être un nombre positif.</div>
                        </div>
                        <div class="form-group">
                            <label for="statut">Statut</label>
                            <select class="form-control" id="statut" name="statut" required>
                                <option value="">Sélectionner</option>
                                <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En Attente</option>
                                <option value="en cours" {{ old('statut') == 'en cours' ? 'selected' : '' }}>En Cours</option>
                                <option value="réalisé" {{ old('statut') == 'réalisé' ? 'selected' : '' }}>Réalisé</option>
                            </select>
                            <div class="invalid-feedback" style="display: none;">Le statut est obligatoire ou doit être en attente, en cours ou réalisé.</div>
                        </div>
                        <div class="form-group">
                            <label for="espace_vert_id">Espace Vert</label>
                            <select class="form-control" id="espace_vert_id" name="espace_vert_id" required>
                                <option value="">Sélectionner un espace vert</option>
                                @foreach($espaceVerts as $espaceVert)
                                    <option value="{{ $espaceVert->id }}" {{ old('espace_vert_id') == $espaceVert->id ? 'selected' : '' }}>{{ $espaceVert->nom }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" style="display: none;">L'espace vert est obligatoire.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('tableBody');
            const sortValue = document.querySelector('#searchInput')?.dataset.sort || 'newest';

            // Client-side validation for Add and Edit forms
            const addForm = document.getElementById('addForm');
            const editForms = document.querySelectorAll('form[id^="editForm-"]');

            function validateForm(form) {
                let isValid = true;
                const fields = [
                    { input: form.querySelector('input[name="date_rapport"]'), feedback: form.querySelector('input[name="date_rapport"]').nextElementSibling, rules: [
                        { check: val => !val, message: 'La date est obligatoire.' },
                        { check: val => val && new Date(val) < new Date(), message: 'La date doit être aujourd\'hui ou une date future.' }
                    ]},
                    { input: form.querySelector('textarea[name="description"]'), feedback: form.querySelector('textarea[name="description"]').nextElementSibling, rules: [
                        { check: val => !val.trim(), message: 'La description est obligatoire.' },
                        { check: val => val.length > 1000, message: 'La description ne doit pas dépasser 1000 caractères.' }
                    ]},
                    { input: form.querySelector('select[name="priorite"]'), feedback: form.querySelector('select[name="priorite"]').nextElementSibling, rules: [
                        { check: val => !val, message: 'La priorité est obligatoire.' },
                        { check: val => !['faible', 'moyenne', 'élevée'].includes(val), message: 'La priorité doit être faible, moyenne ou élevée.' }
                    ]},
                    { input: form.querySelector('input[name="cout_estime"]'), feedback: form.querySelector('input[name="cout_estime"]').nextElementSibling, rules: [
                        { check: val => !val || parseFloat(val) < 0, message: 'Le coût estimé doit être un nombre positif.' }
                    ]},
                    { input: form.querySelector('select[name="statut"]'), feedback: form.querySelector('select[name="statut"]').nextElementSibling, rules: [
                        { check: val => !val, message: 'Le statut est obligatoire.' },
                        { check: val => !['en attente', 'en cours', 'réalisé'].includes(val), message: 'Le statut doit être en attente, en cours ou réalisé.' }
                    ]},
                    { input: form.querySelector('select[name="espace_vert_id"]'), feedback: form.querySelector('select[name="espace_vert_id"]').nextElementSibling, rules: [
                        { check: val => !val, message: 'L\'espace vert est obligatoire.' }
                    ]}
                ];

                fields.forEach(field => {
                    field.input.classList.remove('is-invalid');
                    field.feedback.style.display = 'none';

                    for (let rule of field.rules) {
                        if (rule.check(field.input.value)) {
                            field.input.classList.add('is-invalid');
                            field.feedback.textContent = rule.message;
                            field.feedback.style.display = 'block';
                            isValid = false;
                            break; // Stop at first validation failure for this field
                        }
                    }
                });

                return isValid;
            }

            // Validate on input change and submit
            function setupRealTimeValidation(form) {
                const fields = [
                    form.querySelector('input[name="date_rapport"]'),
                    form.querySelector('textarea[name="description"]'),
                    form.querySelector('select[name="priorite"]'),
                    form.querySelector('input[name="cout_estime"]'),
                    form.querySelector('select[name="statut"]'),
                    form.querySelector('select[name="espace_vert_id"]')
                ];

                fields.forEach(input => {
                    if (input) {
                        input.addEventListener('input', () => {
                            validateForm(form); // Re-validate on every change
                        });
                        input.addEventListener('change', () => {
                            validateForm(form); // Re-validate on change (e.g., select)
                        });
                    }
                });
            }

            setupRealTimeValidation(addForm);
            editForms.forEach(form => setupRealTimeValidation(form));

            addForm.addEventListener('submit', function(event) {
                if (!validateForm(this)) {
                    event.preventDefault();
                }
            });

            editForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    if (!validateForm(this)) {
                        event.preventDefault();
                    }
                });
            });

            function updateTable(searchTerm) {
                fetch(`/rapport-besoins?search=${encodeURIComponent(searchTerm)}&sort=${encodeURIComponent(sortValue)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (!Array.isArray(data)) {
                        console.error('Data is not an array:', data);
                        return;
                    }
                    tableBody.innerHTML = '';
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        const prioriteBadge = item.priorite === 'élevée' ? 'badge-danger' : (item.priorite === 'moyenne' ? 'badge-warning' : 'badge-success');
                        const statutBadge = item.statut === 'réalisé' ? 'badge-success' : (item.statut === 'en cours' ? 'badge-warning' : 'badge-secondary');
                        row.innerHTML = `
                            <td>${item.date_rapport}</td>
                            <td>${item.description.length > 50 ? item.description.substring(0, 50) + '...' : item.description}</td>
                            <td><span class="badge ${prioriteBadge}">${item.priorite.charAt(0).toUpperCase() + item.priorite.slice(1)}</span></td>
                            <td>${parseFloat(item.cout_estime).toFixed(2)} dt</td>
                            <td><span class="badge ${statutBadge}">${item.statut.charAt(0).toUpperCase() + item.statut.slice(1)}</span></td>
                            <td>${item.espace_vert_nom || 'N/A'}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#editModal-${item.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <div class="modal fade" id="editModal-${item.id}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-${item.id}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel-${item.id}">Modifier Rapport Besoin</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/rapport-besoins/${item.id}" method="POST" id="editForm-${item.id}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="date_rapport-${item.id}">Date Rapport</label>
                                                        <input type="date" class="form-control" id="date_rapport-${item.id}" name="date_rapport" value="${item.date_rapport}" required>
                                                        <div class="invalid-feedback" style="display: none;">La date est obligatoire ou doit être aujourd\'hui ou une date future.</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description-${item.id}">Description</label>
                                                        <textarea class="form-control" id="description-${item.id}" name="description" rows="3" required>${item.description}</textarea>
                                                        <div class="invalid-feedback" style="display: none;">La description est obligatoire ou ne doit pas dépasser 1000 caractères.</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="priorite-${item.id}">Priorité</label>
                                                        <select class="form-control" id="priorite-${item.id}" name="priorite" required>
                                                            <option value="faible" ${item.priorite === 'faible' ? 'selected' : ''}>Faible</option>
                                                            <option value="moyenne" ${item.priorite === 'moyenne' ? 'selected' : ''}>Moyenne</option>
                                                            <option value="élevée" ${item.priorite === 'élevée' ? 'selected' : ''}>Élevée</option>
                                                        </select>
                                                        <div class="invalid-feedback" style="display: none;">La priorité est obligatoire ou doit être faible, moyenne ou élevée.</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cout_estime-${item.id}">Coût Estimé (DT)</label>
                                                        <input type="number" step="0.01" class="form-control" id="cout_estime-${item.id}" name="cout_estime" value="${item.cout_estime}" required min="0">
                                                        <div class="invalid-feedback" style="display: none;">Le coût estimé doit être un nombre positif.</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="statut-${item.id}">Statut</label>
                                                        <select class="form-control" id="statut-${item.id}" name="statut" required>
                                                            <option value="en attente" ${item.statut === 'en attente' ? 'selected' : ''}>En Attente</option>
                                                            <option value="en cours" ${item.statut === 'en cours' ? 'selected' : ''}>En Cours</option>
                                                            <option value="réalisé" ${item.statut === 'réalisé' ? 'selected' : ''}>Réalisé</option>
                                                        </select>
                                                        <div class="invalid-feedback" style="display: none;">Le statut est obligatoire ou doit être en attente, en cours ou réalisé.</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="espace_vert_id-${item.id}">Espace Vert</label>
                                                        <select class="form-control" id="espace_vert_id-${item.id}" name="espace_vert_id" required>
                                                            <option value="${item.espace_vert_id}" selected>${item.espace_vert_nom}</option>
                                                        </select>
                                                        <div class="invalid-feedback" style="display: none;">L\'espace vert est obligatoire.</div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="deleteModal-${item.id}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-${item.id}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel-${item.id}">Confirmer Suppression</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Êtes-vous sûr de vouloir supprimer le rapport besoin du ${item.date_rapport} ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                                <form action="/rapport-besoins/${item.id}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
            }

            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            const debouncedUpdateTable = debounce(updateTable, 300);

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    debouncedUpdateTable(this.value);
                });
            }
        });
    </script>
    @vite([
        'resources/vendor/jquery/jquery.min.js',
        'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'resources/vendor/jquery-easing/jquery.easing.min.js',
        'resources/js/sb-admin-2.min.js',
        'resources/vendor/chart.js/Chart.min.js',
        'resources/js/demo/chart-area-demo.js',
        'resources/js/demo/chart-pie-demo.js'
    ])
</body>
</html>