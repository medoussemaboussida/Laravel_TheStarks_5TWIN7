<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-3xl font-bold mb-6">Liste des Articles</h1>

    <!-- Messages d'alerte -->
    <x-alert type="success">Opération effectuée avec succès !</x-alert>
    <x-alert type="error">Une erreur est survenue.</x-alert>
    <x-alert type="info">Ceci est une information importante.</x-alert>

    <!-- Liste des articles -->
    @foreach($articles as $article)
        <x-article-card :title="$article['title']" :author="$article['author']">
            {{ $article['content'] }}
        </x-article-card>
    @endforeach

</body>
</html>
