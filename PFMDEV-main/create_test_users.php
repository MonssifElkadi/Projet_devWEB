<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "Creating test users...\n";

$admin = User::create([
    'name' => 'Admin User',
    'email' => 'admin@admin.com',
    'password' => Hash::make('admin123'),
    'role' => 'admin',
    'is_active' => true
]);
echo "✓ Admin\n";

$manager = User::create([
    'name' => 'Manager User',
    'email' => 'manager@manager.com',
    'password' => Hash::make('manager123'),
    'role' => 'manager',
    'is_active' => true
]);
echo "✓ Manager\n";

$internal = User::create([
    'name' => 'Internal User',
    'email' => 'internal@internal.com',
    'password' => Hash::make('internal123'),
    'role' => 'internal',
    'is_active' => true
]);
echo "✓ Internal\n";

$guest = User::create([
    'name' => 'Guest User',
    'email' => 'guest@guest.com',
    'password' => Hash::make('guest123'),
    'role' => 'guest',
    'is_active' => true
]);
echo "✓ Guest\n";

echo "\nDone!\n";
?>

