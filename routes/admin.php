<?php

use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Panel principal del admin
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Gestión de Roles
    Route::resource('roles', RoleController::class);

    // Gestión de Usuarios
    Route::resource('users', UserController::class);

    // Gestión de Pacientes
    Route::resource('patients', \App\Http\Controllers\Admin\PatientController::class)->only(['index', 'create', 'edit', 'update']);

    // Gestión de Doctores
    Route::resource('doctors', \App\Http\Controllers\Admin\DoctorController::class);

    // Directorio de Aseguradoras
    Route::resource('insurances', InsuranceController::class)->only(['index', 'create', 'store']);

    // Citas médicas
    Route::resource('appointments', AppointmentController::class)->only(['index', 'create', 'store']);
    Route::get('appointments/{appointment}/consult', [AppointmentController::class, 'consult'])->name('appointments.consult');

    // Horarios de doctor
    Route::get('doctors/{doctor}/schedules', [\App\Http\Controllers\Admin\DoctorController::class, 'schedules'])->name('doctors.schedules');
});