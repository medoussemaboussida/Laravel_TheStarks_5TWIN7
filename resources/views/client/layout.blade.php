<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Client')</title>

    <!-- Exemple : styles du template client -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/style.css') }}">
    <!-- si besoin, bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/client/vendor/bootstrap/css/bootstrap.min.css') }}">
    <style>
        /* petits ajustements si nécessaire */
        .client-container { padding: 2rem; }
    </style>
    @stack('head')
</head>
<body>

    <!-- header / nav du template client si tu en as -->
    @includeIf('client.partials.header')

    <main class="client-container">
        @yield('content')
    </main>

    <!-- footer -->
    @includeIf('client.partials.footer')

    <!-- scripts -->
    <script src="{{ asset('assets/client/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/client/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/app.js') }}"></script>

    @stack('scripts')
</body>
</html>
