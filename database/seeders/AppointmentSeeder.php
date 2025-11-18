<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Cars;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $car = Cars::create([
            'user_id' => 1,
            'immat' => 1001,
            'km' => 2001,
            'make' => "oui",
            'model' => "non",
            'year' => 2048
        ]);

        Appointment::create([
            'customer_id' => 3,
            'engineer_id' => 2,
            'car_id' => $car->id,
            'service' => 'Révision complète',
            'selectedStart' => Carbon::create(2025, 11, 13, 10, 0, 0),
        ]);

        Appointment::create([
            'customer_id' => 3,
            'engineer_id' => 2,
            'car_id' => $car->id,
            'service' => 'Changement de pneus',
            'selectedStart' => Carbon::create(2025, 11, 14, 14, 30, 0),
        ]);

        Appointment::create([
            'customer_id' => 3,
            'engineer_id' => 2,
            'car_id' => $car->id,
            'service' => 'Contrôle technique',
            'selectedStart' => Carbon::create(2025, 11, 18, 14, 0, 0),
        ]);
    }
}
