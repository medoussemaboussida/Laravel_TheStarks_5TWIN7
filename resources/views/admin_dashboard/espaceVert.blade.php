<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>UrbanGreen - Espaces verts</title>
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
                    <!-- Add Button -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Gestion des espaces verts</h1>
                        <div class="d-flex">
                            <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2" data-toggle="modal" data-target="#addEspaceVertModal">
                                <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter Espace Vert
                            </button>
                            <a href="{{ route('rapport-besoins.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                                <i class="fas fa-eye fa-sm text-white-50"></i> Voir Rapports
                            </a>
                        </div>
                    </div>

                    <!-- Table of Espace Vert -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des espaces</h6>
                            <form method="GET" action="{{ route('espace.index') }}" style="display:inline;">
                                <select class="btn btn-sm btn-primary" name="sort" onchange="this.form.submit()">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                    <option value="superficie_asc" {{ request('sort') == 'superficie_asc' ? 'selected' : '' }}>Superficie Asc</option>
                                    <option value="superficie_desc" {{ request('sort') == 'superficie_desc' ? 'selected' : '' }}>Superficie Desc</option>
                                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name Asc</option>
                                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Desc</option>
                                </select>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Adresse</th>
                                            <th>Superficie (m²)</th>
                                            <th>Type</th>
                                            <th>Condition</th>
                                            <th>Besoin specifique</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        @foreach($espacesVerts as $espaceVert)
                                            <tr>
                                                <td>{{ $espaceVert->nom }}</td>
                                                <td>{{ $espaceVert->adresse }}</td>
                                                <td>{{ $espaceVert->superficie }}</td>
                                                <td>{{ $espaceVert->type }}</td>
                                                <td>{{ $espaceVert->etat }}</td>
                                                <td>{{ $espaceVert->besoin_specifique }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#editModal-{{ $espaceVert->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $espaceVert->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editModal-{{ $espaceVert->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-{{ $espaceVert->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel-{{ $espaceVert->id }}">Edit Green Space</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('espace.update', $espaceVert->id) }}" method="POST" id="editForm-{{ $espaceVert->id }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-group">
                                                                            <label for="nom-{{ $espaceVert->id }}">Name</label>
                                                                            <input type="text" class="form-control @error('nom', 'update') is-invalid @enderror" id="nom-{{ $espaceVert->id }}" name="nom" value="{{ old('nom', $espaceVert->nom) }}" required minlength="3">
                                                                            @error('nom', 'update')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="adresse-{{ $espaceVert->id }}">Address</label>
                                                                            <input type="text" class="form-control @error('adresse', 'update') is-invalid @enderror" id="adresse-{{ $espaceVert->id }}" name="adresse" value="{{ old('adresse', $espaceVert->adresse) }}" required minlength="5">
                                                                            @error('adresse', 'update')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="superficie-{{ $espaceVert->id }}">Area (m²)</label>
                                                                            <input type="number" step="0.01" class="form-control @error('superficie', 'update') is-invalid @enderror" id="superficie-{{ $espaceVert->id }}" name="superficie" value="{{ old('superficie', $espaceVert->superficie) }}" required min="0">
                                                                            @error('superficie', 'update')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="type-{{ $espaceVert->id }}">Type</label>
                                                                            <select class="form-control @error('type', 'update') is-invalid @enderror" id="type-{{ $espaceVert->id }}" name="type" required>
                                                                                <option value="parc" {{ old('type', $espaceVert->type) == 'parc' ? 'selected' : '' }}>Parc</option>
                                                                                <option value="jardin" {{ old('type', $espaceVert->type) == 'jardin' ? 'selected' : '' }}>Jardin</option>
                                                                                <option value="toit vert" {{ old('type', $espaceVert->type) == 'toit vert' ? 'selected' : '' }}>Toit Vert</option>
                                                                                <option value="autre" {{ old('type', $espaceVert->type) == 'autre' ? 'selected' : '' }}>Autre</option>
                                                                            </select>
                                                                            @error('type', 'update')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="etat-{{ $espaceVert->id }}">Condition</label>
                                                                            <select class="form-control @error('etat', 'update') is-invalid @enderror" id="etat-{{ $espaceVert->id }}" name="etat" required>
                                                                                <option value="bon" {{ old('etat', $espaceVert->etat) == 'bon' ? 'selected' : '' }}>Bon</option>
                                                                                <option value="moyen" {{ old('etat', $espaceVert->etat) == 'moyen' ? 'selected' : '' }}>Moyen</option>
                                                                                <option value="mauvais" {{ old('etat', $espaceVert->etat) == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                                                                            </select>
                                                                            @error('etat', 'update')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="besoin_specifique-{{ $espaceVert->id }}">Specific Needs (Free text, optionally JSON e.g., {"arrosage": true})</label>
                                                                            <textarea class="form-control @error('besoin_specifique', 'update') is-invalid @enderror" id="besoin_specifique-{{ $espaceVert->id }}" name="besoin_specifique" rows="3">{{ old('besoin_specifique', $espaceVert->besoin_specifique) }}</textarea>
                                                                            @error('besoin_specifique', 'update')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="deleteModal-{{ $espaceVert->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-{{ $espaceVert->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel-{{ $espaceVert->id }}">Confirm Deletion</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete the green space "{{ $espaceVert->nom }}"?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('espace.destroy', $espaceVert->id) }}" method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
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

    <!-- Add Espace Vert Modal -->
    <div class="modal fade" id="addEspaceVertModal" tabindex="-1" role="dialog" aria-labelledby="addEspaceVertModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEspaceVertModalLabel">Add New Green Space</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('espace.store') }}" method="POST" id="addForm">
                        @csrf
                        <div class="form-group">
                            <label for="nom">Name</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required minlength="3">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="adresse">Address</label>
                            <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" value="{{ old('adresse') }}" required minlength="5">
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="superficie">Area (m²)</label>
                            <input type="number" step="0.01" class="form-control @error('superficie') is-invalid @enderror" id="superficie" name="superficie" value="{{ old('superficie') }}" required min="0">
                            @error('superficie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="parc" {{ old('type') == 'parc' ? 'selected' : '' }}>Parc</option>
                                <option value="jardin" {{ old('type') == 'jardin' ? 'selected' : '' }}>Jardin</option>
                                <option value="toit vert" {{ old('type') == 'toit vert' ? 'selected' : '' }}>Toit Vert</option>
                                <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="etat">Condition</label>
                            <select class="form-control @error('etat') is-invalid @enderror" id="etat" name="etat" required>
                                <option value="bon" {{ old('etat') == 'bon' ? 'selected' : '' }}>Bon</option>
                                <option value="moyen" {{ old('etat') == 'moyen' ? 'selected' : '' }}>Moyen</option>
                                <option value="mauvais" {{ old('etat') == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                            </select>
                            @error('etat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="besoin_specifique">Specific Needs (Free text, optionally JSON e.g., {"arrosage": true})</label>
                            <textarea class="form-control @error('besoin_specifique') is-invalid @enderror" id="besoin_specifique" name="besoin_specifique" rows="3">{{ old('besoin_specifique') }}</textarea>
                            @error('besoin_specifique')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchInputMobile = document.getElementById('searchInputMobile');
            const tableBody = document.getElementById('tableBody');
            const sortValue = document.querySelector('#searchInput')?.dataset.sort || 'newest';

            // Client-side validation for Add and Edit forms
            const addForm = document.getElementById('addForm');
            const editForms = document.querySelectorAll('form[id^="editForm-"]');

            function validateForm(form) {
                const nom = form.querySelector('input[name="nom"]');
                const adresse = form.querySelector('input[name="adresse"]');
                const superficie = form.querySelector('input[name="superficie"]');
                const type = form.querySelector('select[name="type"]');
                const etat = form.querySelector('select[name="etat"]');

                let isValid = true;

                // Reset validation states
                [nom, adresse, superficie, type, etat].forEach(input => {
                    input.classList.remove('is-invalid');
                    const feedback = input.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.textContent = '';
                    }
                });

                // Validate nom
                if (nom.value.length < 3) {
                    nom.classList.add('is-invalid');
                    nom.nextElementSibling.textContent = 'Name must be at least 3 characters long.';
                    isValid = false;
                }

                // Validate adresse
                if (adresse.value.length < 5) {
                    adresse.classList.add('is-invalid');
                    adresse.nextElementSibling.textContent = 'Address must be at least 5 characters long.';
                    isValid = false;
                }

                // Validate superficie
                if (superficie.value < 0) {
                    superficie.classList.add('is-invalid');
                    superficie.nextElementSibling.textContent = 'Area must be a positive number.';
                    isValid = false;
                }

                // Validate type
                if (!type.value) {
                    type.classList.add('is-invalid');
                    type.nextElementSibling.textContent = 'Please select a type.';
                    isValid = false;
                }

                // Validate etat
                if (!etat.value) {
                    etat.classList.add('is-invalid');
                    etat.nextElementSibling.textContent = 'Please select a condition.';
                    isValid = false;
                }

                return isValid;
            }

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
                fetch(`/espace?search=${encodeURIComponent(searchTerm)}&sort=${encodeURIComponent(sortValue)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    data.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.nom}</td>
                            <td>${item.adresse}</td>
                            <td>${item.superficie}</td>
                            <td>${item.type}</td>
                            <td>${item.etat}</td>
                            <td>${item.besoin_specifique}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm mr-2" data-toggle="modal" data-target="#editModal-${item.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal-${item.id}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-${item.id}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel-${item.id}">Edit Green Space</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/espace/${item.id}" method="POST" id="editForm-${item.id}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label for="nom-${item.id}">Name</label>
                                                        <input type="text" class="form-control" id="nom-${item.id}" name="nom" value="${item.nom}" required minlength="3">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="adresse-${item.id}">Address</label>
                                                        <input type="text" class="form-control" id="adresse-${item.id}" name="adresse" value="${item.adresse}" required minlength="5">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="superficie-${item.id}">Area (m²)</label>
                                                        <input type="number" step="0.01" class="form-control" id="superficie-${item.id}" name="superficie" value="${item.superficie}" required min="0">
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="type-${item.id}">Type</label>
                                                        <select class="form-control" id="type-${item.id}" name="type" required>
                                                            <option value="parc" ${item.type === 'parc' ? 'selected' : ''}>Parc</option>
                                                            <option value="jardin" ${item.type === 'jardin' ? 'selected' : ''}>Jardin</option>
                                                            <option value="toit vert" ${item.type === 'toit vert' ? 'selected' : ''}>Toit Vert</option>
                                                            <option value="autre" ${item.type === 'autre' ? 'selected' : ''}>Autre</option>
                                                        </select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="etat-${item.id}">Condition</label>
                                                        <select class="form-control" id="etat-${item.id}" name="etat" required>
                                                            <option value="bon" ${item.etat === 'bon' ? 'selected' : ''}>Bon</option>
                                                            <option value="moyen" ${item.etat === 'moyen' ? 'selected' : ''}>Moyen</option>
                                                            <option value="mauvais" ${item.etat === 'mauvais' ? 'selected' : ''}>Mauvais</option>
                                                        </select>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="besoin_specifique-${item.id}">Specific Needs</label>
                                                        <textarea class="form-control" id="besoin_specifique-${item.id}" name="besoin_specifique" rows="3">${item.besoin_specifique}</textarea>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal-${item.id}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel-${item.id}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel-${item.id}">Confirm Deletion</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the green space "${item.nom}"?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="/espace/${item.id}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
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
                .catch(error => console.error('Error fetching data:', error));
            }

            // Debounce function to limit API calls
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

            // Initial load
            updateTable('');

            // Event listeners
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    debouncedUpdateTable(this.value);
                });
            }

            if (searchInputMobile) {
                searchInputMobile.addEventListener('input', function() {
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