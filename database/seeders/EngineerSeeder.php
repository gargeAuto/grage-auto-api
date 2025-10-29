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
            ['email' => $email],
            [
                'name' => 'Technicien',
                'role' => 'technicien',
                'password' => Hash::make($password),
            ]
        );

        $this->command->info("Technicien seedé: {$email}");
    }
}
