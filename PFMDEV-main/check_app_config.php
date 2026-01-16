<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Checking Application Configuration ===\n\n";

// 1. Check APP_KEY
echo "1. APP_KEY Configuration:\n";
$appKey = env('APP_KEY');
if ($appKey) {
    echo "   ✓ APP_KEY is set\n";
    echo "   Value: " . substr($appKey, 0, 20) . "...\n";
} else {
    echo "   ❌ APP_KEY is NOT SET\n";
}

// 2. Check Session Configuration
echo "\n2. SESSION Configuration:\n";
echo "   SESSION_DRIVER: " . env('SESSION_DRIVER', 'file') . "\n";
$sessionDriver = env('SESSION_DRIVER', 'file');
if ($sessionDriver === 'database') {
    echo "   Using database sessions\n";
    // Check if sessions table exists
    $hasSessionsTable = DB::table('sessions')->count();
    echo "   ✓ Sessions table exists with " . $hasSessionsTable . " records\n";
} else {
    echo "   Using file-based sessions\n";
}

// 3. Check if HTTPS is required
echo "\n3. URL Configuration:\n";
$appUrl = env('APP_URL', 'http://localhost');
echo "   APP_URL: {$appUrl}\n";
if (strpos($appUrl, 'https') === 0) {
    echo "   ⚠️  Using HTTPS - may cause issues if accessed via HTTP\n";
} else {
    echo "   ✓ Using HTTP\n";
}

// 4. Check database connection
echo "\n4. Database Connection:\n";
try {
    $user = \App\Models\User::first();
    if ($user) {
        echo "   ✓ Database connected\n";
        echo "   First user: {$user->email}\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Database error: " . $e->getMessage() . "\n";
}

// 5. Check auth configuration
echo "\n5. AUTH Configuration:\n";
$authGuard = config('auth.defaults.guard');
echo "   Default guard: {$authGuard}\n";
$userModel = config('auth.providers.users.model');
echo "   User model: {$userModel}\n";

// 6. Check if routes are working
echo "\n6. Routes:\n";
$route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('login');
if ($route) {
    echo "   ✓ Login route exists: " . $route->uri() . "\n";
} else {
    echo "   ❌ Login route NOT FOUND\n";
}

echo "\n=== All checks complete ===\n";
?>
