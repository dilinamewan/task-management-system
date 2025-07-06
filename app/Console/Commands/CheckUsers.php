<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CheckUsers extends Command
{
    protected $signature = 'users:check';
    protected $description = 'Check and create default users if they don\'t exist';

    public function handle()
    {
        $this->info('Checking for default users...');
        
        // Check admin user
        $admin = User::where('email', 'admin@example.com')->first();
        if (!$admin) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            $this->info('✅ Created admin user: admin@example.com');
        } else {
            $this->info('✅ Admin user exists: admin@example.com');
        }
        
        // Check regular user
        $user = User::where('email', 'user@example.com')->first();
        if (!$user) {
            User::create([
                'name' => 'John Doe',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
            $this->info('✅ Created regular user: user@example.com');
        } else {
            $this->info('✅ Regular user exists: user@example.com');
        }
        
        // Display all users
        $this->info('📋 Current users in database:');
        $users = User::all(['id', 'name', 'email', 'role']);
        
        $this->table(
            ['ID', 'Name', 'Email', 'Role'],
            $users->map(function ($user) {
                return [$user->id, $user->name, $user->email, $user->role];
            })->toArray()
        );
        
        $this->info('🎯 Login credentials:');
        $this->info('Admin: admin@example.com / password');
        $this->info('User: user@example.com / password');
        
        return 0;
    }
}
