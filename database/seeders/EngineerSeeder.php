<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EngineerSeeder extends Seeder
{
    public function run()
    {
        $email = env('DEFAULT_ENGINEER_EMAIL');
        $password = env('DEFAULT_ENGINEER_PASSWORD');

        User::updateOrCreate(
     
            [
                'email' => $email,
                'name' => 'User',
                'surname' => 'Principal',
                'phone' => 123456789,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'role' => 'technicien',
            ]
        );

        $this->command->info("Technicien seedé: {$email}");
    }
}
