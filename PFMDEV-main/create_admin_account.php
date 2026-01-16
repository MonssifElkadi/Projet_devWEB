<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Création du compte admin@datacenter.com...\n\n";

// Vérifier s'il existe
$existing = User::where('email', 'admin@datacenter.com')->first();
if ($existing) {
    echo "✓ Compte déjà existe\n";
} else {
    User::create([
        'name' => 'Admin Principal',
        'email' => 'admin@datacenter.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
        'is_active' => true,
    ]);
    echo "✓ Compte créé avec succès!\n";
}

echo "\nComptes maintenant disponibles:\n";
User::all()->each(function($u) {
    echo "  - {$u->email} ({$u->role})\n";
});
?>
