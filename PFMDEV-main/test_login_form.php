<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

echo "=== Testing Login Form Submission ===\n\n";

// Simulate the form data
$formData = [
    'email' => 'admin@admin.com',
    'password' => 'admin123',
];

echo "1. Form Data:\n";
print_r($formData);

// Validate like the controller does
echo "\n2. Validating credentials:\n";
$validator = Validator::make($formData, [
    'email' => 'required|email',
    'password' => 'required',
]);

if ($validator->fails()) {
    echo "   ❌ Validation FAILED:\n";
    print_r($validator->errors()->all());
} else {
    echo "   ✓ Validation PASSED\n";
}

// Try to authenticate
echo "\n3. Testing Auth::attempt():\n";
if (Auth::attempt($formData)) {
    echo "   ✓ Authentication SUCCESS\n";
    $user = Auth::user();
    echo "   Logged in as: {$user->name} ({$user->email})\n";
    echo "   Role: {$user->role}\n";
    echo "   Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
    
    // Check if active
    if (!$user->is_active) {
        echo "   ⚠️  User is NOT ACTIVE - would be logged out\n";
        Auth::logout();
    } else {
        echo "   ✓ User is ACTIVE - login would succeed\n";
        Auth::logout();
    }
} else {
    echo "   ❌ Authentication FAILED\n";
    echo "   This message would appear: 'Identifiants incorrects.'\n";
}

?>
