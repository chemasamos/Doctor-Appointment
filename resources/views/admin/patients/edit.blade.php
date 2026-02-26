<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index')
    ],
    [
        'name' => 'Editar'
    ]
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Card con encabezado: foto, nombre y botones --}}
        <x-wire-card class="mb-8">
            <div class="flex justify-between items-center lg:flex lg:justify-between lg:items-center">
                {{-- Foto + Nombre --}}
                <div class="flex items-center">
                    <img src="{{ $patient->user->profile_photo_url }}"
                         alt="{{ $patient->user->name }}"
                         class="h-20 w-20 rounded-full object-cover">
                    <div class="ml-4">
                        <p class="font-bold text-2xl">{{ $patient->user->name }}</p>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">
                        Volver
                    </x-wire-button>

                    <x-wire-button type="submit">
                        <i class="fa-solid fa-check mr-2"></i>
                        Guardar Cambios
                    </x-wire-button>
                </div>
            </div>
        </x-wire-card>

        {{-- Card con el sistema de pestañas --}}
        <x-wire-card>
            <x-tabs :active="$initialTab">

                {{-- ── Encabezados de pestañas ── --}}
                <x-slot name="header">

                    <x-tab-link tab="datos_personales">
                        <i class="fa-solid fa-user"></i>
                        Datos Personales
                    </x-tab-link>

                    <x-tab-link tab="antecedentes"
                                :error="$errors->hasAny(['allergies','chronic_conditions','surgical_history','family_history'])">
                        <i class="fa-solid fa-file-lines"></i>
                        Antecedentes
                    </x-tab-link>

                    <x-tab-link tab="informacion_general"
                                :error="$errors->hasAny(['blood_type_id','observations'])">
                        <i class="fa-solid fa-info"></i>
                        Información General
                    </x-tab-link>

                    <x-tab-link tab="contacto_emergencia"
                                :error="$errors->hasAny(['emergency_contact_name','emergency_contact_phone','emergency_contact_relationship'])">
                        <i class="fa-solid fa-heart"></i>
                        Contacto de Emergencia
                    </x-tab-link>

                </x-slot>

                {{-- ── Contenidos de pestañas ── --}}

                {{-- Tab 1: Datos Personales --}}
                <x-tab-content tab="datos_personales">

                    {{-- Alerta informativa --}}
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                        <div class="flex flex-row items-center gap-4">
                            <div class="flex items-start flex-shrink-0">
                                <i class="fa-solid fa-user-gear text-blue-500 text-2xl mt-1"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-bold text-blue-800">Edición de Cuenta de Usuario</h3>
                                <div class="mt-1 text-sm text-gray-700">
                                    <p>
                                        La información de acceso
                                        <strong>(nombre, email y contraseña)</strong>
                                        debe gestionarse desde la cuenta de usuario asociada.
                                    </p>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <x-wire-button primary href="{{ route('admin.users.edit', $patient->user) }}" target="_blank">
                                    Editar Usuario
                                    <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
                                </x-wire-button>
                            </div>
                        </div>
                    </div>

                    {{-- Grid de información de solo lectura --}}
                    <div class="grid lg:grid-cols-2 gap-4">
                        <div></div>

                        <span class="text-gray-900 text-sm font-semibold ml-1">Teléfono:</span>
                        <span class="text-gray-500 text-sm">{{ $patient->user->phone }}</span>

                        <span class="text-gray-900 text-sm font-semibold ml-1">Email:</span>
                        <span class="text-gray-500 text-sm">{{ $patient->user->email }}</span>

                        <span class="text-gray-900 text-sm font-semibold ml-1">Dirección:</span>
                        <span class="text-gray-500 text-sm">{{ $patient->user->address }}</span>
                    </div>

                </x-tab-content>

                {{-- Tab 2: Antecedentes --}}
                <x-tab-content tab="antecedentes">
                    <div class="grid lg:grid-cols-2 gap-4">

                        <x-wire-textarea
                            label="Alergias conocidas"
                            name="allergies"
                            :value="old('allergies', $patient->allergies)"
                            placeholder="Ejemplo: mariscos, penicilina..."
                        />

                        <x-wire-textarea
                            label="Enfermedades crónicas"
                            name="chronic_conditions"
                            :value="old('chronic_conditions', $patient->chronic_conditions)"
                        />

                        <x-wire-textarea
                            label="Antecedentes quirúrgicos"
                            name="surgical_history"
                            :value="old('surgical_history', $patient->surgical_history)"
                        />

                        <x-wire-textarea
                            label="Antecedentes familiares"
                            name="family_history"
                            :value="old('family_history', $patient->family_history)"
                        />

                    </div>
                </x-tab-content>

                {{-- Tab 3: Información General --}}
                <x-tab-content tab="informacion_general">
                    <div class="grid lg:grid-cols-2 gap-4">

                        <x-wire-native-select
                            label="Tipo de sangre"
                            name="blood_type_id"
                            class="mb-4">
                            <option value="">Selecciona un tipo de sangre</option>
                            @foreach($bloodTypes as $bloodType)
                                <option
                                    value="{{ $bloodType->id }}"
                                    @if(old('blood_type_id', $patient->blood_type_id) == $bloodType->id) selected @endif>
                                    {{ $bloodType->name }}
                                </option>
                            @endforeach
                        </x-wire-native-select>

                        <x-wire-textarea
                            label="Observaciones"
                            name="observations"
                            :value="old('observations', $patient->observations)"
                        />

                    </div>
                </x-tab-content>

                {{-- Tab 4: Contacto de Emergencia --}}
                <x-tab-content tab="contacto_emergencia">
                    <div class="space-y-4">

                        <x-wire-input
                            label="Nombre de contacto"
                            name="emergency_contact_name"
                            :value="old('emergency_contact_name', $patient->emergency_contact_name)"
                        />

                        <x-wire-input
                            label="Teléfono de contacto"
                            name="emergency_contact_phone"
                            placeholder="(555) 123-4567"
                            :value="old('emergency_contact_phone', $patient->emergency_contact_phone)"
                            x-mask="(999) 999-9999"
                        />

                        <x-wire-input
                            label="Relación con el contacto"
                            name="emergency_contact_relationship"
                            placeholder="Ejemplo: familiar, amigo..."
                            :value="old('emergency_contact_relationship', $patient->emergency_contact_relationship)"
                        />

                    </div>
                </x-tab-content>

            </x-tabs>
        </x-wire-card>

    </form>

</x-admin-layout>
