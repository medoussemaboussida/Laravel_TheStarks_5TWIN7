<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Batiment;

echo "=== TEST NORMALIZATION ===\n\n";

// Test avec le bâtiment ID 78 qui avait une structure différente
$b = Batiment::find(78);
if ($b) {
    echo "Bâtiment ID: {$b->id}\n";
    echo "Raw data: " . $b->getAttributes()['energies_renouvelables_data'] . "\n";
    echo "Normalized data:\n";
    print_r($b->energies_renouvelables_data);
    echo "Existe: " . ($b->energiesRenouvelablesExiste ? 'true' : 'false') . "\n";
} else {
    echo "Bâtiment 78 non trouvé\n";
}

echo "\n";

// Test avec un bâtiment qui a la bonne structure
$b2 = Batiment::find(95);
if ($b2) {
    echo "Bâtiment ID: {$b2->id}\n";
    echo "Raw data: " . $b2->getAttributes()['energies_renouvelables_data'] . "\n";
    echo "Normalized data:\n";
    print_r($b2->energies_renouvelables_data);
    echo "Existe: " . ($b2->energiesRenouvelablesExiste ? 'true' : 'false') . "\n";
} else {
    echo "Bâtiment 95 non trouvé\n";
}