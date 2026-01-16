<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\User;

echo "=== Direct Login Test ===\n";

// Get admin user
$user = User::where('email', 'admin@admin.com')->first();

if (!$user) {
    echo "❌ User not found\n";
    exit;
}

echo "Testing login for: {$user->email}\n";
echo "Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";

// Try to authenticate
$credentials = [
    'email' => 'admin@admin.com',
    'password' => 'admin123'
];

if (Auth::attempt($credentials)) {
    echo "✓ Auth::attempt() SUCCESS\n";
    
    $authenticated_user = Auth::user();
    if ($authenticated_user) {
        echo "✓ Authenticated user: {$authenticated_user->name}\n";
        echo "✓ Role: {$authenticated_user->role}\n";
        echo "✓ Active: " . ($authenticated_user->is_active ? 'Yes' : 'No') . "\n";
        
        // Check if user is active
        if (!$authenticated_user->is_active) {
            echo "⚠️  User is not active - would be logged out\n";
        } else {
            echo "✓ User is active - login should succeed\n";
        }
    } else {
        echo "❌ Could not get authenticated user\n";
    }
} else {
    echo "❌ Auth::attempt() FAILED\n";
    echo "   Email: admin@admin.com\n";
    echo "   Password: admin123\n";
}
?>
