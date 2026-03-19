<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Mail\AppointmentConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor.user'])
            ->orderByDesc('date')
            ->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors  = Doctor::with('user')->get();

        return view('admin.appointments.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'reason'     => 'required|string|max:1000',
        ], [
            'patient_id.required'     => 'Debe seleccionar un paciente.',
            'patient_id.exists'       => 'El paciente seleccionado no es válido.',
            'doctor_id.required'      => 'Debe seleccionar un doctor.',
            'doctor_id.exists'        => 'El doctor seleccionado no es válido.',
            'date.required'           => 'La fecha de la cita es obligatoria.',
            'date.after_or_equal'     => 'La fecha no puede ser en el pasado.',
            'start_time.required'     => 'La hora de inicio es obligatoria.',
            'end_time.required'       => 'La hora de fin es obligatoria.',
            'end_time.after'          => 'La hora de fin debe ser posterior a la hora de inicio.',
            'reason.required'         => 'El motivo de la consulta es obligatorio.',
        ]);

        // Calcular duración en minutos
        $start = \Carbon\Carbon::createFromTimeString($validated['start_time']);
        $end   = \Carbon\Carbon::createFromTimeString($validated['end_time']);
        $validated['duration'] = $start->diffInMinutes($end);

        $appointment = Appointment::create($validated);

        $appointment->load(['patient.user', 'doctor.user', 'doctor.speciality']);
        Mail::to($appointment->patient->user->email)
            ->send(new AppointmentConfirmation($appointment));

        session()->flash('alert', ['type' => 'success', 'message' => 'Cita registrada exitosamente.']);

        return redirect()->route('admin.appointments.index');
    }

    public function consult(Appointment $appointment)
    {
        $appointment->load([
            'patient.user',
            'patient.bloodType',
            'doctor.user',
            'consultation.prescriptionItems',
        ]);

        return view('admin.appointments.consult', compact('appointment'));
    }
}
