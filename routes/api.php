<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CallCarApiController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/admin', [AdminController::class, 'addEngeener'])
     ->middleware(['auth:sanctum', 'role:admin']);
    Route::apiResource('/users', UserController::class);

});

Route::get("/make", [CallCarApiController::class,"getMakeController"]);
Route::get("/model", [CallCarApiController::class,"getModelController"]);
Route::get("/year", [CallCarApiController::class,"getYearController"]);
Route::post("/signup", [AuthController::class,"signUp"]);
Route::post("/login", [AuthController::class,"login"]);
Route::get("/index", [UserController::class,"index"]);
  