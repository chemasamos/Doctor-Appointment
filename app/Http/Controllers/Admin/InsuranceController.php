<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsuranceRequest;
use App\Models\Insurance;

// No se importa la clase Request base de Laravel: toda validación pasa por InsuranceRequest.

class InsuranceController extends Controller
{
    /**
     * Listado de aseguradoras paginado, ordenado por más recientes primero.
     */
    public function index()
    {
        $insurances = Insurance::latest()->paginate(10);

        return view('admin.insurances.index', compact('insurances'));
    }

    /**
     * Formulario de creación de nueva aseguradora.
     */
    public function create()
    {
        return view('admin.insurances.create');
    }

    /**
     * Guarda la nueva aseguradora en base de datos.
     *
     * $request->validated() garantiza que solo se persistan los campos
     * que pasaron las reglas del Form Request, nunca datos extras del payload.
     */
    public function store(InsuranceRequest $request)
    {
        Insurance::create($request->validated());

        // Se usa el patrón session('alert') consistente con el resto del proyecto
        // (DoctorController, UserController, etc.), no session('success').
        session()->flash('alert', [
            'type'    => 'success',
            'message' => 'Aseguradora registrada correctamente.',
        ]);

        return redirect()->route('admin.insurances.index');
    }
}
