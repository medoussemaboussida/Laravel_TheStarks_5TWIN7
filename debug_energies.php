<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Batiment;

echo "=== DEBUG ÉNERGIES RENOUVELABLES ===\n\n";

// Récupérer tous les bâtiments qui ont des données d'énergies renouvelables
$batiments = Batiment::whereNotNull('energies_renouvelables_data')->get();

if ($batiments->isEmpty()) {
    echo "Aucun bâtiment avec des données d'énergies renouvelables trouvé.\n";
    exit;
}

foreach ($batiments as $batiment) {
    echo "Bâtiment ID: {$batiment->id}\n";
    echo "Adresse: {$batiment->adresse}\n";
    echo "energiesRenouvelablesExiste: " . ($batiment->energiesRenouvelablesExiste ? 'true' : 'false') . "\n";
    echo "energies_renouvelables_data (raw): " . $batiment->getAttributes()['energies_renouvelables_data'] . "\n";
    echo "energies_renouvelables_data (processed): ";
    print_r($batiment->energies_renouvelables_data);
    echo "\n";

    // Vérifier la structure attendue
    $energies = $batiment->energies_renouvelables_data;
    if (is_array($energies)) {
        echo "Structure valide. Types présents:\n";
        $types = ['panneaux_solaires', 'voitures_electriques', 'camions_electriques', 'energie_eolienne', 'energie_hydroelectrique'];
        foreach ($types as $type) {
            if (isset($energies[$type])) {
                $data = $energies[$type];
                if (is_array($data) && isset($data['check']) && isset($data['nb'])) {
                    echo "  - $type: check=" . ($data['check'] ? 'true' : 'false') . ", nb=" . $data['nb'] . "\n";
                } else {
                    echo "  - $type: structure invalide - ";
                    print_r($data);
                    echo "\n";
                }
            }
        }
    } else {
        echo "Structure invalide - pas un tableau\n";
    }

    echo "\n" . str_repeat("-", 50) . "\n\n";
}