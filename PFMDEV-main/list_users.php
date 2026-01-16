<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== LISTE COMPLÈTE DES UTILISATEURS ===\n\n";

$users = User::all();

if ($users->isEmpty()) {
    echo "❌ Aucun utilisateur trouvé!\n";
} else {
    echo "Total: " . $users->count() . " utilisateur(s)\n\n";
    
    foreach ($users as $index => $user) {
        echo ($index + 1) . ". " . str_repeat("=", 60) . "\n";
        echo "   Nom: {$user->name}\n";
        echo "   Email: {$user->email}\n";
        echo "   Rôle: {$user->role}\n";
        echo "   Actif: " . ($user->is_active ? "✓ OUI" : "✗ NON") . "\n";
        echo "   Hash: " . substr($user->password, 0, 30) . "...\n";
    }
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "\n📝 NOTE: Les mots de passe ci-dessus sont HASHÉS (non lisibles)\n";
    echo "Les mots de passe en clair pour tester sont:\n\n";
    
    echo "1. admin@admin.com → admin123\n";
    echo "2. manager@manager.com → manager123\n";
    echo "3. internal@internal.com → internal123\n";
    echo "4. guest@guest.com → guest123\n";
    echo "5. admin@datacenter.com → password\n";
}

echo "\n";
?>
