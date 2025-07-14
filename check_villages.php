<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Village;

echo "Checking villages data:\n";
$villages = Village::all();

foreach ($villages as $village) {
    echo "ID: {$village->id}\n";
    echo "Name: {$village->name}\n";
    echo "District: {$village->district}\n";
    echo "Regency: {$village->regency}\n";
    echo "---\n";
} 