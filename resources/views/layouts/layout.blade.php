<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentDeletePubId = null;

    document.querySelectorAll('.comment-toggle-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var pubId = btn.getAttribute('data-publication-id');
            var section = document.getElementById('comments-section-' + pubId);
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    });

    document.querySelectorAll('.likes-dislikes-toggle-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var pubId = btn.getAttribute('data-publication-id');
            var section = document.getElementById('likes-dislikes-section-' + pubId);
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    });

    // Handle delete publication button click
    document.querySelectorAll('.delete-publication-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            currentDeletePubId = btn.getAttribute('data-publication-id');
            $('#deletePublicationModal').modal('show');
        });
    });

    // Handle confirm delete button click
    document.getElementById('confirmDeletePublicationBtn').addEventListener('click', function() {
        if (currentDeletePubId) {
            // Find the form with the matching publication ID in the action URL
            const forms = document.querySelectorAll('.delete-publication-form');
            forms.forEach(function(form) {
                if (form.action.includes('/publications/' + currentDeletePubId)) {
                    form.submit();
                }
            });
        }
    });
});
</script>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>


    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    @vite([
        'resources/vendor/fontawesome-free/css/all.min.css',
        'resources/css/sb-admin-2.min.css',
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/vendor/jquery/jquery.min.js',
        'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'resources/vendor/jquery-easing/jquery.easing.min.js',
        'resources/js/sb-admin-2.min.js',
        'resources/vendor/chart.js/Chart.min.js',
        'resources/js/demo/chart-area-demo.js',
        'resources/js/demo/chart-pie-demo.js'
    ])

</head>

