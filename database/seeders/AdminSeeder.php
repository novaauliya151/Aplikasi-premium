<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $adminExists = User::where('email', 'admin@apkpremium.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Admin APK Premium',
                'email' => 'admin@apkpremium.com',
                'password' => Hash::make('admin123'), // Ganti dengan password yang aman
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin user berhasil dibuat!');
            $this->command->info('📧 Email: admin@apkpremium.com');
            $this->command->info('🔑 Password: admin123');
            $this->command->warn('⚠️  Jangan lupa ganti password setelah login!');
        } else {
            $this->command->warn('⚠️  Admin user sudah ada, skip...');
        }
    }
}
