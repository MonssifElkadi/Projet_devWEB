<?php

require 'bootstrap/app.php';

use Illuminate\Support\Facades\DB;

// Insert the migrations that already exist in the database
$migrations = [
    '2026_01_12_211329_create_resources_table',
    '2026_01_12_211335_create_maintenances_table'
];

foreach ($migrations as $migration) {
    // Check if it already exists
    $exists = DB::table('migrations')->where('migration', $migration)->exists();
    
    if (!$exists) {
        DB::table('migrations')->insert([
            'migration' => $migration,
            'batch' => 1
        ]);
        echo "✓ Marked $migration as completed\n";
    } else {
        echo "✓ $migration already recorded\n";
    }
}

echo "\nNow run: php artisan migrate\n";
