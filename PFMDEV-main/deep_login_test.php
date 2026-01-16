<?php
// Test the login process more deeply

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

echo "=== DETAILED LOGIN PROCESS TEST ===\n\n";

// Test 1: Check if Auth guard is set up correctly
echo "1. Auth Guard Setup:\n";
echo "   Default Guard: " . config('auth.defaults.guard') . "\n";
echo "   Web Guard Config: " . json_encode(config('auth.guards.web')) . "\n\n";

// Test 2: Check User Model is correct
echo "2. User Model Settings:\n";
$userModel = config('auth.providers.users.model');
echo "   Model Class: {$userModel}\n";
$user = $userModel::where('email', 'admin@admin.com')->first();
if ($user) {
    echo "   Sample User Found: {$user->name}\n";
    echo "   User ID: {$user->id}\n";
    echo "   is_active: " . ($user->is_active ? 'YES' : 'NO') . "\n";
} else {
    echo "   ❌ Sample user not found!\n";
}

echo "\n3. Session Configuration:\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Table: " . config('session.table') . "\n";
echo "   Lifetime: " . config('session.lifetime') . " minutes\n";
echo "   Encrypt: " . (config('session.encrypt') ? 'YES' : 'NO') . "\n";

echo "\n4. Cache Configuration:\n";
echo "   Store: " . config('cache.default') . "\n";

// Test 3: Simulate failed login to see error handling
echo "\n5. Testing Failed Login (Wrong Password):\n";
$result = Auth::attempt([
    'email' => 'admin@admin.com',
    'password' => 'wrongpassword'
]);
if (!$result) {
    echo "   ✓ Correctly rejected wrong password\n";
} else {
    echo "   ❌ ERROR: Accepted wrong password!\n";
}

// Test 4: Check active user logic
echo "\n6. Testing Inactive User Login:\n";
$inactiveUser = \App\Models\User::where('is_active', 0)->first();
if ($inactiveUser) {
    echo "   Found inactive user: {$inactiveUser->email}\n";
    $result = Auth::attempt([
        'email' => $inactiveUser->email,
        'password' => 'password' // assuming test password
    ]);
    if ($result) {
        Auth::logout();
        echo "   ⚠️  WARNING: Inactive user can log in (may be auto-blocked by controller)\n";
    } else {
        echo "   ✓ Inactive user correctly rejected\n";
    }
} else {
    echo "   No inactive users found\n";
}

// Test 5: Test session persistence
echo "\n7. Testing Session Creation:\n";
if (Auth::attempt(['email' => 'admin@admin.com', 'password' => 'admin123'])) {
    $sessionId = \Illuminate\Support\Facades\Session::getId();
    echo "   ✓ User logged in\n";
    echo "   Session ID: {$sessionId}\n";
    
    // Check if session was saved
    $sessionData = \DB::table('sessions')
        ->where('id', $sessionId)
        ->first();
    
    if ($sessionData) {
        echo "   ✓ Session found in database\n";
        echo "   User ID in session: " . ($sessionData->user_id ?? 'NULL') . "\n";
    } else {
        echo "   ❌ Session NOT found in database!\n";
    }
    
    Auth::logout();
} else {
    echo "   ❌ Failed to log in test user\n";
}

?>
