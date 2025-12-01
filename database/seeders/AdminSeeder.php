<?php

namespace Database\Seeders;

use App\Models\Admin; // ← Changed from User to Admin
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        $existingAdmin = Admin::where('email', 'admin@delivery.com')->first();
        
        if ($existingAdmin) {
            $this->command->info('⚠️  Admin account already exists!');
            $this->command->info('📧 Email: ' . $existingAdmin->email);
            return;
        }

        // Create admin account in admins table
        $admin = Admin::create([
            'name' => 'System Administrator',
            'email' => 'admin@delivery.com',
            'password' => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Admin account created successfully!');
        $this->command->info('📧 Email: admin@delivery.com');
        $this->command->info('🔑 Password: admin123');
    }
}