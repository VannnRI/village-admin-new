<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Village;

echo "Updating villages data:\n";

// Update existing villages
$villages = Village::whereNull('district')->orWhereNull('regency')->get();

foreach ($villages as $village) {
    if ($village->name === 'Warungering') {
        $village->update([
            'district' => 'Kedungpring',
            'regency' => 'Lamongan'
        ]);
        echo "Updated village: {$village->name}\n";
    } elseif ($village->name === 'Kalen') {
        $village->update([
            'district' => 'Kedungpring',
            'regency' => 'Lamongan'
        ]);
        echo "Updated village: {$village->name}\n";
    }
}

echo "Update completed!\n"; 