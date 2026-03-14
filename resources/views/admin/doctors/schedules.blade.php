<x-admin-layout
    title="Horarios | Admin"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Doctores',
            'href' => route('admin.doctors.index'),
        ],
        [
            'name' => 'Horarios',
        ],
    ]">

    <div class="mt-4 space-y-5">

        {{-- Card info del doctor --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-user-doctor text-2xl text-blue-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $doctor->user->name }}</h2>
                    <p class="text-sm text-gray-500">
                        <i class="fa-solid fa-stethoscope mr-1 text-blue-500"></i>
                        {{ $doctor->speciality->name ?? 'Sin especialidad' }}
                    </p>
                    @if($doctor->medical_license_number)
                        <p class="text-xs text-gray-400 mt-0.5">
                            <i class="fa-solid fa-id-badge mr-1"></i>
                            Cédula: {{ $doctor->medical_license_number }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card gestor de horarios --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">
                        <i class="fa-solid fa-calendar-week text-blue-600 mr-2"></i>
                        Gestor de Horarios
                    </h3>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Configure los días y franjas horarias de atención del doctor.
                    </p>
                </div>
                <span class="text-xs bg-amber-100 text-amber-700 font-semibold px-3 py-1 rounded-full">
                    <i class="fa-solid fa-clock mr-1"></i>
                    Próximamente
                </span>
            </div>

            {{-- Tabla de horarios (placeholder) --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-center text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">HORA</th>
                            <th class="px-4 py-3">Lunes</th>
                            <th class="px-4 py-3">Martes</th>
                            <th class="px-4 py-3">Miércoles</th>
                            <th class="px-4 py-3">Jueves</th>
                            <th class="px-4 py-3">Viernes</th>
                            <th class="px-4 py-3">Sábado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['08:00', '09:00', '10:00', '11:00', '12:00'] as $hour)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="px-4 py-3 text-left font-medium text-gray-700">
                                    <i class="fa-regular fa-clock mr-1 text-gray-400"></i>
                                    {{ $hour }}
                                </td>
                                @for ($i = 0; $i < 6; $i++)
                                    <td class="px-4 py-3">
                                        <input type="checkbox" disabled
                                            class="w-4 h-4 text-blue-600 border-gray-300 rounded cursor-not-allowed opacity-50">
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-5">
                <button type="button"
                    onclick="alert('Módulo de horarios disponible próximamente.')"
                    class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg px-5 py-2.5 text-sm transition">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Guardar Horario
                </button>
            </div>
        </div>

    </div>

</x-admin-layout>
