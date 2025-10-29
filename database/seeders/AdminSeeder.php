<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $email = env('DEFAULT_ADMIN_EMAIL');
        $password = env('DEFAULT_ADMIN_PASSWORD');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'role' => 'admin',
                'password' => Hash::make($password),
            ]
        );

        $this->command->info("Admin seedé: {$email}");
    }
}
