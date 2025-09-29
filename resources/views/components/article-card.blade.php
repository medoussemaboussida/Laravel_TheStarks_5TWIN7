@props(['title', 'author'])

<div class="p-4 border rounded-lg shadow mb-4 bg-white">
    <h2 class="text-xl font-bold text-blue-600">{{ $title }}</h2>
    <p class="text-gray-600">Auteur : {{ $author }}</p>
    <div class="mt-2 text-gray-800">
        {{ $slot }}
    </div>
</div>
