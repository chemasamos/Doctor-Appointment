<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Doctores',
        'href' => route('admin.doctors.index')
    ],
    [
        'name' => 'Editar'
    ]
]">
    @livewire('doctors.edit', ['doctorId' => $doctor->id])
</x-admin-layout>
