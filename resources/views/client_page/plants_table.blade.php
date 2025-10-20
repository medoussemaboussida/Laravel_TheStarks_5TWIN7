<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Liste des Plantes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="clientPlantsTable" width="100%" cellspacing="0">
                <thead class="table-success">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Âge</th>
                        <th>Localisation</th>
                        <th>Prix</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plantes as $plante)
                    <tr>
                        <td>{{ $plante->id }}</td>
                        <td>{{ $plante->name }}</td>
                        <td>{{ $plante->type->name ?? 'N/A' }}</td>
                        <td>{{ $plante->age ?? 'N/A' }}</td>
                        <td>{{ $plante->location ?? 'Non spécifiée' }}</td>
                        <td>{{ $plante->prix ?? 'N/A' }} DT</td>
                        <td>{{ $plante->stock ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#clientPlantsTable').DataTable({
        "pagingType": "simple_numbers",
        "pageLength": 5,
        "lengthChange": false,
        "language": {"paginate": {"previous": "<", "next": ">" }},
        "dom": '<"top"f>rt<"bottom"ip><"clear">'
    });
});
</script>
@endpush
