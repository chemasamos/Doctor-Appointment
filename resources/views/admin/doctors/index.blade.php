<x-admin-layout
    title="Doctores | Admin"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Doctores',
        ],
    ]">

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.doctors.create') }}">
            <i class="fa-solid fa-plus mr-2"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    @livewire('admin.data-tables.doctor-table')

</x-admin-layout>
