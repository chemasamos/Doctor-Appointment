<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\PrescriptionItem;

class ConsultationManager extends Component
{
    // Props
    public Appointment $appointment;

    // Tab activa (usar guión_bajo)
    public string $activeTab = 'consulta';

    // Campos pestaña Consulta
    public string $diagnosis = '';
    public string $treatment = '';
    public string $notes     = '';

    // Pestaña Receta: array de medicamentos
    public array $medications = [];

    // Estado de modales
    public bool $showHistoryModal  = false;
    public bool $showPreviousModal = false;

    // Consultas anteriores del paciente
    public $previousConsultations;

    public function mount(Appointment $appointment): void
    {
        $this->appointment = $appointment;
        $this->appointment->load([
            'patient.user',
            'patient.bloodType',
            'doctor.user',
            'consultation.prescriptionItems',
        ]);

        // Si ya existe una consulta guardada, cargar sus datos
        if ($this->appointment->consultation) {
            $this->diagnosis = $this->appointment->consultation->diagnosis ?? '';
            $this->treatment = $this->appointment->consultation->treatment ?? '';
            $this->notes     = $this->appointment->consultation->notes ?? '';

            $this->medications = $this->appointment->consultation->prescriptionItems
                ->map(fn($item) => [
                    'medication_name'    => $item->medication_name,
                    'dosage'             => $item->dosage,
                    'frequency_duration' => $item->frequency_duration ?? '',
                ])->toArray();
        }

        if (empty($this->medications)) {
            $this->medications = [['medication_name' => '', 'dosage' => '', 'frequency_duration' => '']];
        }

        // Cargar consultas anteriores del mismo paciente (excluyendo la actual)
        $this->previousConsultations = Appointment::with(['consultation', 'doctor.user'])
            ->where('patient_id', $this->appointment->patient_id)
            ->where('id', '!=', $this->appointment->id)
            ->whereHas('consultation')
            ->orderByDesc('date')
            ->get();
    }

    public function addMedication(): void
    {
        $this->medications[] = ['medication_name' => '', 'dosage' => '', 'frequency_duration' => ''];
    }

    public function removeMedication(int $index): void
    {
        unset($this->medications[$index]);
        $this->medications = array_values($this->medications);
    }

    public function saveConsultation(): void
    {
        $this->validate([
            'diagnosis'                      => 'required|string|min:3',
            'treatment'                      => 'required|string|min:3',
            'notes'                          => 'nullable|string',
            'medications.*.medication_name'  => 'required|string',
            'medications.*.dosage'           => 'required|string',
        ], [
            'diagnosis.required'                             => 'El diagnóstico es obligatorio.',
            'treatment.required'                             => 'El tratamiento es obligatorio.',
            'medications.*.medication_name.required'         => 'El nombre del medicamento es obligatorio.',
            'medications.*.dosage.required'                  => 'La dosis es obligatoria.',
        ]);

        // Crear o actualizar la consulta
        $consultation = Consultation::updateOrCreate(
            ['appointment_id' => $this->appointment->id],
            [
                'diagnosis' => $this->diagnosis,
                'treatment' => $this->treatment,
                'notes'     => $this->notes,
            ]
        );

        // Borrar items anteriores y recrear
        $consultation->prescriptionItems()->delete();
        foreach ($this->medications as $med) {
            if (!empty($med['medication_name'])) {
                $consultation->prescriptionItems()->create([
                    'medication_name'    => $med['medication_name'],
                    'dosage'             => $med['dosage'],
                    'frequency_duration' => $med['frequency_duration'] ?? null,
                ]);
            }
        }

        // Marcar cita como completada
        $this->appointment->update(['status' => 2]);

        session()->flash('alert', ['type' => 'success', 'message' => 'Consulta guardada exitosamente.']);

        $this->redirect(route('admin.appointments.index'));
    }

    public function render()
    {
        return view('livewire.admin.consultation-manager');
    }
}
