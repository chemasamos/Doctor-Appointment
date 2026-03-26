<?php

use Illuminate\Support\Facades\Route;

// Redirige la raíz a /admin
Route::redirect('/', '/admin');

// Ruta de prueba para demostrar generación y descarga de un Excel
Route::get('/test-excel', function () {
    return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\TestExport(), 'datos_pacientes_prueba.xlsx');
});
