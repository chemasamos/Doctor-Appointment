<?php

namespace App\Exports;

use App\Models\Appointment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AppointmentsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Appointment::with(['patient.user', 'doctor.user'])->orderByDesc('date')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Paciente',
            'Doctor',
            'Fecha',
            'Hora Inicio',
            'Hora Fin',
            'Estado',
            'Motivo',
        ];
    }

    public function map($appointment): array
    {
        $statusMap = [
            1 => 'Programado',
            2 => 'Completado',
            3 => 'Cancelado',
        ];

        return [
            $appointment->id,
            $appointment->patient->user->name ?? 'N/A',
            $appointment->doctor->user->name ?? 'N/A',
            $appointment->date ? $appointment->date->format('d/m/Y') : '',
            substr($appointment->start_time, 0, 5),
            substr($appointment->end_time, 0, 5),
            $statusMap[$appointment->status] ?? 'Desconocido',
            $appointment->reason,
        ];
    }
}
