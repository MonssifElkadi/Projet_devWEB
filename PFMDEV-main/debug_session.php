<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== Database Connection Check ===\n";
try {
    $connection = DB::connection()->getPdo();
    echo "✓ Database connected\n";
} catch (\Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
    exit;
}

echo "\n=== Sessions Table Check ===\n";
if (Schema::hasTable('sessions')) {
    echo "✓ Sessions table exists\n";
    $count = DB::table('sessions')->count();
    echo "  Sessions count: {$count}\n";
} else {
    echo "❌ Sessions table DOES NOT EXIST!\n";
}

echo "\n=== Testing Session Creation ===\n";
$test_session_id = 'test_' . bin2hex(random_bytes(16));
try {
    DB::table('sessions')->insert([
        'id' => $test_session_id,
        'user_id' => null,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'test',
        'payload' => 'test_payload',
        'last_activity' => time(),
    ]);
    echo "✓ Test session created\n";
    
    // Clean up
    DB::table('sessions')->where('id', $test_session_id)->delete();
    echo "✓ Test session cleaned up\n";
} catch (\Exception $e) {
    echo "❌ Session creation error: " . $e->getMessage() . "\n";
}
?>
