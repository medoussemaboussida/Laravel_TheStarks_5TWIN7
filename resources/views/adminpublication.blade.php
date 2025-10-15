@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <h1>Admin Publications</h1>
        <!-- Affichage des publications -->
        @if(isset($publications) && count($publications))
            <ul>
                @foreach($publications as $publication)
                    <li>
                        <strong>{{ $publication->titre }}</strong>
                        <button class="btn btn-sm btn-outline-info ms-2" onclick="toggleLikesDislikes({{ $publication->id }})">
                            <i class="bi bi-hand-thumbs-up"></i> <i class="bi bi-hand-thumbs-down"></i>
                        </button>
                        <div id="likes-dislikes-{{ $publication->id }}" style="display: none;" class="mt-2">
                            <span class="badge bg-success">{{ $publication->getLikesCount() }} Likes</span>
                            <span class="badge bg-danger">{{ $publication->getDislikesCount() }} Dislikes</span>
                        </div>
                        <br>
                        <img src="{{ $publication->image ? asset('storage/' . $publication->image) : asset('img/logo.webp') }}" alt="Image" style="max-width:150px;"><br>
                        {{ $publication->description }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucune publication trouvée.</p>
        @endif
    </div>

    <script>
        function toggleLikesDislikes(publicationId) {
            const element = document.getElementById('likes-dislikes-' + publicationId);
            if (element.style.display === 'none') {
                element.style.display = 'block';
            } else {
                element.style.display = 'none';
            }
        }
    </script>
@endsection
