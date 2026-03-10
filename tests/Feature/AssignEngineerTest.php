<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Cars;
use App\Models\Appointment;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\AppointmentController;

class AssignEngineerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    public function test_example(): void
    {

        $user = User::Create(
            [
                'email' => "michel@michel.com",
                'name' => 'User',
                'surname' => 'Principal',
                'phone' => 123456789,
                'password' => Hash::make("mimimim"),
                'email_verified_at' => now(),
                'role' => 'user',

            ]
        );
        $this->assertNotNull($user, "L’ingénieur a été créé"); // ✅ assertion
        $engineer = User::Create(
            [
                'email' => "michezezezel@michel.com",
                'name' => 'michel',
                'surname' => 'Principal',
                'phone' => 123456789,
                'password' => Hash::make("mimimim"),
                'email_verified_at' => now(),
                'role' => 'technicien',

            ]
        );
        $this->assertNotNull($engineer, "L’ingénieur a été créé"); // ✅ assertion

        $cars = Cars::create([
            'user_id' => 1,
            'immat' => 1000,
            'km' => 2000,
            'make' => "oui",
            'model' => "non",
            'year' => 2048
        ]);
        $this->assertNotNull($cars, "L’ingénieur a été créé"); // ✅ assertion


        // 2️⃣ Création d’un rendez-vous
        $appointment = Appointment::create([
            'customer_id' => 1,
            'car_id' =>  $cars->id, // si tu veux le définir
            'service' => 'Révision complète',
            'selectedStart' => Carbon::create(2025, 11, 21, 10, 0, 0),
        ]);
        $appointment = Appointment::create([
            'customer_id' => 1,
            'car_id' =>  $cars->id, // si tu veux le définir
            'service' => 'Révision complète',
            'selectedStart' => Carbon::create(2025, 11, 20, 10, 0, 0),
        ]);
        $appointment = Appointment::create([
            'customer_id' => 1,
            'car_id' =>  $cars->id, // si tu veux le définir
            'service' => 'Révision complète',
            'selectedStart' => Carbon::create(2025, 11, 22, 10, 0, 0),
        ]);

        $request2 = new Request([
            'engineer_id' => 'User'
        ]);
        $request3 = new Request([
            'search' => 'User'
        ]);
        $request = new Request([
            'engineer_id' => [2]
        ]);

        // Appeler directement ta méthode du contrôleur
        $controller = new AppointmentController();
        $response1 = $controller->assignEngineer($request, $appointment->id);


        // Appeler directement ta méthode du contrôleur
        $controller = new AppointmentController();
        $response = $controller->getAppointementSearch($request2);


        $data = $response->getData();          // stdClass
        $appointments = $data->data;           // Collection/array à l’intérieur

        $this->assertGreaterThan(2, count($appointments), "La réponse contient plusieurs rendez-vous");

      
       // dd($data," ceci est un dd");
        dump($data," ceci est un dump");

            $controller = new UserController();
        $response = $controller->getUserSearch($request3);
        
        dump($response," ceci est un dump getuser");
    }
}
