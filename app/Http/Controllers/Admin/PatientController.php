<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Flash;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.patients.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::where('name', 'Paciente')->firstOrFail();
        return view('admin.patients.create', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        // Cargar relación de usuario
        $patient->load('user');

        // Obtener catálogo de tipos de sangre
        $bloodTypes = \App\Models\BloodType::all();

        // Pestaña inicial: puede venir de sesión (si hubo errores en update)
        $initialTab = session('initialTab', 'datos_personales');

        return view('admin.patients.edit', compact('patient', 'bloodTypes', 'initialTab'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        // Mapa de pestañas y sus campos para detectar dónde están los errores
        $tabFields = [
            'antecedentes'       => ['allergies', 'chronic_conditions', 'surgical_history', 'family_history'],
            'informacion_general' => ['blood_type_id', 'observations'],
            'contacto_emergencia' => ['emergency_contact_name', 'emergency_contact_relationship', 'emergency_contact_phone'],
        ];

        // Validar datos
        $data = $request->validate([
            'blood_type_id'                  => 'nullable|exists:blood_types,id',
            'allergies'                      => 'nullable|string|min:3|max:255',
            'chronic_conditions'             => 'nullable|string|min:3|max:255',
            'surgical_history'               => 'nullable|string|min:3|max:255',
            'family_history'                 => 'nullable|string|min:3|max:255',
            'observations'                   => 'nullable|string|min:3|max:255',
            'emergency_contact_name'         => 'nullable|string|min:3|max:50',
            'emergency_contact_relationship' => 'nullable|string|min:3|max:50',
            'emergency_contact_phone'        => 'nullable|string|min:14|max:14',
        ]);

        // SANITIZAR teléfono: eliminar paréntesis, espacios y guiones
        if (isset($data['emergency_contact_phone'])) {
            $data['emergency_contact_phone'] = preg_replace('/[^0-9]/', '', $data['emergency_contact_phone']);
        }

        // Actualizar paciente
        $patient->update($data);

        // Redireccionar con mensaje de éxito
        session()->flash('alert', [
            'type'    => 'success',
            'message' => 'Paciente actualizado correctamente',
        ]);

        return redirect()->route('admin.patients.edit', $patient);
    }

    /**
     * Detecta en qué pestaña está el primer error de validación.
     */
    private function getInitialTabFromErrors(array $tabFields): string
    {
        foreach ($tabFields as $tab => $fields) {
            foreach ($fields as $field) {
                if (request()->hasSession() && session('errors') && session('errors')->has($field)) {
                    return $tab;
                }
            }
        }
        return 'datos_personales';
    }
}
