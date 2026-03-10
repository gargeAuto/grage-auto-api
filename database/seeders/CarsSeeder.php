<?php

namespace Database\Seeders;

use App\Models\Cars;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cars::create([
            'user_id' => 3,
            'immat' => 1000,
            'km' => 2000,
            'make' => "oui",
            'model' => "non",
            'year' => 2048
        ]);

        Cars::create([
            'user_id' => 1,
            'immat' => 1001,
            'km' => 2001,
            'make' => "oui",
            'model' => "non",
            'year' => 2048
        ]);

        Cars::create([
            'user_id' => 1,
            'immat' => 1002,
            'km' => 2002,
            'make' => "oui",
            'model' => "non",
            'year' => 2050
        ]);
    }
}
