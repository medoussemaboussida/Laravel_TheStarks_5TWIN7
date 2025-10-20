<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Batiment;

$b = Batiment::latest()->first();

echo "Batiment ID: " . $b->id . PHP_EOL;
echo "Raw attribute: ";
var_dump($b->getAttributes()['energies_renouvelables_data']);
echo "Raw data (direct): ";
var_dump($b->energies_renouvelables_data);
echo "Decoded data: ";
var_dump($b->energiesRenouvelablesData);
echo "Existe: " . ($b->energiesRenouvelablesExiste ? 'true' : 'false') . PHP_EOL;

// Chercher un bâtiment qui a des données
$batimentsWithData = Batiment::whereNotNull('energies_renouvelables_data')->get();
echo "Batiments avec données: " . $batimentsWithData->count() . PHP_EOL;
if ($batimentsWithData->count() > 0) {
    $b2 = $batimentsWithData->first();
    echo "Premier bâtiment avec données - ID: " . $b2->id . PHP_EOL;
    echo "Raw attribute: ";
    var_dump($b2->getAttributes()['energies_renouvelables_data']);
    echo "Decoded data: ";
    var_dump($b2->energiesRenouvelablesData);
    echo "Existe: " . ($b2->energiesRenouvelablesExiste ? 'true' : 'false') . PHP_EOL;
}