<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport des Bâtiments UrbanGreen</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #28a745;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }

        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        .header .date {
            color: #999;
            font-size: 10px;
            margin-top: 10px;
        }

        .stats-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #28a745;
        }

        .stats-title {
            font-size: 16px;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .stats-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .stats-row {
            display: table-row;
        }

        .stats-cell {
            display: table-cell;
            padding: 8px 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .stats-label {
            font-weight: bold;
            color: #495057;
            width: 200px;
        }

        .stats-value {
            color: #28a745;
            font-weight: bold;
            text-align: right;
        }

        .batiment-section {
            margin-bottom: 40px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }

        .batiment-header {
            background-color: #28a745;
            color: white;
            padding: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        .batiment-content {
            padding: 20px;
        }

        .batiment-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .info-row {
            display: table-row;
        }

        .info-cell {
            display: table-cell;
            padding: 5px 10px;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-label {
            font-weight: bold;
            color: #495057;
            width: 150px;
        }

        .info-value {
            color: #333;
        }

        .metrics-section {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .metrics-title {
            font-size: 14px;
            font-weight: bold;
            color: #495057;
            margin-bottom: 10px;
        }

        .metrics-grid {
            display: table;
            width: 100%;
        }

        .metrics-row {
            display: table-row;
        }

        .metrics-cell {
            display: table-cell;
            padding: 5px 10px;
            text-align: center;
        }

        .metric-label {
            font-size: 11px;
            color: #666;
        }

        .metric-value {
            font-size: 14px;
            font-weight: bold;
            color: #28a745;
        }

        .recommendations-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border-left: 4px solid #17a2b8;
        }

        .recommendations-title {
            font-size: 14px;
            font-weight: bold;
            color: #17a2b8;
            margin-bottom: 10px;
        }

        .recommendation-item {
            margin-bottom: 8px;
            padding-left: 15px;
            position: relative;
            font-size: 11px;
            line-height: 1.3;
        }

        .recommendation-item:before {
            content: "•";
            color: #17a2b8;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            color: #666;
            font-size: 10px;
        }

        .page-break {
            page-break-before: always;
        }

        .no-data {
            color: #dc3545;
            font-style: italic;
            text-align: center;
            padding: 20px;
        }

        .source-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 8px;
            margin-top: 10px;
            font-size: 10px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏢 UrbanGreen - Rapport des Bâtiments</h1>
        <div class="subtitle">Analyse environnementale et recommandations IA</div>
        <div class="date">Généré le {{ date('d/m/Y à H:i:s') }}</div>
    </div>

    <div class="stats-section">
        <div class="stats-title">📊 Statistiques Globales</div>
        <div class="stats-grid">
            <div class="stats-row">
                <div class="stats-cell stats-label">Nombre total de bâtiments</div>
                <div class="stats-cell stats-value">{{ $stats['total_batiments'] }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Émissions CO2 totales (kg/an)</div>
                <div class="stats-cell stats-value">{{ number_format($stats['total_emissions'], 2, ',', ' ') }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Émissions CO2 moyennes (kg/an)</div>
                <div class="stats-cell stats-value">{{ number_format($stats['moyenne_emissions'], 2, ',', ' ') }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Total employés</div>
                <div class="stats-cell stats-value">{{ number_format($stats['total_employes'], 0, ',', ' ') }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Total habitants</div>
                <div class="stats-cell stats-value">{{ number_format($stats['total_habitants'], 0, ',', ' ') }}</div>
            </div>
            <div class="stats-row">
                <div class="stats-cell stats-label">Énergie renouvelable moyenne (%)</div>
                <div class="stats-cell stats-value">{{ number_format($stats['moyenne_renouvelable'], 1, ',', ' ') }}%</div>
            </div>
        </div>
    </div>

    @if($batimentsAvecRecommandations->count() > 0)
        @foreach($batimentsAvecRecommandations as $batiment)
            <div class="batiment-section">
                <div class="batiment-header">
                    Bâtiment #{{ $batiment->id }} - {{ $batiment->type_batiment }}
                </div>
                <div class="batiment-content">
                    <div class="batiment-info">
                        <div class="info-row">
                            <div class="info-cell info-label">Adresse</div>
                            <div class="info-cell info-value">{{ $batiment->adresse }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell info-label">Type de bâtiment</div>
                            <div class="info-cell info-value">{{ $batiment->type_batiment }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell info-label">Zone urbaine</div>
                            <div class="info-cell info-value">{{ $batiment->type_zone_urbaine }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell info-label">Employés</div>
                            <div class="info-cell info-value">{{ $batiment->nb_employes ?? 0 }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell info-label">Habitants</div>
                            <div class="info-cell info-value">{{ $batiment->nb_habitants ?? 0 }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-cell info-label">Industrie</div>
                            <div class="info-cell info-value">{{ $batiment->type_industrie ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="metrics-section">
                        <div class="metrics-title">📈 Métriques Environnementales</div>
                        <div class="metrics-grid">
                            <div class="metrics-row">
                                <div class="metrics-cell">
                                    <div class="metric-label">Émissions CO2</div>
                                    <div class="metric-value">{{ number_format($batiment->emission_c_o2, 2, ',', ' ') }} kg/an</div>
                                </div>
                                <div class="metrics-cell">
                                    <div class="metric-label">Émissions Réelles</div>
                                    <div class="metric-value">{{ number_format($batiment->emission_reelle ?? 0, 2, ',', ' ') }} kg/an</div>
                                </div>
                                <div class="metrics-cell">
                                    <div class="metric-label">Énergie Renouvelable</div>
                                    <div class="metric-value">{{ number_format($batiment->pourcentage_renouvelable, 1, ',', ' ') }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="recommendations-section">
                        <div class="recommendations-title">🤖 Recommandations IA pour la Protection de la Nature</div>
                        @if(isset($batiment->recommandations) && is_array($batiment->recommandations))
                            @foreach($batiment->recommandations as $index => $recommendation)
                                @if(is_array($recommendation))
                                    @if($index < count($batiment->recommandations) - 1)
                                        <div class="recommendation-item">{{ implode(' ', $recommendation) }}</div>
                                    @else
                                        <div class="source-info">Source : {{ $recommendation[0] ?? 'IA Générative' }}</div>
                                    @endif
                                @else
                                    @if($index < count($batiment->recommandations) - 1)
                                        <div class="recommendation-item">{{ $recommendation }}</div>
                                    @else
                                        <div class="source-info">Source : {{ $recommendation }}</div>
                                    @endif
                                @endif
                            @endforeach
                        @else
                            <div class="recommendation-item">Erreur lors de la génération des recommandations</div>
                        @endif
                    </div>
                </div>
            </div>

            @if(!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    @else
        <div class="no-data">
            Aucun bâtiment trouvé dans la base de données.
        </div>
    @endif

    <div class="footer">
        <div>Rapport généré automatiquement par UrbanGreen</div>
        <div>Système de gestion environnementale urbaine - {{ date('Y') }}</div>
    </div>
</body>
</html>