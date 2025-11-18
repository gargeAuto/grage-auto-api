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
use Illuminate\Support\Facades\DB;


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
        $appointment->engineer()->sync([$request->engineer_id, $id]);
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

        $appointments = Appointment::with([
            'customer' => fn($query) => $query->where('role', 'user'),
            'engineer' => fn($query) => $query->where('role', 'technicien'),
            'car',
            'service'
        ])
            ->whereBetween('selectedStart', [$dateTimeStart, $dateTimeEnd])
            ->orderBy('selectedStart', 'desc')
            ->take(10)
            ->get();

        // Transformation en JSON
        $data = $appointments->map(fn($appt) => [
            'appointment_id' => $appt->id,
            'selectedStart' => $appt->selectedStart,
            'total_price' => $appt->total_price,
            'customer_name' => $appt->customer->name ?? null,
            'customer_surname' => $appt->customer->surname ?? null,
            'customer_email' => $appt->customer->email ?? null,
            'engineer_name' => $appt->engineer->name ?? null,
            'engineer_surname' => $appt->engineer->surname ?? null,
            'engineer_email' => $appt->engineer->email ?? null,
            'car_immat' => $appt->car->immat ?? null,
            'car_make' => $appt->car->make ?? null,
            'car_model' => $appt->car->model ?? null,
            'service_wording' => $appt->service->wording ?? null,
            'service_delay' => $appt->service->delay ?? null,
        ]);
        //->paginate(10);

        return  response()->json([
            'data' => $data
        ]);
    }

    public function getAppointementSearch(Request $request)
    {
        $query = $request->input('q');
        $columns = [
            'name',
            'surname',
            'email',
            'immat',
            'make',
            'model',
            'appointments.selectedStart',
            'wording',
            'delay'
        ];


        $results = DB::table('appointments')
            ->leftJoin('users', 'appointments.id', '=', 'users.id')
            ->leftJoin('service', 'appointments.id', '=', 'service.id')
            ->leftJoin('cars', 'users.id', '=', 'cars.id')
            ->select(
                'name',
                'surname',
                'email',
                'immat',
                'make',
                'model',
                'appointments.selectedStart',
                'wording',
                'delay'
            );

        $users = $results->where(function ($q) use ($query, $columns) {
            foreach ($columns as $column) {
                $q->orWhere($column, 'like', "%{$query}%");
            }
        })
            ->get();

        return  $users;
    }
}
