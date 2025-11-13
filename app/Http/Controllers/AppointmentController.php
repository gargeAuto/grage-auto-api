<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationAppointmentMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\Models\Appointment;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Cars;
use Illuminate\Container\Attributes\DB;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();
        $carData = $request->carData;
        $cars = Cars::create([
            'user_id' => $user->id,
            'immat' => $carData['immat'],
            'km' => $carData['km'],
            'make' => $carData['make'],
            'model' => $carData['model'],
            'year' => $carData['year']
        ]);



        $appointmentData = $request->selectedStart;
        $date = Carbon::parse($appointmentData)->format('Y-m-d H:i:s');
        $appointment = Appointment::create([
            'customer_id' => $user->id,
            'selectedStart' => $date,
            'engineer_id' => $appointmentData['engineer_id'] ?? null,
            'service' => $appointmentData['service'] ?? null,
            // 'total_price' => $appointmentData['total_price'] ?? null,
            // 'new_price' => $appointmentData['new_price'] ?? null,
            // 'comments' => $appointmentData['comments'] ?? null,
        ]);

        /** @var User $user */
        Mail::to($user->email)->send(new ConfirmationAppointmentMail($user, $cars, $appointment));

        return response([
            'message' => 'Votre rendez-vous a été créé avec succès. Un email de confirmation a été envoyé à votre adresse email.',

        ], 201);
    }
    public function getAppointmentWithRole(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return Appointment::all(); // admin voit tout
        }

        return Appointment::where('customer_id', $user->id)->get(); // client voit ses rendez-vous
    }

    public function assignEngineer(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->update([
            'engineer_id' => $request->engineer_id,
        ]);
        return response()->json([
            'message' => 'Ingénieur assigné avec succès',
            'appointment' => $appointment,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $appointment = Appointment::findOrFail($id);

        // 🔒 Vérification des droits :
        // - L'admin peut tout supprimer
        // - Le client ne peut supprimer QUE ses propres rendez-vous
        if ($user->role !== 'admin' && $appointment->customer_id !== $user->id) {
            return response()->json([
                'message' => 'Vous n’êtes pas autorisé à supprimer ce rendez-vous.'
            ], 403);
        }

        // 🔥 Suppression
        $appointment->delete();

        return response()->json([
            'message' => 'Rendez-vous supprimé avec succès.',
            'appointment_id' => $id,
        ], 200);
    }

    public function getTenAppointmentsOfTheDay()
    {

        $dateTimeStart = now()->startOfDay();
        $dateTimeEnd = now()->endOfDay();

        $appointments = Appointment::whereBetween('selectedStart', [$dateTimeStart, $dateTimeEnd])
            ->orderBy('selectedStart', 'desc')
            ->paginate(10)
            ->get();

        return $appointments;
    }

    public function getAppointementSearch(Request $request)
    {
        $query = $request->input('q');
        $columns = ['name', 'surname', 'email', 'phone'];


        $results = DB::table('appointments')
            ->join('users', 'appointments.id', '=', 'users.customer_id')
            ->join('service','appointments.id', '=', 'service.customer_id')
            ->select('users.name', 'posts.title');

         $users = $results->where(function ($q) use ($query, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$query}%");
            }
        })
            ->get();

            return  $users;
    }
}
