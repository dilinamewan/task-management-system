<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin user already exists
        $admin = User::where('email', 'admin@example.com')->first();
        if (!$admin) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
            $this->command->info('✅ Created admin user: admin@example.com');
        } else {
            $this->command->info('✅ Admin user already exists: admin@example.com');
        }

        // Check if regular user already exists
        $user = User::where('email', 'user@example.com')->first();
        if (!$user) {
            User::create([
                'name' => 'John Doe',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
            $this->command->info('✅ Created regular user: user@example.com');
        } else {
            $this->command->info('✅ Regular user already exists: user@example.com');
        }

        // Display login credentials
        $this->command->info('');
        $this->command->info('🎯 Demo Login Credentials:');
        $this->command->info('👨‍💼 Admin: admin@example.com / password');
        $this->command->info('👤 User: user@example.com / password');
        $this->command->info('');
        $this->command->warn('⚠️  Remember to change these passwords in production!');
    }
}