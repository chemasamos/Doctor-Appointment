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
            Nuevo
        </x-wire-button>
    </x-slot>

    <div class="bg-white rounded-lg shadow-sm p-6 mt-4">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Los datos se mostrarán aquí cuando implementes la funcionalidad -->
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Tabla de usuarios - Funcionalidad pendiente
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>