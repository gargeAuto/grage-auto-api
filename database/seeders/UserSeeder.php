<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $email = env('DEFAULT_USER_EMAIL');
        $password = env('DEFAULT_USER_PASSWORD');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'User',
                'role' => 'user',
                'password' => Hash::make($password),
            ]
        );

        $this->command->info("User seedé: {$email}");
    }
}
