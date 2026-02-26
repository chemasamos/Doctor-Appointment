<?php

namespace App\Livewire\Admin\DataTables;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class DoctorTable extends DataTableComponent
{
    protected $model = Doctor::class;

    public function builder(): Builder
    {
        return Doctor::query()->with(['user', 'speciality']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable(),

            Column::make('Nombre', 'user.name')
                ->sortable()
                ->searchable(),

            Column::make('Especialidad', 'speciality.name')
                ->sortable()
                ->searchable(),

            Column::make('N° Licencia Médica', 'medical_license_number')
                ->sortable()
                ->format(function ($value) {
                    return $value ?? 'N/A';
                }),

            Column::make('Biografía', 'biography')
                ->format(function ($value) {
                    return $value ? Str::limit($value, 50) : 'N/A';
                }),

            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.doctors.actions', ['doctor' => $row]);
                }),
        ];
    }
}
