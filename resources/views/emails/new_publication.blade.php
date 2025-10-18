<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Publication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background-color: #4e73df;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-size: 12px;
        }
        .publication-title {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 10px;
        }
        .publication-description {
            color: #555555;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background-color: #1cc88a;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>UrbanGreen</h1>
            <p>Nouvelle Publication Ajoutée</p>
        </div>
        <div class="content">
            <h2 class="publication-title">{{ $publication->titre }}</h2>
            <p class="publication-description">{{ $publication->description }}</p>
            <p><strong>Date de publication :</strong> {{ $publication->created_at->format('d/m/Y H:i') }}</p>
            <a href="{{ route('publications.index') }}" class="btn">Voir la Publication</a>
        </div>
        <div class="footer">
            <p>Vous recevez cet email car vous êtes inscrit sur UrbanGreen.</p>
            <p>&copy; 2025 UrbanGreen. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
