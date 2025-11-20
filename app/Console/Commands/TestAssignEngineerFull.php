<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Cars;
use App\Http\Controllers\AppointmentController;

class TestAssignEngineerFull extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-assign-engineer-full';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $email = env('DEFAULT_USER_EMAIL');
     $password = env('DEFAULT_USER_PASSWORD');
        $engineer = User::updateOrCreate(
 [
        'email' => $email
    ],
    [
        'name' => 'User',
        'surname' => 'Principal',
        'phone' => 123456789,
        'password' => Hash::make($password),
        'email_verified_at' => now(),
        'role' => 'user',
        
    ]
        );
        $cars = Cars::create([
            'user_id' => 3,
            'immat' => 1000,
            'km' => 2000,
            'make' => "oui",
            'model' => "non",
            'year' => 2048
        ]);

    



        $this->info("👷 Ingénieur créé :");
        $this->line("ID: {$engineer->id}, Nom: {$engineer->name}");

        // 2️⃣ Création d’un rendez-vous
        $appointment = Appointment::create([
            'customer_id' => 3,
            'car_id' =>  $cars->id, // si tu veux le définir
            'service' => 'Révision complète',
            'selectedStart' => Carbon::create(2025, 11, 20, 10, 0, 0),
        ]);
        $this->info("\n📅 Appointment créé :");
        $this->line("ID: {$appointment->id}, Titre: {$appointment->title}");

        // 3️⃣ Simule la Request
        $request = new Request([
            'engineer_id' => $engineer->id
        ]);

       if (!$appointment->id) {
            $this->error("❌ Appointment $appointment->id introuvable");
            return;
        }

        if (!$engineer->id) {
            $this->error("❌ User (engineer)$engineer->id introuvable");
            return;
        }

        // Simuler une Request HTTP
        $request = new Request([
            'engineer_id' =>[2,55]
        ]);
               $request2 = new Request([
            'engineer_id' => 'User'
        ]);

        // Appeler directement ta méthode du contrôleur
        $controller = new AppointmentController();
        $response = $controller->assignEngineer($request, $appointment->id);


        // Afficher la réponse JSON
        $this->info("\nRéponse du contrôleur :");
        $this->line($response->getContent());

        //recupe tous les rdv et leur engineer

        $responseEngineer = $controller->getTenAppointmentsOfTheDay();
        
               // Appeler directement ta méthode du contrôleur
        $controller = new AppointmentController();
        $response2 = $controller->getAppointementSearch($request2);

     
        // Afficher la réponse JSON
        $this->info("\nRéponse du contrôleur pour les enginner :");
        $this->line($responseEngineer->getContent());

        $this->info("\nRéponse du contrôleur pour les enginner :");
        $this->line($response2->getContent());
        
    
        return 0;
    }
}
