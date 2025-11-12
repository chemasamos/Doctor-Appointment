<?php

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
});