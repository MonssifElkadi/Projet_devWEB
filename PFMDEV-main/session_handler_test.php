<?php
// More detailed session test

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

echo "=== SESSION HANDLER TEST ===\n\n";

// Check the session handler
echo "1. Session Handler Info:\n";
$sessionHandler = Session::getFacadeRoot();
echo "   Handler class: " . get_class($sessionHandler) . "\n";
echo "   Driver: " . config('session.driver') . "\n";
echo "   Table: " . config('session.table') . "\n\n";

// Check cache/session store
echo "2. Cache Store Info:\n";
echo "   Cache store: " . config('cache.default') . "\n";
echo "   Cache prefix: " . config('cache.prefix') . "\n\n";

// Now test with explicit session handling
echo "3. Manual Session Test:\n";
Session::put('test_key', 'test_value');
Session::save(); // Explicitly save session
echo "   ✓ Put test_key in session\n";

// Check database
$sessionId = Session::getId();
echo "   Session ID: {$sessionId}\n";

$sessionInDb = \DB::table('sessions')->where('id', $sessionId)->first();
if ($sessionInDb) {
    echo "   ✓ Found in database\n";
    echo "   Payload length: " . strlen($sessionInDb->payload) . " bytes\n";
} else {
    echo "   ❌ NOT in database\n";
    
    // List all sessions
    echo "\n   All sessions in DB:\n";
    $allSessions = \DB::table('sessions')->get();
    foreach ($allSessions as $s) {
        echo "     - {$s->id} (user_id: {$s->user_id})\n";
    }
}

echo "\n4. Auth Session Test:\n";
if (Auth::attempt(['email' => 'Admin User', 'password' => 'password'])) {
    echo "   ✓ Logged in\n";
} else {
    // Try with correct credentials
    $result = Auth::attempt(['email' => 'admin@admin.com', 'password' => 'admin123']);
    echo "   Auth attempt result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
    if ($result) {
        echo "   ✓ User authenticated\n";
        Session::save();
        
        $newSessionId = Session::getId();
        echo "   Session ID: {$newSessionId}\n";
        
        $sessionInDb = \DB::table('sessions')
            ->where('id', $newSessionId)
            ->first();
        
        if ($sessionInDb) {
            echo "   ✓ Session found in database!\n";
            echo "   User ID in session: {$sessionInDb->user_id}\n";
        } else {
            echo "   ❌ Session still not in database\n";
            
            // Check all sessions
            echo "\n   Checking all sessions in DB:\n";
            $allSessions = \DB::table('sessions')->orderBy('created_at', 'desc')->limit(5)->get();
            foreach ($allSessions as $s) {
                echo "     - {$s->id} (user: {$s->user_id}, activity: {$s->last_activity})\n";
            }
        }
        
        Auth::logout();
    }
}

?>
