<div class="flex space-x-2">
    {{-- Ver --}}
    <x-wire-button xs secondary href="{{ route('admin.doctors.show', $doctor) }}">
        <i class="fa-solid fa-eye"></i>
    </x-wire-button>

    {{-- Editar --}}
    <x-wire-button xs blue href="{{ route('admin.doctors.edit', $doctor) }}">
        <i class="fa-solid fa-pen-to-square"></i>
    </x-wire-button>

    {{-- Eliminar --}}
    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este doctor?')">
        @csrf
        @method('DELETE')
        <x-wire-button xs red type="submit">
            <i class="fa-solid fa-trash"></i>
        </x-wire-button>
    </form>
</div>
