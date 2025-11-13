<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::create([
            'customer_id' => 3,
            'engineer_id' => 2,
            'service' => 'Révision complète',
            'selectedStart' => Carbon::create(2025, 11, 13, 10, 0, 0),
        ]);

        Appointment::create([
            'customer_id' => 3,
            'engineer_id' => 2,
            'service' => 'Changement de pneus',
            'selectedStart' => Carbon::create(2025, 11, 14, 14, 30, 0),
        ]);

        Appointment::create([
            'customer_id' => 3,
            'engineer_id' => 2,
            'service' => 'Contrôle technique',
            'selectedStart' => Carbon::create(2025, 11, 15, 9, 0, 0),
        ]);
    }
}
