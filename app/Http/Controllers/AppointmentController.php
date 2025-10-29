<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use \App\Models\Appointment;
use App\Models\Service;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $appointment = Appointment::create([
            'customer_id' => $user->id,
            'engineer_id' => $request->engineer_id,
            'service' => Carbon::create($request->service),
            'total_price' => $request->total_price,
            'new_price' => $request->new_price,
            'comments' => $request->comments,
        ]);

        return response()->json($appointment);
    }
    public function index(Request $request)
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
}
