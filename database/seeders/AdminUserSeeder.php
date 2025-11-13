<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // On vérifie si un admin existe déjà
        if (!User::where('email', 'admin@garageauto.fr')->exists()) {
            User::create([
                'name' => 'Admin',
                'surname' => 'Principal',
                'email' => 'admin@garageauto.fr',
                'phone' => 123456789,
                'password' => Hash::make('admin1234'), // change le mot de passe avant prod
                'email_verified_at' => now(),
                'role' => 'admin',
            ]);
        }
    }
}
