<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CallCarApiController;
use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth publique
Route::post('/signup', [AuthController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'login']);

// API publiques
Route::get('/make', [CallCarApiController::class, 'getMakeController']);
Route::get('/model', [CallCarApiController::class, 'getModelController']);
Route::get('/year', [CallCarApiController::class, 'getYearController']);

// Routes protégées
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/cars', [CarController::class, 'store']);
    Route::get('/cars', [CarController::class, 'getAllCars']);
    Route::get('/cars/{id}', [CarController::class, 'getCarById']);
    Route::patch('/cars/{id}', [CarController::class, 'update']);
    Route::delete('/cars/{id}', [CarController::class, 'delete']);
    Route::get('/cars/search', [CarController::class, 'search']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/user', fn(Request $request) => $request->user());
    Route::get('/appointments', [AppointmentController::class, 'getAppointmentWithRole']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);

    // Routes admin
    Route::middleware('role:admin')->group(function () {
        Route::post('/admin', [AdminController::class, 'addEngineer']);
        Route::patch('/appointments/{id}/assign', [AppointmentController::class, 'assignEngineer']);
        Route::apiResource('/users', UserController::class);
    });
});