<body id="page-top">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="position:fixed;top:20px;right:20px;z-index:2000;min-width:300px;box-shadow:0 4px 12px rgba(0,0,0,0.15);">
            <strong>Succès!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
        </div>
    @endif

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('admin_dashboard.partials.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('img/undraw_profile_1.svg') }}" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('img/undraw_profile_2.svg') }}" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('img/undraw_profile_3.svg') }}" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Search and Filter Bar -->
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

                    <!-- Content Row -->
                    <div class="row" id="publications-list">
                        @forelse($publications as $publication)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card shadow h-100 publication-card position-relative" style="border-radius:20px;overflow:hidden;">
                                    <!-- Edit & Delete Icons -->
                                    <div style="position:absolute;top:12px;right:16px;z-index:10;display:flex;gap:8px;">
                                        <!-- Edit Icon -->
                                        <button type="button" class="btn btn-sm btn-info edit-publication-btn" data-publication-id="{{ $publication->id }}" data-publication-titre="{{ $publication->titre }}" data-publication-description="{{ $publication->description }}" data-publication-image="{{ $publication->image }}" style="border-radius:50%;padding:6px 8px;line-height:1;box-shadow:0 2px 8px rgba(78,115,223,0.12);">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <!-- Delete Icon -->
                                        <form method="POST" action="{{ route('publications.destroy', $publication->id) }}" class="delete-publication-form" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-publication-btn" data-publication-id="{{ $publication->id }}" style="border-radius:50%;padding:6px 8px;line-height:1;box-shadow:0 2px 8px rgba(231,74,59,0.12);">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                            <!-- Comment Icon -->
                                            <button type="button" class="btn btn-sm btn-light comment-toggle-btn" data-publication-id="{{ $publication->id }}" style="border-radius:50%;padding:6px 8px;line-height:1;box-shadow:0 2px 8px rgba(40,167,69,0.12);" title="Voir les commentaires">
                                                <i class="fas fa-comments text-success"></i>
                                            </button>
                                            <!-- Like/Dislike Icon -->
                                            <button type="button" class="btn btn-sm btn-outline-info likes-dislikes-toggle-btn" data-publication-id="{{ $publication->id }}" style="border-radius:50%;padding:6px 8px;line-height:1;box-shadow:0 2px 8px rgba(23,162,184,0.12);" title="Voir likes/dislikes">
                                                <i class="fas fa-thumbs-up"></i>
                                            </button>
                                    </div>
                                    <img src="{{ $publication->image ? asset('storage/' . $publication->image) : asset('img/undraw_posting_photo.svg') }}" class="card-img-top" alt="{{ $publication->titre }}" style="height:220px;object-fit:cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-primary font-weight-bold">{{ $publication->titre }}</h5>
                                        <p class="card-text" style="flex:1;color:#444;font-size:1.05rem;">{{ $publication->description }}</p>
                                        <div class="mt-2 text-right">
                                            <span class="badge badge-pill badge-info" style="font-size:0.95rem;">Ajouté le {{ $publication->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                        <!-- Bloc commentaires masqué/affiché -->
                                        <div class="comments-section" id="comments-section-{{ $publication->id }}" style="display:none;background:#f8f9fa;border-top:1px solid #e3e6f0;padding:16px 20px;">
                                            <h6 class="mb-3 text-success"><i class="fas fa-comments"></i> Commentaires</h6>
                                            @php $comments = $publication->comments()->with('user')->latest()->get(); @endphp
                                            @if($comments->count())
                                                @foreach($comments as $comment)
                                                    <div class="d-flex mb-2 align-items-start">
                                                        <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                                                        <div>
                                                            <div class="fw-bold small">{{ $comment->user->name ?? 'Utilisateur' }} <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span></div>
                                                            <div class="small">{{ $comment->content }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="text-muted small">Aucun commentaire pour cette publication.</div>
                                            @endif
                                        </div>
                                        <!-- Bloc likes/dislikes masqué/affiché -->
                                        <div class="likes-dislikes-section" id="likes-dislikes-section-{{ $publication->id }}" style="display:none;background:#f8f9fa;border-top:1px solid #e3e6f0;padding:16px 20px;">
                                            <h6 class="mb-3 text-info"><i class="fas fa-thumbs-up"></i> Likes & Dislikes</h6>
                                            <div class="d-flex gap-3">
                                                <span class="badge badge-success">{{ $publication->getLikesCount() }} Likes</span>
                                                <span class="badge badge-danger">{{ $publication->getDislikesCount() }} Dislikes</span>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info text-center">Aucune publication trouvée.</div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Modal de confirmation suppression publication (à placer en dehors de la boucle) -->
                    <div class="modal fade" id="deletePublicationModal" tabindex="-1" aria-labelledby="deletePublicationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius:24px;">
                                <div class="modal-header" style="background:linear-gradient(90deg,#e74a3b 0%,#f8f9fa 100%);color:#fff;border-top-left-radius:24px;border-top-right-radius:24px;">
                                    <h5 class="modal-title" id="deletePublicationModalLabel">Confirmation de suppression</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;font-size:2rem;opacity:0.8;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                        </div>
                        <div class="modal-body text-center">
                            <p style="font-size:1.15rem;color:#e74a3b;font-weight:500;">Voulez-vous vraiment supprimer cette publication ?</p>
                        </div>
                        <div class="modal-footer" style="border-bottom-left-radius:24px;border-bottom-right-radius:24px;justify-content:center;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="button" class="btn btn-danger" id="confirmDeletePublicationBtn">Supprimer</button>
                        </div>
                    </div>
                    </div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
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


    <!-- Edit Publication Modal -->
    <div class="modal fade" id="editPublicationModal" tabindex="-1" aria-labelledby="editPublicationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content urban-modal">
                <div class="urban-modal-header" style="background: linear-gradient(90deg,#4e73df 0%,#1cc88a 100%); color: #fff; border-top-left-radius: 32px; border-top-right-radius: 32px; display: flex; flex-direction: column; align-items: center; padding: 2rem 1rem 1rem 1rem;">
                    <img src="{{ asset('img/undraw_posting_photo.svg') }}" alt="Illustration" class="urban-illustration">
                    <span class="urban-modal-title" id="editPublicationModalLabel">Modifier la publication</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:18px;right:24px;font-size:2rem;color:#fff;opacity:0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="editPublicationForm" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="urban-modal-body">
                        <input type="hidden" id="edit_publication_id" name="publication_id">
                        <div class="mb-4">
                            <label for="edit_titre" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="edit_titre" name="titre" placeholder="Titre de la publication">
                        </div>
                        <div class="mb-4">
                            <label for="edit_image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="edit_image" name="image" accept="image/*" onchange="previewEditPublicationImage(event)">
                            <div id="editImagePreviewContainer" style="margin-top:1rem;text-align:center;display:none;">
                                <img id="editImagePreview" src="#" alt="Aperçu de l'image" style="max-width:180px;max-height:180px;border-radius:16px;box-shadow:0 2px 8px rgba(78,115,223,0.12);border:2px solid #4e73df;object-fit:cover;">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="4" placeholder="Décris ta publication..."></textarea>
                        </div>
                    </div>
                    <div class="urban-modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function previewEditPublicationImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('editImagePreviewContainer');
        const preview = document.getElementById('editImagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            previewContainer.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Edit icon click handler
        $(document).on('click', '.edit-publication-btn', function(e) {
            e.preventDefault();
            // Get publication data from data attributes
            var id = $(this).data('publication-id');
            var titre = $(this).data('publication-titre');
            var description = $(this).data('publication-description');
            var image = $(this).data('publication-image');

            // Fill modal fields
            $('#edit_publication_id').val(id);
            $('#edit_titre').val(titre);
            $('#edit_description').val(description);
            if (image) {
                $('#editImagePreview').attr('src', '/storage/' + image);
                $('#editImagePreviewContainer').show();
            } else {
                $('#editImagePreview').attr('src', '#');
                $('#editImagePreviewContainer').hide();
            }

            // Set form action
            $('#editPublicationForm').attr('action', '/publications/' + id);

            // Show modal
            $('#editPublicationModal').modal('show');
        });
    });
    </script>

    <!-- Bootstrap core JavaScript-->
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Easing CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- FontAwesome JS (optionnel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

            <!-- Bouton Ajouter Publication -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPublicationModal" style="position:fixed;bottom:30px;right:30px;z-index:1050;display:flex;align-items:center;gap:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPublicationModal" style="position:fixed;bottom:30px;right:30px;z-index:1050;display:flex;align-items:center;gap:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Ajouter une publication
            </button>


            <!-- Modal Ajout Publication améliorée -->
            <style>
                .form-control.is-invalid {
                    border-color: #e74a3b !important;
                    box-shadow: 0 0 0 2px #e74a3b33 !important;
                }
                .input-error {
                    font-size: 0.98rem;
                    color: #e74a3b !important;
                    font-weight: 500;
                }
                .modal-backdrop.show {
                    backdrop-filter: blur(6px);
                }
                .modal-content.urban-modal {
                    border-radius: 32px;
                    box-shadow: 0 12px 48px rgba(78, 115, 223, 0.18), 0 2px 8px rgba(0,0,0,0.08);
                    background: linear-gradient(135deg, #e3eafc 0%, #f8f9fa 100%);
                    border: none;
                    animation: modalPop 0.4s cubic-bezier(.68,-0.55,.27,1.55);
                }
                @keyframes modalPop {
                    0% { transform: scale(0.8); opacity: 0; }
                    100% { transform: scale(1); opacity: 1; }
                }
                .urban-modal-header {
                    background: linear-gradient(90deg,#4e73df 0%,#1cc88a 100%);
                    color: #fff;
                    border-top-left-radius: 32px;
                    border-top-right-radius: 32px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    padding: 2rem 1rem 1rem 1rem;
                }
                .urban-modal-header .urban-illustration {
                    width: 64px;
                    height: 64px;
                    margin-bottom: 0.5rem;
                }
                .urban-modal-title {
                    font-size: 2rem;
                    font-weight: 700;
                    letter-spacing: 1px;
                }
                .urban-modal-body {
                    background: transparent;
                    padding: 2rem 2rem 1rem 2rem;
                }
                .urban-modal-body .form-label {
                    font-weight: 600;
                    color: #4e73df;
                }
                .urban-modal-body .form-control {
                    border-radius: 12px;
                    border: 1.5px solid #4e73df;
                    box-shadow: 0 2px 8px rgba(78,115,223,0.08);
                    transition: border-color 0.2s;
                }
                .urban-modal-body .form-control:focus {
                    border-color: #1cc88a;
                    box-shadow: 0 0 0 2px #4e73df33;
                }
                .urban-modal-footer {
                    border-bottom-left-radius: 32px;
                    border-bottom-right-radius: 32px;
                    padding: 1.5rem 2rem;
                    display: flex;
                    justify-content: flex-end;
                    gap: 1rem;
                    background: #f8f9fa;
                }
                .urban-modal-footer .btn {
                    min-width: 120px;
                    font-size: 1.1rem;
                    border-radius: 12px;
                    font-weight: 600;
                    box-shadow: 0 2px 8px rgba(34,197,94,0.08);
                    transition: background 0.2s, color 0.2s;
                }
                .urban-modal-footer .btn-success {
                    background: linear-gradient(90deg,#4e73df 0%,#1cc88a 100%);
                    border: none;
                }
                .urban-modal-footer .btn-success:hover {
                    background: linear-gradient(90deg,#1cc88a 0%,#4e73df 100%);
                    color: #fff;
                }
                .urban-modal-footer .btn-secondary {
                    background: #e3eafc;
                    color: #4e73df;
                    border: none;
                }
                .urban-modal-footer .btn-secondary:hover {
                    background: #4e73df;
                    color: #fff;
                }
            </style>
            <div class="modal fade" id="addPublicationModal" tabindex="-1" aria-labelledby="addPublicationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content urban-modal">
                        <div class="urban-modal-header">
                            <img src="{{ asset('img/undraw_posting_photo.svg') }}" alt="Illustration" class="urban-illustration">
                            <span class="urban-modal-title" id="addPublicationModalLabel">Ajouter une publication</span>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:18px;right:24px;font-size:2rem;color:#fff;opacity:0.8;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('publications.store') }}" enctype="multipart/form-data" id="publicationForm" onsubmit="return validatePublicationForm(event)">
                            @csrf
                            <div class="urban-modal-body">
                                <div class="mb-4">
                                    <label for="titre" class="form-label">Titre</label>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de la publication">
                                </div>
                                <div class="mb-4">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewPublicationImage(event)">
                                    <div id="imagePreviewContainer" style="margin-top:1rem;text-align:center;display:none;">
                                        <img id="imagePreview" src="#" alt="Aperçu de l'image" style="max-width:180px;max-height:180px;border-radius:16px;box-shadow:0 2px 8px rgba(78,115,223,0.12);border:2px solid #4e73df;object-fit:cover;">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Décris ta publication..."></textarea>
                                </div>
                            </div>
                            <div class="urban-modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-success">Publier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

<script>
function previewPublicationImage(event) {
    const input = event.target;
    const previewContainer = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        previewContainer.style.display = 'none';
    }
}

function validatePublicationForm(event) {
    let valid = true;
    let titre = document.getElementById('titre');
    let image = document.getElementById('image');
    let description = document.getElementById('description');

    // Remove previous errors
    document.querySelectorAll('.input-error').forEach(e => e.remove());
    [titre, image, description].forEach(el => el.classList.remove('is-invalid'));

    // Titre
    if (!titre.value.trim()) {
        showInputError(titre, "Le titre est obligatoire.");
        valid = false;
    } else if (titre.value.length < 3) {
        showInputError(titre, "Le titre doit contenir au moins 3 caractères.");
        valid = false;
    }

    // Image
    if (!image.value) {
        showInputError(image, "L'image est obligatoire.");
        valid = false;
    } else if (image.files[0] && !image.files[0].type.match('image.*')) {
        showInputError(image, "Le fichier doit être une image.");
        valid = false;
    }

    // Description
    if (!description.value.trim()) {
        showInputError(description, "La description est obligatoire.");
        valid = false;
    } else if (description.value.length < 10) {
        showInputError(description, "La description doit contenir au moins 10 caractères.");
        valid = false;
    }

    return valid;
}

function showInputError(input, message) {
    input.classList.add('is-invalid');
    let error = document.createElement('div');
    error.className = 'input-error text-danger mt-1';
    error.innerText = message;
    input.parentNode.appendChild(error);
}
</script>
</body>

</html>