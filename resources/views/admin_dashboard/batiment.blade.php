@extends('admin_dashboard.layout')

@section('title', 'Gestion des Bâtiments')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Bâtiments</h1>
        <a href="{{ route('backoffice.createbatiment') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter un Bâtiment
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Liste des Bâtiments</h6>

                    <!-- Filtres et Recherche -->
                    <div class="d-flex align-items-center gap-3">
                        <!-- Filtre par type -->
                        <div class="d-flex align-items-center">
                            <label for="filter-type" class="me-2 mb-0" style="font-size: 0.9rem;">Type:</label>
                            <select id="filter-type" class="form-select form-select-sm" style="width: 120px;">
                                <option value="">Tous</option>
                                <option value="Maison">Maison</option>
                                <option value="Usine">Usine</option>
                            </select>
                        </div>

                        <!-- Recherche par adresse -->
                        <div class="d-flex align-items-center">
                            <label for="search-adresse" class="me-2 mb-0" style="font-size: 0.9rem;">Adresse:</label>
                            <input type="text" id="search-adresse" class="form-control form-control-sm" placeholder="Rechercher..." style="width: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    @if($batiments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Adresse</th>
                                        <th>Zone</th>
                                        <th>Propriétaire</th>
                                        <th>Émission CO2</th>
                                        <th>Émission Réelle</th>
                                        <th>Arbres Besoin</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="batiments-table-body">
                                    @foreach($batiments as $batiment)
                                    <tr>
                                        <td>{{ $batiment->id }}</td>
                                        <td>
                                            <span class="badge bg-{{ $batiment->type_batiment === 'Maison' ? 'success' : 'warning' }}">
                                                {{ $batiment->type_batiment }}
                                            </span>
                                        </td>
                                        <td>{{ Str::limit($batiment->adresse, 30) }}</td>
                                        <td>{{ $batiment->zone->nom ?? 'N/A' }}</td>
                                        <td>{{ $batiment->user->name ?? 'N/A' }}</td>
                                        <td>{{ number_format($batiment->emissionCO2, 2) }} t/an</td>
                                        <td>{{ number_format($batiment->emission_reelle, 2) }} t/an</td>
                                        <td>{{ $batiment->nbArbresBesoin }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('backoffice.showbatiment', $batiment) }}" class="btn btn-sm btn-info" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('backoffice.editbatiment', $batiment) }}" class="btn btn-sm btn-warning" title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('backoffice.destroybatiment', $batiment) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bâtiment ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $batiments->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-building fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun bâtiment trouvé</h5>
                            <p class="text-muted">Il n'y a actuellement aucun bâtiment enregistré dans le système.</p>
                            <a href="{{ route('backoffice.createbatiment') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Ajouter le premier bâtiment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts pour la recherche et les filtres -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-adresse');
    const typeFilter = document.getElementById('filter-type');
    const tableBody = document.getElementById('batiments-table-body');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const typeValue = typeFilter.value.toLowerCase();

        const rows = tableBody.querySelectorAll('tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const adresse = cells[2].textContent.toLowerCase();
            const type = cells[1].textContent.toLowerCase();

            const matchesSearch = searchTerm === '' || adresse.includes(searchTerm);
            const matchesType = typeValue === '' || type.includes(typeValue);

            row.style.display = (matchesSearch && matchesType) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    typeFilter.addEventListener('change', filterTable);
});
</script>
@endsection