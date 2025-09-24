<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>UrbanGreen - Manage Green Spaces</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Green Spaces</h1>
                        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addEspaceVertModal">
                            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter Espace Vert
                        </button>
                    </div>

                    <!-- Table of Espace Vert -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">List of Green Spaces</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Area (m²)</th>
                                            <th>Type</th>
                                            <th>Condition</th>
                                            <th>Specific Needs</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($espacesVerts as $espaceVert)
                                            <tr>
                                                <td>{{ $espaceVert->id }}</td>
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
                                                                    <form action="{{ route('espace.update', $espaceVert->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="form-group">
                                                                            <label for="nom-{{ $espaceVert->id }}">Name</label>
                                                                            <input type="text" class="form-control @error('nom', 'update') is-invalid @enderror" id="nom-{{ $espaceVert->id }}" name="nom" value="{{ old('nom', $espaceVert->nom) }}" required>
                                                                            @error('nom', 'update')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="adresse-{{ $espaceVert->id }}">Address</label>
                                                                            <input type="text" class="form-control @error('adresse', 'update') is-invalid @enderror" id="adresse-{{ $espaceVert->id }}" name="adresse" value="{{ old('adresse', $espaceVert->adresse) }}" required>
                                                                            @error('adresse', 'update')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="superficie-{{ $espaceVert->id }}">Area (m²)</label>
                                                                            <input type="number" step="0.01" class="form-control @error('superficie', 'update') is-invalid @enderror" id="superficie-{{ $espaceVert->id }}" name="superficie" value="{{ old('superficie', $espaceVert->superficie) }}" required>
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
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
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
                    <form action="{{ route('espace.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nom">Name</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="adresse">Address</label>
                            <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" value="{{ old('adresse') }}" required>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="superficie">Area (m²)</label>
                            <input type="number" step="0.01" class="form-control @error('superficie') is-invalid @enderror" id="superficie" name="superficie" value="{{ old('superficie') }}" required>
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