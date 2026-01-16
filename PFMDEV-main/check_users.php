<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "=== Users in Database ===\n";
$users = User::all();
foreach($users as $u) {
    echo "ID: {$u->id}, Name: {$u->name}, Email: {$u->email}, Role: {$u->role}, Active: " . ($u->is_active ? 'Yes' : 'No') . "\n";
}

if ($users->isEmpty()) {
    echo "No users found!\n";
}
?>
