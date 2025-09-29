@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <h1>Admin Publications</h1>
        <!-- Affichage des publications -->
        @if(isset($publications) && count($publications))
            <ul>
                @foreach($publications as $publication)
                    <li>
                        <strong>{{ $publication->titre }}</strong><br>
                        <img src="{{ $publication->image ? asset('storage/' . $publication->image) : asset('img/logo.webp') }}" alt="Image" style="max-width:150px;"><br>
                        {{ $publication->description }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucune publication trouvée.</p>
        @endif
    </div>
@endsection
