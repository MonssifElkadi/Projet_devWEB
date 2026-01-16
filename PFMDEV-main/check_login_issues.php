<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

echo "=== CHECKING LOGIN ISSUES ===\n\n";

// Check 1: Users in database
echo "1. USERS IN DATABASE:\n";
$users = User::all();
if ($users->isEmpty()) {
    echo "   ❌ NO USERS FOUND - Need to seed database!\n";
} else {
    foreach($users as $u) {
        echo "   - Email: {$u->email} | Role: {$u->role} | Active: " . ($u->is_active ? 'YES' : 'NO') . "\n";
        echo "     ID: {$u->id} | Password (first 20 chars): " . substr($u->password, 0, 20) . "...\n";
    }
}

// Check 2: Test login with credentials from AdminSeeder
echo "\n2. TESTING LOGIN WITH ADMIN@DATACENTER.COM:\n";
$credentials = ['email' => 'admin@datacenter.com', 'password' => 'password'];
if (Auth::attempt($credentials)) {
    $user = Auth::user();
    echo "   ✓ LOGIN SUCCESS!\n";
    echo "     Authenticated as: {$user->name}\n";
    echo "     Role: {$user->role}\n";
    Auth::logout();
} else {
    echo "   ❌ LOGIN FAILED!\n";
    // Try to find the user manually
    $user = User::where('email', $credentials['email'])->first();
    if ($user) {
        echo "   User found, checking password...\n";
        $passwordMatch = Hash::check($credentials['password'], $user->password);
        echo "     Password match: " . ($passwordMatch ? 'YES ✓' : 'NO ✗') . "\n";
    } else {
        echo "   ❌ User not found in database!\n";
    }
}

// Check 3: Sessions table
echo "\n3. CHECKING SESSIONS TABLE:\n";
try {
    $sessionCount = \DB::table('sessions')->count();
    echo "   ✓ Sessions table exists, current sessions: {$sessionCount}\n";
} catch (\Exception $e) {
    echo "   ❌ Sessions table error: " . $e->getMessage() . "\n";
}

// Check 4: App key
echo "\n4. APP KEY CHECK:\n";
$appKey = config('app.key');
if ($appKey) {
    echo "   ✓ APP_KEY loaded: " . substr($appKey, 0, 20) . "...\n";
} else {
    echo "   ❌ APP_KEY NOT LOADED!\n";
}

echo "\n";
?>
