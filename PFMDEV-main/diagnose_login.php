<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

echo "=== LOGIN DIAGNOSIS ===\n\n";

// 1. Check users exist
echo "1. Users in Database:\n";
$users = User::all();
foreach($users as $u) {
    echo "   - {$u->email} (Role: {$u->role}, Active: " . ($u->is_active ? 'Yes' : 'No') . ")\n";
    echo "     Hash: " . substr($u->password, 0, 20) . "...\n";
}

// 2. Test each user login
echo "\n2. Testing Auth::attempt() for each user:\n";

$credentials = [
    ['email' => 'admin@admin.com', 'password' => 'admin123'],
    ['email' => 'manager@manager.com', 'password' => 'manager123'],
    ['email' => 'internal@internal.com', 'password' => 'internal123'],
    ['email' => 'guest@guest.com', 'password' => 'guest123'],
];

foreach($credentials as $cred) {
    echo "\n   Testing: {$cred['email']} / {$cred['password']}\n";
    
    $user = User::where('email', $cred['email'])->first();
    if (!$user) {
        echo "   ❌ User NOT FOUND\n";
        continue;
    }
    
    echo "   ✓ User found\n";
    
    // Test password hash directly
    if (Hash::check($cred['password'], $user->password)) {
        echo "   ✓ Password hash correct\n";
    } else {
        echo "   ❌ Password hash FAILED\n";
        echo "     Provided password: {$cred['password']}\n";
        echo "     User password hash: {$user->password}\n";
        echo "     Testing with Hash::make: " . Hash::make($cred['password']) . "\n";
    }
    
    // Test Auth::attempt
    if (Auth::attempt($cred)) {
        echo "   ✓ Auth::attempt() SUCCESS\n";
        $authed_user = Auth::user();
        echo "     Authenticated as: {$authed_user->name}\n";
        Auth::logout();
    } else {
        echo "   ❌ Auth::attempt() FAILED\n";
    }
}

// 3. Debug the login controller
echo "\n3. Checking AuthController method:\n";
$reflection = new \ReflectionClass(\App\Http\Controllers\AuthController::class);
$method = $reflection->getMethod('login');
echo "   ✓ login() method exists\n";
echo "   Location: " . $reflection->getFileName() . "\n";

?>
