<div class="d-flex flex-wrap justify-content-center gap-4" id="publications-list">
    @forelse($publications as $publication)
        <a href="{{ route('publications.show', $publication->id) }}" class="publication-modern-card d-flex flex-column align-items-start text-decoration-none publication-item" style="color:inherit;" data-title="{{ strtolower($publication->titre) }}" data-description="{{ strtolower($publication->description) }}">
            <div class="publication-modern-img position-relative w-100">
                <img src="{{ $publication->image ? asset('storage/' . $publication->image) : asset('img/undraw_posting_photo.svg') }}" alt="{{ $publication->titre }}" class="w-100" style="height: 220px; object-fit: cover; border-radius: 1.25rem 1.25rem 0 0;">
                <span class="badge publication-modern-date position-absolute top-0 end-0 m-2 px-3 py-2 shadow">{{ $publication->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="p-4 w-100 flex-grow-1 d-flex flex-column">
                <h5 class="fw-bold mb-2" style="font-family:'Rubik',sans-serif; color:#222;">{{ $publication->titre }}</h5>
                <p class="text-secondary mb-3 flex-grow-1" style="font-size:1.05rem;">{{ $publication->description }}</p>
                <div class="d-flex align-items-center mt-auto gap-2">
                    <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Auteur" class="rounded-circle border border-2 border-success" width="36" height="36">
                    <span class="text-muted small">Par <b>{{ $publication->user->name ?? 'Admin' }}</b></span>
                </div>
            </div>
        </a>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center py-5">
                <i class="bi bi-info-circle fs-2 mb-2"></i><br>
                Aucune publication trouvée pour le moment.
            </div>
        </div>
    @endforelse
</div>
