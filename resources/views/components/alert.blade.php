@props(['type'])

@php
$classes = match($type) {
    'success' => 'bg-green-100 text-green-800 border border-green-400',
    'error' => 'bg-red-100 text-red-800 border border-red-400',
    'info' => 'bg-blue-100 text-blue-800 border border-blue-400',
    default => 'bg-gray-100 text-gray-800 border border-gray-400',
};
@endphp

<div class="p-3 rounded mb-3 {{ $classes }}">
    {{ $slot }}
</div>
