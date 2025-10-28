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
        $appointment = Appointment::create([
            'customer_id' => $request->customer_id,
            'engineer_id' => $request->engineer_id,
            'service' => Carbon::create($request->service),
            'total_price' => $request->total_price,
            'new_price' => $request->new_price,
            'comments' => $request->comments,
        ]);

        error_log(var_export($appointment->toArray(), true));
        \Log::info('Appointment created:', $appointment->toArray());

        return response()->json($appointment);
    }

    public function index()
    {
        return Appointment::all();
    }
}
