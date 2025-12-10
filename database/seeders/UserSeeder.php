<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $email = 'DEFAULT_USER_EMAIL@salut.com';
        $password = 'DEFAULT_USER_PASSWORD';

        User::updateOrCreate(

            [
                'email' => $email,
                'name' => 'User',
                'surname' => 'Principal',

                'phone' => 123456789,
                'password' => Hash::make($password), // change le mot de passe avant prod
                'email_verified_at' => now(),
                'role' => 'user',

            ]
        );

        $this->command->info("User seedé: {$email}");
    }
}
