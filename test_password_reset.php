<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Password;
use App\Models\User;

// First, let's check if we have any users
$userCount = User::count();
echo "Total users in database: " . $userCount . "\n";

if ($userCount > 0) {
    $user = User::first();
    echo "Testing with user email: " . $user->email . "\n";
    
    try {
        $status = Password::sendResetLink(['email' => $user->email]);
        echo "Password reset status: " . $status . "\n";
        
        if ($status == Password::RESET_LINK_SENT) {
            echo "✅ Password reset link sent successfully!\n";
        } else {
            echo "❌ Failed to send password reset link. Status: " . $status . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
} else {
    echo "No users found in database. Please create a user first.\n";
}
