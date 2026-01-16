<?php

require __DIR__.'/bootstrap/app.php';

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

$app = require __DIR__.'/bootstrap/app.php';

echo "=== FINAL LOGIN TEST AFTER APP_KEY FIX ===\n\n";

// Check 1: Verify APP_KEY is loaded
echo "1. APP_KEY Check:\n";
$appKey = config('app.key');
echo "   APP_KEY loaded: " . ($appKey ? "✓ YES (length: " . strlen($appKey) . ")" : "✗ NO") . "\n";
echo "   APP_KEY value: " . ($appKey ? substr($appKey, 0, 30) . "..." : "NOT SET") . "\n\n";

// Check 2: Session driver
echo "2. Session Configuration:\n";
echo "   SESSION_DRIVER: " . config('session.driver') . "\n";
echo "   SESSION_LIFETIME: " . config('session.lifetime') . " minutes\n";
echo "   SESSION_ENCRYPT: " . (config('session.encrypt') ? 'true' : 'false') . "\n\n";

// Check 3: Verify admin user exists
echo "3. Test User Verification:\n";
$testUser = User::where('email', 'admin@admin.com')->first();
if ($testUser) {
    echo "   ✓ admin@admin.com found in database\n";
    echo "   User ID: " . $testUser->id . "\n";
    echo "   Role: " . $testUser->role . "\n";
    echo "   Is Active: " . ($testUser->is_active ? "true" : "false") . "\n";
    
    // Check 4: Test password verification
    echo "\n4. Password Verification Test:\n";
    $testPassword = 'admin123';
    $passwordMatch = Hash::check($testPassword, $testUser->password);
    echo "   Testing password 'admin123'\n";
    echo "   Password matches: " . ($passwordMatch ? "✓ YES" : "✗ NO") . "\n";
    
    // Check 5: Test Auth::attempt
    echo "\n5. Auth::attempt() Test:\n";
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'admin123'
    ];
    
    $attemptResult = Auth::attempt($credentials);
    echo "   Attempting login with admin@admin.com / admin123\n";
    echo "   Auth::attempt() result: " . ($attemptResult ? "✓ SUCCESS" : "✗ FAILED") . "\n";
    
    if ($attemptResult) {
        $user = Auth::user();
        echo "   Authenticated user ID: " . $user->id . "\n";
        echo "   Authenticated user role: " . $user->role . "\n";
        Auth::logout();
        echo "   ✓ Login works! User was authenticated\n";
    } else {
        echo "   ✗ Authentication failed\n";
    }
} else {
    echo "   ✗ admin@admin.com NOT FOUND in database\n";
}

echo "\n=== TEST COMPLETE ===\n";
