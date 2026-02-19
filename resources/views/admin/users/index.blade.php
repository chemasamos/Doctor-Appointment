<x-admin-layout title="Usuarios | Simify"
:breadcrumbs="[
    [
      'name' => 'Dashboard',
      'href' => route('admin.dashboard')
    ],
    [
      'name' => 'Usuarios'
    ],
]">
    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.users.create')}}">
            <i class="fa-solid fa-plus"></i>
        </x-wire-button>
    </x-slot>

    @livewire('admin.datatables.user-table')

    @push('scripts')
    @push('scripts')
    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto. El usuario será eliminado (papelera).",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#3b82f6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
    @endpush
</x-admin-layout>