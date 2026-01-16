<?php
// Simulate a login test with all credentials
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;

$testCredentials = [
    ['email' => 'admin@admin.com', 'password' => 'admin123', 'desc' => 'Admin'],
    ['email' => 'manager@manager.com', 'password' => 'manager123', 'desc' => 'Manager'],
    ['email' => 'internal@internal.com', 'password' => 'internal123', 'desc' => 'Internal'],
    ['email' => 'guest@guest.com', 'password' => 'guest123', 'desc' => 'Guest'],
    ['email' => 'admin@datacenter.com', 'password' => 'password', 'desc' => 'Admin (Seeder)'],
];

echo "=== LOGIN TEST SIMULATION ===\n\n";

foreach ($testCredentials as $cred) {
    echo "Testing {$cred['desc']} ({$cred['email']}):\n";
    $result = Auth::attempt(['email' => $cred['email'], 'password' => $cred['password']]);
    if ($result) {
        $user = Auth::user();
        echo "  ✓ LOGIN SUCCESS\n";
        echo "    Name: {$user->name}\n";
        echo "    Role: {$user->role}\n";
        echo "    Active: " . ($user->is_active ? 'YES' : 'NO') . "\n";
        Auth::logout();
    } else {
        echo "  ❌ LOGIN FAILED\n";
    }
    echo "\n";
}
?>
