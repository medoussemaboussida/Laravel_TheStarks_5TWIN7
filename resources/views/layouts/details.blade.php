<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Détails de la publication</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('resources/clientPageAssets/vendor/bootstrap/css/bootstrap.min.css') }}">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   <!-- Vendor CSS Files -->
  @vite([
      'resources/clientPageAssets/vendor/bootstrap/css/bootstrap.min.css',
      'resources/clientPageAssets/vendor/bootstrap-icons/bootstrap-icons.css',
      'resources/clientPageAssets/vendor/glightbox/css/glightbox.min.css',
      'resources/clientPageAssets/vendor/swiper/swiper-bundle.min.css'
  ])
  <!-- Main CSS File -->
  @vite(['resources/clientPageAssets/css/main.css'])
  <style>
    /* Reset et Styles de Base Modernes */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --primary-gradient: linear-gradient(135deg, #3b82f6 0%, #60a5fa 50%, #10b981 100%);
      --secondary-gradient: linear-gradient(135deg, #f0f4f8 0%, #e6ecf2 100%);
      --glass-bg: rgba(255, 255, 255, 0.95);
      --glass-border: 1px solid rgba(255, 255, 255, 0.3);
      --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
      --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
      --shadow-lg: 0 8px 32px rgba(31, 41, 55, 0.15);
      --text-primary: #1f2937;
      --text-secondary: #6b7280;
      --border-radius: 1.25rem;
      --border-radius-sm: 0.75rem;
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
      background: var(--secondary-gradient);
      font-family: 'Inter', sans-serif;
      color: var(--text-primary);
      line-height: 1.7;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* En-tête Raffiné avec Effet de Flottement */
    .header {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(226, 232, 240, 0.5);
      padding: 1rem 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      transition: var(--transition);
    }

    .header.scrolled {
      box-shadow: var(--shadow-md);
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      text-decoration: none;
      transition: var(--transition);
    }

    .logo:hover {
      transform: translateY(-1px);
    }

    .logo img {
      height: 42px;
      filter: drop-shadow(0 2px 4px rgba(59, 130, 246, 0.2));
      transition: var(--transition);
    }

    .logo img:hover {
      transform: scale(1.05);
    }

    .logo span {
      font-size: 1.875rem;
      font-weight: 800;
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.025em;
    }

    /* Boutons Modernes avec Effets Hover Avancés */
    .btn {
      border-radius: 50px;
      font-weight: 600;
      padding: 0.75rem 2rem;
      font-size: 0.95rem;
      border: none;
      position: relative;
      overflow: hidden;
      transition: var(--transition);
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn-primary {
      background: var(--primary-gradient);
      color: #fff;
      box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
      color: #fff;
    }

    .btn-outline-primary {
      border: 2px solid transparent;
      background: rgba(59, 130, 246, 0.1);
      color: #3b82f6;
      backdrop-filter: blur(10px);
    }

    .btn-outline-primary:hover {
      background: var(--primary-gradient);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    .btn-success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #fff;
      box-shadow: var(--shadow-sm);
    }

    .btn-success:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
      color: #fff;
    }

    .btn-secondary {
      background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
      color: #fff;
      box-shadow: var(--shadow-sm);
    }

    .btn-secondary:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
      color: #fff;
    }

    .btn-outline-danger {
      border: 2px solid transparent;
      background: rgba(231, 76, 60, 0.1);
      color: #e3342f;
      backdrop-filter: blur(10px);
    }

    .btn-outline-danger:hover {
      background: linear-gradient(135deg, #e3342f 0%, #dc3545 100%);
      color: #fff;
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    /* Carte Principale avec Glassmorphism Avancé */
    .details-glass {
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      border-radius: var(--border-radius);
      box-shadow: var(--shadow-lg);
      border: var(--glass-border);
      overflow: hidden;
      transition: var(--transition);
      max-width: 900px;
      margin: 0 auto 2rem auto;
      position: relative;
    }

    .details-glass::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 1px;
      background: var(--primary-gradient);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .details-glass:hover::before {
      opacity: 1;
    }

    .details-glass:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .details-img-wrapper {
      position: relative;
      overflow: hidden;
      aspect-ratio: 16/9;
    }

    .details-img-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: var(--transition);
      filter: brightness(0.95) contrast(1.05);
    }

    .details-img-wrapper:hover img {
      transform: scale(1.05);
      filter: brightness(1) contrast(1.1);
    }

    .details-date-badge {
      background: var(--primary-gradient);
      color: #fff;
      border-radius: var(--border-radius-sm);
      padding: 0.625rem 1.5rem;
      font-weight: 600;
      font-size: 0.95rem;
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      box-shadow: var(--shadow-md);
      z-index: 10;
      letter-spacing: 0.025em;
      transform: translateY(0);
      transition: var(--transition);
    }

    .details-glass:hover .details-date-badge {
      transform: translateY(-4px);
    }

    /* Typographie Améliorée */
    .gradient-text {
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 800;
      letter-spacing: -0.025em;
    }

    .card-body {
      padding: 2.5rem;
    }

    .card-body h1 {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      line-height: 1.2;
    }

    .card-body .lead {
      font-size: 1.125rem;
      color: var(--text-secondary);
      line-height: 1.8;
      font-weight: 400;
    }

    /* Icônes Raffinées */
    .bi {
      font-size: 1.2rem;
      vertical-align: middle;
      color: #3b82f6;
      transition: var(--transition);
    }

    .btn:hover .bi {
      transform: scale(1.1);
    }

    .btn-outline-danger .bi {
      color: #e3342f;
    }

    /* Section Commentaires Ultra-Moderne */
    .comment-section {
      background: rgba(248, 250, 252, 0.8);
      backdrop-filter: blur(10px);
      border-radius: var(--border-radius);
      padding: 2rem;
      margin-top: 3rem;
      border: var(--glass-border);
      box-shadow: var(--shadow-sm);
    }

    .comment-section h3 {
      font-size: 1.75rem;
      margin-bottom: 2rem;
      text-align: center;
    }

    /* Formulaire de Commentaire Élégant */
    .comment-form {
      background: var(--glass-bg);
      backdrop-filter: blur(20px);
      border-radius: var(--border-radius);
      padding: 2rem;
      border: var(--glass-border);
      box-shadow: var(--shadow-md);
      margin-bottom: 2rem;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .comment-form::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--primary-gradient);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .comment-form:focus-within::before,
    .comment-form:hover::before {
      transform: scaleX(1);
    }

    .comment-form .avatar-section {
      display: flex;
      align-items: flex-start;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .comment-form .avatar-section img {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      border: 3px solid transparent;
      background: var(--primary-gradient);
      padding: 2px;
      flex-shrink: 0;
      transition: var(--transition);
    }

    .comment-form .avatar-section img:hover {
      transform: scale(1.05);
    }

    .comment-form textarea {
      border-radius: var(--border-radius-sm);
      border: 2px solid rgba(59, 130, 246, 0.1);
      padding: 1.25rem;
      min-height: 140px;
      resize: vertical;
      font-family: 'Inter', sans-serif;
      font-size: 1rem;
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
      transition: var(--transition);
      box-shadow: var(--shadow-sm);
      line-height: 1.6;
    }

    .comment-form textarea:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), var(--shadow-md);
      outline: none;
      transform: translateY(-2px);
      background: rgba(255, 255, 255, 0.95);
    }

    .comment-form textarea::placeholder {
      color: var(--text-secondary);
      font-weight: 400;
      letter-spacing: 0.025em;
    }

    .comment-form .form-actions {
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 1rem;
      margin-top: 1.25rem;
    }

    /* Cartes de Commentaires Fluides */
    .comment-card {
      background: var(--glass-bg);
      backdrop-filter: blur(15px);
      border-radius: var(--border-radius);
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      border: var(--glass-border);
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .comment-card::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: rgba(59, 130, 246, 0.2);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }

    .comment-card:hover::after {
      transform: scaleX(1);
    }

    .comment-card:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }

    .comment-card .avatar {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      border: 2px solid #10b981;
      flex-shrink: 0;
    }

    .comment-card .author {
      font-weight: 700;
      color: var(--text-primary);
      font-size: 1.05rem;
      display: block;
    }

    .comment-card .date {
      color: var(--text-secondary);
      font-size: 0.875rem;
      margin-left: 0.5rem;
    }

    .comment-card .content {
      margin-top: 0.75rem;
      font-size: 1rem;
      line-height: 1.7;
      color: var(--text-primary);
    }

    /* Actions des Commentaires Raffinées */
    .comment-actions {
      display: flex;
      gap: 0.5rem;
      align-items: center;
      margin-left: auto;
      opacity: 0;
      transition: opacity 0.2s ease;
    }

    .comment-card:hover .comment-actions {
      opacity: 1;
    }

    .comment-actions .btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0;
      font-size: 1rem;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
    }

    .comment-actions .btn:hover {
      transform: scale(1.1) rotate(5deg);
      box-shadow: var(--shadow-md);
    }

    /* Formulaire d'Édition Inline */
    .edit-form {
      background: rgba(248, 250, 252, 0.9);
      backdrop-filter: blur(10px);
      border-radius: var(--border-radius-sm);
      padding: 1rem;
      margin-top: 1rem;
      border: 1px solid rgba(59, 130, 246, 0.2);
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
    }

    .edit-form textarea {
      border-radius: 0.625rem;
      border: 1px solid rgba(59, 130, 246, 0.2);
      padding: 0.875rem;
      min-height: 80px;
      font-family: 'Inter', sans-serif;
      transition: var(--transition);
    }

    .edit-form textarea:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .edit-form .input-group {
      gap: 0.5rem;
    }

    .edit-form .btn {
      padding: 0.5rem 1.25rem;
      font-size: 0.9rem;
    }

    /* Alertes et États */
    .alert {
      border-radius: var(--border-radius-sm);
      border: none;
      box-shadow: var(--shadow-sm);
      font-weight: 500;
    }

    .text-muted {
      color: var(--text-secondary) !important;
    }

    /* Design Responsive Avancé */
    @media (max-width: 992px) {
      .card-body {
        padding: 2rem 1.5rem;
      }

      .details-img-wrapper {
        aspect-ratio: 4/3;
      }
    }

    @media (max-width: 768px) {
      .details-glass {
        border-radius: var(--border-radius-sm);
        margin: 0 1rem 2rem;
      }

      .details-img-wrapper img {
        height: 250px;
      }

      .card-body {
        padding: 1.75rem 1.25rem;
      }

      .card-body h1 {
        font-size: 2rem;
      }

      .comment-section {
        padding: 1.5rem;
        margin-top: 2rem;
      }

      .comment-form {
        padding: 1.5rem;
      }

      .comment-form .avatar-section {
        gap: 0.75rem;
      }

      .comment-form .avatar-section img {
        width: 44px;
        height: 44px;
      }

      .comment-form textarea {
        min-height: 110px;
        padding: 1rem;
      }

      .comment-form .form-actions {
        flex-direction: column;
        gap: 0.75rem;
      }

      .comment-form .btn {
        width: 100%;
        justify-content: center;
      }

      .logo span {
        font-size: 1.625rem;
      }

      .btn {
        padding: 0.625rem 1.5rem;
        font-size: 0.9rem;
      }

      .comment-actions .btn {
        width: 36px;
        height: 36px;
      }
    }

    @media (max-width: 576px) {
      .details-img-wrapper img {
        height: 200px;
      }

      .card-body h1 {
        font-size: 1.75rem;
      }

      .comment-form textarea,
      .comment-card textarea {
        min-height: 90px;
      }

      .details-date-badge {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        top: 1rem;
        right: 1rem;
      }

      .comment-form {
        padding: 1.25rem;
      }

      .comment-card {
        padding: 1.25rem;
      }

      .header .container {
        padding: 0 1rem;
      }
    }

    /* Animations Subtiles pour l'Entrée */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .details-glass,
    .comment-form,
    .comment-card {
      animation: fadeInUp 0.6s ease forwards;
    }

    .comment-card:nth-child(even) {
      animation-delay: 0.1s;
    }

    .comment-card:nth-child(odd) {
      animation-delay: 0.2s;
    }
  </style>
