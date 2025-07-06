<?php

// Run this file to manually verify user email
// Usage: php verify_email.php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Verify user email
$user = \App\Models\User::where('email', 'pgdmewan@students.nsbm.ac.lk')->first();

if ($user) {
    $user->email_verified_at = now();
    $user->save();
    echo "✅ Email verified for user: " . $user->name . " (" . $user->email . ")\n";
} else {
    echo "❌ User not found with email: pgdmewan@students.nsbm.ac.lk\n";
}
