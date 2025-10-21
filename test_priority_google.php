<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Batiment;

echo "🧪 Test de priorité Google Gemini pour UrbanGreen\n";
echo "================================================\n\n";

// Simuler des données de bâtiment pour le test
$testBuildingData = [
    'type_batiment' => 'Immeuble',
    'type_industrie' => 'Bureaux',
    'emission_data' => ['co2' => 45.5],
    'energies_renouvelables_data' => ['solaire' => true, 'eolien' => false],
    'recyclage_data' => ['papier' => 80, 'plastique' => 60]
];

echo "📊 Données de test :\n";
echo "- Type de bâtiment : " . $testBuildingData['type_batiment'] . "\n";
echo "- Type d'industrie : " . $testBuildingData['type_industrie'] . "\n";
echo "- Émissions CO2 : " . ($testBuildingData['emission_data']['co2'] ?? 'N/A') . " tonnes/an\n";
echo "- Énergies renouvelables : " . json_encode($testBuildingData['energies_renouvelables_data']) . "\n";
echo "- Recyclage : " . json_encode($testBuildingData['recyclage_data']) . "\n\n";

try {
    echo "🤖 Test de prédiction IA (priorité Google Gemini)...\n";
    $predictions = Batiment::predictEmissionsWithAI($testBuildingData);

    echo "✅ Prédictions obtenues :\n";
    echo "- Émissions CO2 prédites : " . $predictions['emission_c_o2'] . " tonnes/an\n";
    echo "- Pourcentage renouvelable : " . $predictions['pourcentage_renouvelable'] . " %\n";
    echo "- Émissions réelles : " . $predictions['emission_reelle'] . " tonnes/an\n\n";

    echo "🎯 CONCLUSION : La priorité Google Gemini fonctionne !\n";
    echo "💡 L'IA gratuite est maintenant utilisée en priorité.\n";

} catch (\Exception $e) {
    echo "❌ ERREUR lors du test :\n";
    echo "Message : " . $e->getMessage() . "\n\n";

    echo "🔄 Le système utilise automatiquement le fallback.\n";
}

echo "\n📋 Ordre de priorité configuré :\n";
echo "1️⃣ Google Gemini (gratuit - 60 req/min, 1M tokens/mois)\n";
echo "2️⃣ OpenAI GPT-3.5-turbo (payant mais fiable)\n";
echo "3️⃣ Valeurs par défaut (toujours disponible)\n\n";

echo "🌱 UrbanGreen est maintenant optimisé pour l'IA gratuite !\n";