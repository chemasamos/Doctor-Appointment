<x-admin-layout
    title="Aseguradoras | Admin"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Aseguradoras',
        ],
    ]">

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.insurances.create') }}">
            <i class="fa-solid fa-plus mr-2"></i>
            Nueva Aseguradora
        </x-wire-button>
    </x-slot>

    <div class="mt-4">
        {{-- Tabla de aseguradoras --}}
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-12">#</th>
                        <th scope="col" class="px-6 py-3">Nombre de la empresa</th>
                        <th scope="col" class="px-6 py-3">Teléfono de contacto</th>
                        <th scope="col" class="px-6 py-3">Fecha de registro</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($insurances as $insurance)
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $insurances->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $insurance->nombre_empresa }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $insurance->telefono_contacto }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $insurance->fecha_registro }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                <i class="fa-solid fa-shield-halved text-3xl mb-2 block"></i>
                                No hay aseguradoras registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($insurances->hasPages())
            <div class="mt-4">
                {{ $insurances->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
