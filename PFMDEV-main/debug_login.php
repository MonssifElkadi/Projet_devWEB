<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== Users in Database ===\n";
$users = User::all();
if ($users->isEmpty()) {
    echo "❌ NO USERS FOUND!\n";
} else {
    foreach($users as $u) {
        echo "ID: {$u->id}, Name: {$u->name}, Email: {$u->email}, Role: {$u->role}, Active: " . ($u->is_active ? 'Yes' : 'No') . "\n";
    }
}

echo "\n=== Testing Login ===\n";
// Test avec admin@admin.com
$email = 'admin@admin.com';
$password = 'admin123';
$user = User::where('email', $email)->first();

if ($user) {
    echo "✓ User found: {$user->name}\n";
    echo "  - Email: {$user->email}\n";
    echo "  - Role: {$user->role}\n";
    echo "  - Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
    
    // Test password hash
    if (Hash::check($password, $user->password)) {
        echo "✓ Password verification: SUCCESS\n";
    } else {
        echo "❌ Password verification: FAILED\n";
        echo "   Password: {$password}\n";
        echo "   Hash: {$user->password}\n";
    }
} else {
    echo "❌ User not found: {$email}\n";
}
?>
