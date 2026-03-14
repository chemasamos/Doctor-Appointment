<div class="flex space-x-2">
    {{-- Editar --}}
    <x-wire-button xs blue href="{{ route('admin.appointments.create') }}">
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- Atender consulta --}}
    <x-wire-button xs green href="{{ route('admin.appointments.consult', $appointment) }}">
        <i class="fa-solid fa-stethoscope"></i>
    </x-wire-button>
</div>
