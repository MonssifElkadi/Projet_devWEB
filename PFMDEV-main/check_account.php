<?php
// Vérifier le compte admin@datacenter.com
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

echo "=== VÉRIFICATION COMPTE admin@datacenter.com ===\n\n";

// Chercher le compte
$user = User::where('email', 'admin@datacenter.com')->first();

if (!$user) {
    echo "❌ COMPTE NON TROUVÉ!\n\n";
    echo "Comptes existants:\n";
    User::all()->each(function($u) {
        echo "  - {$u->email} (rôle: {$u->role}, actif: " . ($u->is_active ? 'OUI' : 'NON') . ")\n";
    });
} else {
    echo "✓ Compte trouvé:\n";
    echo "  Email: {$user->email}\n";
    echo "  Nom: {$user->name}\n";
    echo "  Rôle: {$user->role}\n";
    echo "  Actif: " . ($user->is_active ? 'OUI' : 'NON') . "\n";
    echo "  Hash (premiers 30 chars): " . substr($user->password, 0, 30) . "...\n\n";
    
    // Tester le mot de passe
    echo "Test de vérification du mot de passe 'password':\n";
    $match = Hash::check('password', $user->password);
    echo "  Résultat: " . ($match ? "✓ CORRECT" : "❌ INCORRECT") . "\n\n";
    
    // Tester la connexion
    echo "Test Auth::attempt():\n";
    $result = Auth::attempt(['email' => 'admin@datacenter.com', 'password' => 'password']);
    echo "  Résultat: " . ($result ? "✓ SUCCÈS" : "❌ ÉCHOUÉ") . "\n";
    
    if ($result) {
        Auth::logout();
    }
}

// Vérifier la configuration de session
echo "\n=== CONFIGURATION SESSION ===\n";
echo "Driver: " . config('session.driver') . "\n";
echo "Table: " . config('session.table') . "\n";
echo "Encrypt: " . (config('session.encrypt') ? 'OUI' : 'NON') . "\n";
?>
