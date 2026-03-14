<x-admin-layout
    title="Citas | Admin"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Citas',
        ],
    ]">

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.appointments.create') }}">
            <i class="fa-solid fa-plus mr-2"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

    {{-- Flash alert --}}
    @if (session('alert'))
        @php $alert = session('alert'); @endphp
        <div class="mt-4 p-4 rounded-lg text-sm font-medium
            {{ $alert['type'] === 'success' ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}">
            <i class="fa-solid {{ $alert['type'] === 'success' ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-2"></i>
            {{ $alert['message'] }}
        </div>
    @endif

    <div class="mt-4">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-12">#</th>
                        <th scope="col" class="px-6 py-3">Paciente</th>
                        <th scope="col" class="px-6 py-3">Doctor</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Hora</th>
                        <th scope="col" class="px-6 py-3">Hora Fin</th>
                        <th scope="col" class="px-6 py-3">Estado</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $appointments->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ $appointment->patient->user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $appointment->doctor->user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $appointment->date->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ substr($appointment->start_time, 0, 5) }}
                            </td>
                            <td class="px-6 py-4">
                                {{ substr($appointment->end_time, 0, 5) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($appointment->status === 1)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        Programado
                                    </span>
                                @elseif($appointment->status === 2)
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        Completado
                                    </span>
                                @elseif($appointment->status === 3)
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        Cancelado
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        Desconocido
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @include('admin.appointments.actions', ['appointment' => $appointment])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-400">
                                <i class="fa-solid fa-calendar-xmark text-3xl mb-2 block"></i>
                                No hay citas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if($appointments->hasPages())
            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
