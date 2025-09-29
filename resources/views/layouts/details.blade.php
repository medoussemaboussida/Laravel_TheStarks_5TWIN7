<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Détails de la publication</title>
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}">
</head>
<body style="background: #f8f9fa;">
<header class="header shadow-sm bg-white py-2 mb-4">
  <div class="container d-flex align-items-center justify-content-between">
    <a href="/" class="logo d-flex align-items-center gap-2 text-decoration-none">
      <img src="{{ asset('img/undraw_rocket.svg') }}" alt="Logo" style="height: 38px;">
      <span class="fw-bold fs-4 text-primary">UrbanGreen</span>
    </a>
    <a class="btn btn-primary rounded-pill px-4 shadow-sm" href="/">Accueil</a>
  </div>
</header>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg border-0 rounded-4 overflow-hidden details-glass">
        <div class="position-relative details-img-wrapper">
          <img src="{{ $publication->image ? asset('storage/' . $publication->image) : asset('img/undraw_posting_photo.svg') }}" class="w-100" alt="{{ $publication->titre }}" style="height:340px;object-fit:cover;">
          <span class="badge details-date-badge position-absolute top-0 end-0 m-3 px-4 py-2 shadow">{{ $publication->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="card-body p-5">
          <h1 class="display-5 fw-bold mb-3 gradient-text">{{ $publication->titre }}</h1>
          <div class="d-flex align-items-center mb-4 gap-3">
            <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Auteur" class="rounded-circle border border-2 border-success" width="48" height="48">
            <span class="text-muted fs-5">Par <b>{{ $publication->user->name ?? 'Admin' }}</b></span>
          </div>
          <p class="lead text-dark mb-4" style="font-size:1.25rem;">{{ $publication->description }}</p>
          <a href="{{ url()->previous() }}" class="btn btn-outline-primary rounded-pill px-4 mt-3"><i class="bi bi-arrow-left"></i> Retour</a>

        <!-- Section Commentaires -->
        <div class="container mt-5">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                  <h3 class="mb-4 gradient-text">Commentaires</h3>
                  <!-- Formulaire d'ajout de commentaire (si connecté) -->
                  @if(auth()->check())
                    <form action="{{ route('publications.comment', $publication->id) }}" method="POST" class="mb-4">
                      @csrf
                      <div class="mb-3">
                        <textarea name="content" class="form-control" rows="3" placeholder="Votre commentaire..." required></textarea>
                        @error('content')
                          <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                      </div>
                      <button type="submit" class="btn btn-success rounded-pill px-4">Commenter</button>
                    </form>
                  @else
                    <div class="alert alert-info">Vous devez être <a href="/login">connecté</a> pour commenter.</div>
                  @endif

                  <!-- Liste des commentaires -->
                  @if($publication->comments->count())
                    @foreach($publication->comments->sortByDesc('created_at') as $comment)
                      <div class="d-flex mb-3 align-items-start">
                        <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Avatar" class="rounded-circle me-3" width="40" height="40">
                        <div class="flex-grow-1">
                          <div class="fw-bold">{{ $comment->user->name ?? 'Utilisateur' }} <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span></div>
                          <div>{{ $comment->content }}</div>
                        </div>
                        @if(auth()->check() && auth()->id() === $comment->user_id)
                          <!-- Formulaire d'édition inline -->
                          <button class="btn btn-sm btn-outline-primary me-1" type="button" onclick="toggleEditForm({{ $comment->id }})" title="Modifier"><i class="bi bi-pencil"></i></button>
                          <form action="{{ route('commentaires.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"><i class="bi bi-trash"></i></button>
                          </form>
                        @endif
                      </div>
                      @if(auth()->check() && auth()->id() === $comment->user_id)
                        <form action="{{ route('commentaires.update', $comment->id) }}" method="POST" id="edit-form-{{ $comment->id }}" class="mb-2" style="display:none;">
                          @csrf
                          @method('PATCH')
                          <div class="input-group">
                            <textarea name="content" class="form-control" rows="2" required>{{ $comment->content }}</textarea>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                            <button type="button" class="btn btn-secondary" onclick="toggleEditForm({{ $comment->id }})">Annuler</button>
                          </div>
                        </form>
                      @endif
                    @endforeach
                  @else
                    <div class="text-muted">Aucun commentaire pour le moment.</div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.details-glass {
  background: rgba(255,255,255,0.85);
  backdrop-filter: blur(10px) saturate(1.2);
  box-shadow: 0 8px 32px rgba(76,175,80,0.10), 0 1.5px 8px rgba(78,115,223,0.08);
}
.details-img-wrapper {
  background: linear-gradient(120deg,#e3ffe6 0%,#e0f7fa 100%);
  border-top-left-radius: 2rem;
  border-top-right-radius: 2rem;
  overflow: hidden;
}
.details-date-badge {
  background: linear-gradient(90deg,#1cc88a 0%,#4e73df 100%)!important;
  color: #fff;
  border-radius: 1rem;
  font-weight: 500;
  letter-spacing: 0.02em;
  box-shadow: 0 2px 8px rgba(44,62,80,0.08);
  z-index: 3;
  font-size: 1.1rem;
}
.gradient-text {
  background: linear-gradient(90deg,#1cc88a 0%,#4e73df 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
</style>
</style>
<script>
function toggleEditForm(commentId) {
  var form = document.getElementById('edit-form-' + commentId);
  if (form.style.display === 'none' || form.style.display === '') {
    form.style.display = 'block';
  } else {
    form.style.display = 'none';
  }
}
</script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-icons/bootstrap-icons.js') }}"></script>
</body>
</html>
