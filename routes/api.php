<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [UserController::class,'login']);
Route::middleware('auth:sanctum')->controller(AppointmentController::class)->prefix('Appointment')->group(function () {
    Route::get('/show-appointment', 'show');
    Route::post('/create-appointment', 'store');
    Route::post('/update-appointment', 'update');
    Route::post('/delete-appointment', 'delete');
});