</head>
<body>
<header class="header" id="header">
  <!-- Navbar -->
        @include('client_page.partials.navbar')

        <!-- Main Content Wrapper -->
</header>
<div class="container py-5">

  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow-lg border-0 rounded-4 overflow-hidden details-glass mx-auto">
        <div class="position-relative details-img-wrapper">
          <img src="{{ $publication->image ? asset('storage/' . $publication->image) : asset('img/undraw_posting_photo.svg') }}" class="w-100" alt="{{ $publication->titre }}">
          <span class="badge details-date-badge position-absolute top-0 end-0 m-3 px-4 py-2 shadow">{{ $publication->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="card-body">
          <h1 class="display-5 fw-bold mb-3 gradient-text">{{ $publication->titre }}</h1>
          <div class="d-flex align-items-center mb-4 gap-3">
            <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Auteur" class="rounded-circle border border-3 border-success" width="52" height="52">
            <span class="text-muted fs-5">Par <b>{{ $publication->user->name ?? 'Admin' }}</b></span>
          </div>
          <p class="lead text-dark mb-4">{{ $publication->description }}</p>

          <!-- Like/Dislike Section -->
          @if(auth()->check())
            <div class="d-flex align-items-center gap-3 mb-4">
              <button id="like-btn" class="btn {{ $publication->hasUserLiked(auth()->id()) ? 'btn-success' : 'btn-outline-success' }} rounded-pill px-3" onclick="toggleLike({{ $publication->id }})">
                <i class="bi bi-hand-thumbs-up me-1"></i> Like <span id="likes-count">{{ $publication->getLikesCount() }}</span>
              </button>
              <button id="dislike-btn" class="btn {{ $publication->hasUserDisliked(auth()->id()) ? 'btn-danger' : 'btn-outline-danger' }} rounded-pill px-3" onclick="toggleDislike({{ $publication->id }})">
                <i class="bi bi-hand-thumbs-down me-1"></i> Dislike <span id="dislikes-count">{{ $publication->getDislikesCount() }}</span>
              </button>
            </div>
          @else
            <div class="d-flex align-items-center gap-3 mb-4">
              <button class="btn btn-outline-success rounded-pill px-3" disabled>
                <i class="bi bi-hand-thumbs-up me-1"></i> Like {{ $publication->getLikesCount() }}
              </button>
              <button class="btn btn-outline-danger rounded-pill px-3" disabled>
                <i class="bi bi-hand-thumbs-down me-1"></i> Dislike {{ $publication->getDislikesCount() }}
              </button>
              <small class="text-muted">Connectez-vous pour liker/disliker</small>
            </div>
          @endif

          <a href="{{ route('client.index') }}" class="btn btn-outline-primary rounded-pill px-4 mt-3"><i class="bi bi-arrow-left me-2"></i> Retour</a>

          <!-- Section Commentaires -->
          <div class="comment-section mt-5">
            <h3 class="mb-4 gradient-text">Commentaires</h3>
            <!-- Formulaire d'ajout de commentaire (si connecté) -->
            @if(auth()->check())
              <form action="{{ route('publications.comment', $publication->id) }}" method="POST" class="comment-form">
                @csrf
                <div class="avatar-section">
                  <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Votre avatar" class="rounded-circle">
                  <div class="flex-grow-1">
                    <textarea name="content" class="form-control w-100" rows="3" placeholder="Partagez vos pensées sur cette publication... Soyez constructif et respectueux !" required></textarea>
                    @error('content')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-success"><i class="bi bi-send me-2"></i>Publier</button>
                </div>
              </form>
            @else
              <div class="alert alert-info text-center py-3">Vous devez être <a href="/login" class="text-primary fw-bold">connecté</a> pour commenter.</div>
            @endif

            <!-- Liste des commentaires -->
            @if($publication->comments->count())
              @foreach($publication->comments->sortByDesc('created_at') as $comment)
                <div class="comment-card d-flex align-items-start">
                  <img src="{{ asset('img/undraw_profile_1.svg') }}" alt="Avatar" class="avatar me-3">
                  <div class="flex-grow-1">
                    <div class="d-flex align-items-center">
                      <span class="author">{{ $comment->user->name ?? 'Utilisateur' }}</span>
                      <span class="date">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="content mb-0">{{ $comment->content }}</p>
                  </div>
                  @if(auth()->check() && auth()->id() === $comment->user_id)
                    <!-- Actions côte à côte -->
                    <div class="comment-actions">
                      <button class="btn btn-outline-primary" type="button" onclick="toggleEditForm({{ $comment->id }})" title="Modifier">
                        <i class="bi bi-pencil-fill"></i>
                      </button>
                      <form action="{{ route('commentaires.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?');" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                          <i class="bi bi-trash-fill"></i>
                        </button>
                      </form>
                    </div>
                  @endif
                </div>
                @if(auth()->check() && auth()->id() === $comment->user_id)
                  <form action="{{ route('commentaires.update', $comment->id) }}" method="POST" id="edit-form-{{ $comment->id }}" class="edit-form" style="display:none;">
                    @csrf
                    @method('PATCH')
                    <div class="input-group d-flex flex-column flex-md-row gap-2">
                      <textarea name="content" class="form-control flex-grow-1" rows="2" required>{{ $comment->content }}</textarea>
                      <button type="submit" class="btn btn-success flex-shrink-0">Enregistrer</button>
                      <button type="button" class="btn btn-secondary flex-shrink-0" onclick="toggleEditForm({{ $comment->id }})">Annuler</button>
                    </div>
                  </form>
                @endif
              @endforeach
            @else
              <div class="text-center py-4 text-muted">Aucun commentaire pour le moment. Soyez le premier à réagir !</div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function toggleEditForm(commentId) {
  var form = document.getElementById('edit-form-' + commentId);
  form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Function to toggle like
function toggleLike(publicationId) {
  fetch(`/publications/${publicationId}/like`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({})
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      alert(data.error);
      return;
    }
    document.getElementById('likes-count').textContent = data.likes_count;
    document.getElementById('dislikes-count').textContent = data.dislikes_count;
    updateButtonStates(data.user_liked, data.user_disliked);
  })
  .catch(error => console.error('Error:', error));
}

// Function to toggle dislike
function toggleDislike(publicationId) {
  fetch(`/publications/${publicationId}/dislike`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({})
  })
  .then(response => response.json())
  .then(data => {
    if (data.error) {
      alert(data.error);
      return;
    }
    document.getElementById('likes-count').textContent = data.likes_count;
    document.getElementById('dislikes-count').textContent = data.dislikes_count;
    updateButtonStates(data.user_liked, data.user_disliked);
  })
  .catch(error => console.error('Error:', error));
}

// Function to update button states
function updateButtonStates(userLiked, userDisliked) {
  const likeBtn = document.getElementById('like-btn');
  const dislikeBtn = document.getElementById('dislike-btn');

  if (userLiked) {
    likeBtn.classList.remove('btn-outline-success');
    likeBtn.classList.add('btn-success');
  } else {
    likeBtn.classList.remove('btn-success');
    likeBtn.classList.add('btn-outline-success');
  }

  if (userDisliked) {
    dislikeBtn.classList.remove('btn-outline-danger');
    dislikeBtn.classList.add('btn-danger');
  } else {
    dislikeBtn.classList.remove('btn-danger');
    dislikeBtn.classList.add('btn-outline-danger');
  }
}

// Effet de scroll pour l'en-tête
window.addEventListener('scroll', function() {
  const header = document.getElementById('header');
  header.classList.toggle('scrolled', window.scrollY > 50);
});
</script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>