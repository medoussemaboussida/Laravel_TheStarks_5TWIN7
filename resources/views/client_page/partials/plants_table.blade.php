<!-- Partial: table des plantes (retourné par ClientController@plants) -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Liste des plantes</h5>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Âge</th>
                        <th>Localisation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plants as $plant)
                        <tr>
                            <td>{{ $plant->name }}</td>
                            <td>{{ optional($plant->type)->name ?? '—' }}</td>
                            <td>{{ $plant->age ?? 'N/A' }}</td>
                            <td>{{ $plant->location ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Aucune plante trouvée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{-- Pagination Laravel --}}
            {{ $plants->links() }}
        </div>
    </div>
</div>
