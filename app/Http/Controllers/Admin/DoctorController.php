<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.doctors.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialities = Speciality::pluck('name', 'id')->toArray();
        return view('admin.doctors.create', compact('specialities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                   => 'required|string|max:255',
            'email'                  => 'required|email|unique:users,email',
            'id_number'              => 'required|string|unique:users,id_number',
            'phone'                  => 'required|string|max:20',
            'address'                => 'required|string|max:255',
            'password'               => 'required|string|min:8|confirmed',
            'speciality_id'          => 'required|exists:specialities,id',
            'medical_license_number' => 'nullable|digits_between:1,20',
            'biography'              => 'nullable|string|min:10|max:1000',
        ]);

        // Crear usuario
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'id_number' => $request->id_number,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'password'  => bcrypt($request->password),
        ]);

        // Asignar rol Doctor
        $user->assignRole('Doctor');

        // Crear doctor
        $doctor = Doctor::create([
            'user_id'                => $user->id,
            'speciality_id'          => $request->speciality_id,
            'medical_license_number' => $request->medical_license_number,
            'biography'              => $request->biography,
        ]);

        session()->flash('alert', [
            'type'    => 'success',
            'message' => 'Doctor creado correctamente',
        ]);

        return redirect()->route('admin.doctors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'speciality']);
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $doctor->load(['user', 'speciality']);
        $specialities = Speciality::pluck('name', 'id')->toArray();
        return view('admin.doctors.edit', compact('doctor', 'specialities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'speciality_id'          => 'required|exists:specialities,id',
            'medical_license_number' => 'nullable|digits_between:1,20',
            'biography'              => 'nullable|string|min:10|max:1000',
        ]);

        $doctor->update([
            'speciality_id'          => $request->speciality_id,
            'medical_license_number' => $request->medical_license_number,
            'biography'              => $request->biography,
        ]);

        session()->flash('alert', [
            'type'    => 'success',
            'message' => 'Doctor actualizado correctamente',
        ]);

        return redirect()->route('admin.doctors.edit', $doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete();

        session()->flash('alert', [
            'type'    => 'success',
            'message' => 'Doctor eliminado correctamente',
        ]);

        return redirect()->route('admin.doctors.index');
    }
}
