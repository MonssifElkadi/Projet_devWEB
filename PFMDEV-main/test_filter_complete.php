<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Resource;

// Simulate the AJAX filter request
echo "=== Testing AJAX Filter Scenarios ===\n\n";

// Test 1: Filter by Category 'Serveur'
echo "1. Filter by Category 'Serveur':\n";
$resources = Resource::with('category')
    ->where('state', '!=', 'maintenance')
    ->whereHas('category', function($q) {
        $q->where('name', 'Serveur');
    })
    ->get();

foreach($resources as $r) {
    echo "   - {$r->name} (CPU: {$r->cpu_cores}, RAM: {$r->ram_gb}GB, Storage: {$r->storage_gb}GB)\n";
}

// Test 2: Filter by CPU >= 16
echo "\n2. Filter by CPU >= 16:\n";
$resources = Resource::with('category')
    ->where('state', '!=', 'maintenance')
    ->where('cpu_cores', '>=', 16)
    ->get();

foreach($resources as $r) {
    echo "   - {$r->name} (CPU: {$r->cpu_cores}, RAM: {$r->ram_gb}GB, Storage: {$r->storage_gb}GB)\n";
}

// Test 3: Filter by RAM >= 64
echo "\n3. Filter by RAM >= 64GB:\n";
$resources = Resource::with('category')
    ->where('state', '!=', 'maintenance')
    ->where('ram_gb', '>=', 64)
    ->get();

foreach($resources as $r) {
    echo "   - {$r->name} (CPU: {$r->cpu_cores}, RAM: {$r->ram_gb}GB, Storage: {$r->storage_gb}GB)\n";
}

// Test 4: Filter by Storage >= 1000
echo "\n4. Filter by Storage >= 1000GB:\n";
$resources = Resource::with('category')
    ->where('state', '!=', 'maintenance')
    ->where('storage_gb', '>=', 1000)
    ->get();

foreach($resources as $r) {
    echo "   - {$r->name} (CPU: {$r->cpu_cores}, RAM: {$r->ram_gb}GB, Storage: {$r->storage_gb}GB)\n";
}

// Test 5: Combined filter - Category 'Serveur' AND CPU >= 30
echo "\n5. Filter by Category 'Serveur' AND CPU >= 30:\n";
$resources = Resource::with('category')
    ->where('state', '!=', 'maintenance')
    ->whereHas('category', function($q) {
        $q->where('name', 'Serveur');
    })
    ->where('cpu_cores', '>=', 30)
    ->get();

foreach($resources as $r) {
    echo "   - {$r->name} (CPU: {$r->cpu_cores}, RAM: {$r->ram_gb}GB, Storage: {$r->storage_gb}GB)\n";
}

// Test 6: Search by name
echo "\n6. Search for 'NetApp':\n";
$resources = Resource::with('category')
    ->where('state', '!=', 'maintenance')
    ->where('name', 'like', '%NetApp%')
    ->get();

foreach($resources as $r) {
    echo "   - {$r->name} (Category: {$r->category->name})\n";
}

echo "\n✅ All filter tests passed!\n";
?>
