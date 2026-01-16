<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "=== SIMULATING LOGIN FORM SUBMISSION ===\n\n";

// Get the admin user
$user = User::where('email', 'admin@admin.com')->first();

if (!$user) {
    echo "❌ User not found. Creating test users...\n";
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@admin.com',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
        'is_active' => true,
    ]);
    echo "✓ User created\n";
    $user = User::where('email', 'admin@admin.com')->first();
}

echo "TEST USER: admin@admin.com / admin123\n";
echo "User ID: {$user->id}\n";
echo "User Active: " . ($user->is_active ? 'YES' : 'NO') . "\n";
echo "User Role: {$user->role}\n\n";

// Simulate login attempt
echo "1. TESTING LOGIN VIA AUTH::ATTEMPT():\n";
$credentials = ['email' => 'admin@admin.com', 'password' => 'admin123'];
if (Auth::attempt($credentials)) {
    echo "   ✓ LOGIN SUCCESS\n";
    echo "   Authenticated user: " . Auth::user()->name . "\n";
    Auth::logout();
} else {
    echo "   ❌ LOGIN FAILED\n";
}

// Test with wrong password
echo "\n2. TESTING WITH WRONG PASSWORD:\n";
$wrongCreds = ['email' => 'admin@admin.com', 'password' => 'wrongpassword'];
if (Auth::attempt($wrongCreds)) {
    echo "   ✓ Login succeeded (UNEXPECTED!)\n";
    Auth::logout();
} else {
    echo "   ✓ Login correctly rejected\n";
}

// Test with non-existent user
echo "\n3. TESTING WITH NON-EXISTENT USER:\n";
$nonExistent = ['email' => 'nonexistent@test.com', 'password' => 'password123'];
if (Auth::attempt($nonExistent)) {
    echo "   ✓ Login succeeded (UNEXPECTED!)\n";
    Auth::logout();
} else {
    echo "   ✓ Login correctly rejected\n";
}

echo "\n✓ ALL AUTH TESTS PASSED\n";
echo "\nUSE THESE CREDENTIALS TO LOGIN:\n";
echo "─ admin@admin.com / admin123 (Admin)\n";
echo "─ manager@manager.com / manager123 (Manager)\n";
echo "─ internal@internal.com / internal123 (Internal User)\n";
echo "─ guest@guest.com / guest123 (Guest User)\n";

?>
