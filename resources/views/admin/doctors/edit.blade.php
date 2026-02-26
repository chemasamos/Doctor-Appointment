<x-admin-layout
    title="Editar Doctor | Admin"
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
            'name' => 'Editar',
        ],
    ]">

    {{-- Header Card --}}
    <div class="bg-white border rounded-lg shadow-sm p-8 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- Avatar + Info --}}
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-user-doctor text-green-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-800">{{ $doctor->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $doctor->user->email }}</p>
                    <p class="text-sm text-gray-500">
                        Cédula: {{ $doctor->medical_license_number ?? 'N/A' }}
                    </p>
                    @if($doctor->biography)
                        <p class="text-sm text-gray-400 mt-1 italic">
                            {{ Str::limit($doctor->biography, 60) }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex space-x-3">
                <x-wire-button flat secondary href="{{ route('admin.doctors.index') }}">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Volver
                </x-wire-button>

                <x-wire-button blue type="submit" form="edit-doctor-form">
                    <i class="fa-solid fa-check mr-2"></i>
                    Guardar cambios
                </x-wire-button>
            </div>

        </div>
    </div>

    {{-- Formulario de edición --}}
    <form id="edit-doctor-form" action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PUT')

        <x-wire-card>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Especialidad (Full Width, Half at lg) --}}
                <div class="lg:col-span-2 lg:w-1/2">
                    <x-wire-native-select
                        label="Especialidad"
                        name="speciality_id"
                        required>
                        <option value="">Selecciona una especialidad</option>
                        @foreach($specialities as $id => $name)
                            <option value="{{ $id }}"
                                @if(old('speciality_id', $doctor->speciality_id) == $id) selected @endif>
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-wire-native-select>
                </div>

                {{-- N° Licencia Médica (Full Width, Half at lg) --}}
                <div class="lg:col-span-2 lg:w-1/2">
                    <x-wire-input
                        name="medical_license_number"
                        label="N° Licencia Médica"
                        placeholder="Número de cédula profesional"
                        inputmode="numeric"
                        value="{{ old('medical_license_number', $doctor->medical_license_number) }}"
                    />
                </div>

                {{-- Biografía (Full Width) --}}
                <div class="lg:col-span-2">
                    <x-wire-textarea
                        name="biography"
                        label="Biografía"
                        placeholder="Breve descripción profesional del doctor..."
                        :value="old('biography', $doctor->biography)"
                    />
                </div>

            </div>
        </x-wire-card>

    </form>

</x-admin-layout>
