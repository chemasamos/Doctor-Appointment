<x-admin-layout
    title="{{ $doctor->user->name }} | Admin"
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
            'name' => $doctor->user->name,
        ],
    ]">

    <x-wire-card>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Información Personal --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user text-blue-500"></i>
                    Información Personal
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombre</dt>
                        <dd class="text-gray-800 mt-0.5">{{ $doctor->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</dt>
                        <dd class="text-gray-800 mt-0.5">{{ $doctor->user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Teléfono</dt>
                        <dd class="text-gray-800 mt-0.5">{{ $doctor->user->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Identificación</dt>
                        <dd class="text-gray-800 mt-0.5">{{ $doctor->user->id_number ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Información Profesional --}}
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-stethoscope text-green-500"></i>
                    Información Profesional
                </h3>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Especialidad</dt>
                        <dd class="text-gray-800 mt-0.5">{{ $doctor->speciality->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cédula Profesional</dt>
                        <dd class="text-gray-800 mt-0.5">{{ $doctor->medical_license_number ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Biografía (Full Width) --}}
            <div class="lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-file-lines text-purple-500"></i>
                    Biografía
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $doctor->biography ?? 'Sin biografía registrada.' }}
                </p>
            </div>

        </div>

        {{-- Footer con botones --}}
        <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-100">
            <x-wire-button flat secondary href="{{ route('admin.doctors.index') }}">
                <i class="fa-solid fa-arrow-left mr-2"></i>
                Volver
            </x-wire-button>

            <x-wire-button blue href="{{ route('admin.doctors.edit', $doctor) }}">
                <i class="fa-solid fa-pen-to-square mr-2"></i>
                Editar
            </x-wire-button>
        </div>

    </x-wire-card>

</x-admin-layout>
