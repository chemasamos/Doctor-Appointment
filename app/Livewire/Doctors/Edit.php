<?php

namespace App\Livewire\Doctors;

use App\Models\Doctor;
use App\Models\Speciality;
use Livewire\Component;

class Edit extends Component
{
    public Doctor $doctor;
    public $speciality_id;
    public $medical_license_number;
    public $biography;
    public $specialities;

    public function mount($doctorId)
    {
        $this->doctor = Doctor::with(['user', 'speciality'])->findOrFail($doctorId);
        $this->speciality_id = $this->doctor->speciality_id;
        $this->medical_license_number = $this->doctor->medical_license_number;
        $this->biography = $this->doctor->biography;
        $this->specialities = Speciality::orderBy('name')->get();
    }

    public function save()
    {
        $this->validate([
            'speciality_id' => 'nullable|exists:specialities,id',
            'medical_license_number' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
        ]);

        $this->doctor->update([
            'speciality_id' => $this->speciality_id,
            'medical_license_number' => $this->medical_license_number,
            'biography' => $this->biography,
        ]);

        session()->flash('success', 'Doctor actualizado correctamente.');
        $this->redirect(route('admin.doctors.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.doctors.edit');
    }
}
