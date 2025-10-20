<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\Batiment;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo "Test de l'accesseur energies_renouvelables_data\n\n";

// Tester avec un bâtiment existant
$batiment = Batiment::find(87);
if ($batiment) {
    echo "Bâtiment trouvé: {$batiment->type_batiment}\n";
    echo "energies_renouvelables_data (brut): " . var_export($batiment->getAttributes()['energies_renouvelables_data'], true) . "\n";
    echo "energies_renouvelables_data (accesseur): " . var_export($batiment->energies_renouvelables_data, true) . "\n";
    echo "Type de retour: " . gettype($batiment->energies_renouvelables_data) . "\n";

    // Tester si c'est itérable
    $data = $batiment->energies_renouvelables_data;
    if (is_array($data)) {
        echo "✅ C'est un tableau, peut être utilisé dans foreach\n";
        echo "Nombre d'éléments: " . count($data) . "\n";
        foreach ($data as $key => $value) {
            echo "  - $key: $value\n";
        }
    } else {
        echo "❌ Ce n'est pas un tableau\n";
    }
} else {
    echo "Bâtiment avec ID 87 non trouvé\n";
}