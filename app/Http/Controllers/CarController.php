<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Cars;

class CarController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $car = Cars::create([
            'customer_id' => $user->id,
            'registration' => $request->registration,
            'brand' => $request->brand,
            'model' => $request->model,
            'years' => $request->years,
        ]);
        error_log(var_export($car, true));
        \Log::info('Car created:', $car->toArray());
        return response()->json($car);
        
    }

    public function getAllCars(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            $cars = Cars::all();
        } else {
            $cars = Cars::where('customer_id', $user->id)->get();
        }

        return response()->json($cars);
    }

    public function getCarById(Request $request, $id)
    {
        $user = $request->user();
        $car = Cars::findOrFail($id);

        if ($car->customer_id !== $user->id && $user->role !== 'admin') {
            return response()->json([
                'message' => 'Accès non autorisé.'
            ], 403);
        }

        return response()->json($car);
    }

    public function getCarsByUserId(Request $request, $userId){
        $car = Cars::where('user_id',$userId)->get();
        return response()->json([
            'data'=>$car,
        ]);
    }

    public function update(Request $request, $id)
    {
        $car = Cars::findOrFail($id);

        $car->update([
            'registration' => $request->registration,
            'brand' => $request->brand,
            'model' => $request->model,
            'years' => $request->years,
        ]);
        return response()->json([
            'message' => 'La voiture à été modifié avec succès',
            'car' => $car,
        ]);
    }

    public function search(Request $request)
    {
        $query = Cars::query();

        if ($search = $request->input('search')) {
            $query->where('registration', 'like', "%{$search}%")
                ->orWhere('brand', 'like', "%{$search}%")
                ->orWhere('model', 'like', "%{$search}%");
        }

        return response()->json($query->get());
    }

    public function delete(Request $request, $id)
    {
        $user = $request->user();

        $car = Cars::findOrFail($id);
        if ($car->customer_id !== $user->id && $user->role !== 'admin') {
            return response()->json([
                'message' => 'Vous n’êtes pas autorisé à supprimer cette voiture.'
            ], 403);
        }
        $car->delete();
        return response()->json([
            'message' => 'Voiture supprimée avec succès.'
        ], 200);
    }
}
