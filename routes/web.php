<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HomeDashController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class,'index'])->middleware('guest');
Route::get('/login', [LoginController::class,'login'])->middleware('guest')->name('get_login');
Route::post('/login_post', [LoginController::class,'login_post'])->middleware('guest')->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeDashController::class,'home'])->name('home');
    Route::post('/logout', [HomeDashController::class,'logout'])->name('logout');
    Route::controller(UserController::class)->prefix('User')->group(function () {
        Route::get('/', 'index')->name('user_list');
        Route::post('/', 'show')->name('user_list_post');
        Route::get('/createnew', 'createnew')->name('user_createnew');
        Route::post('/createnew', 'store')->name('user_createnew_post');
        Route::get('/updateUser/{id}', 'edit')->name('user_update');
        Route::post('/updateUser', 'update')->name('user_update_post');
        Route::post('/delete', 'delete')->name('user_delete');
    });
    Route::controller(AppointmentController::class)->prefix('Appointment')->group(function () {
        Route::get('/', 'index')->name('appointment_list');
        Route::post('/', 'show')->name('appointment_list_post');
        Route::get('/createnew', 'createnew')->name('appointment_createnew');
        Route::post('/createnew', 'store')->name('appointment_createnew_post');
        Route::get('/updateappointment/{id}', 'edit')->name('appointment_update');
        Route::post('/updateappointment', 'update')->name('appointment_update_post');
        Route::post('/delete', 'delete')->name('appointment_delete');
    });
    Route::get('/Calender', [HomeDashController::class,'Calender'])->name('Calender');

});
