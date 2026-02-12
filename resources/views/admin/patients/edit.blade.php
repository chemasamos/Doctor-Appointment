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

    @php
        // Definir qué campos pertenecen a cada pestaña
        $errorTabs = [
            'antecedentes' => ['allergies', 'chronic_conditions', 'surgical_history', 'family_history'],
            'informacion_general' => ['blood_type_id', 'observations'],
            'contacto_emergencia' => ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship']
        ];

        // Pestaña por defecto
        $initialTab = 'datos_personales';

        // Si hay errores, detectar en qué pestaña están
        foreach ($errorTabs as $tabName => $fields) {
            if ($errors->hasAny($fields)) {
                $initialTab = $tabName;
                break; // Detener en el primer error encontrado
            }
        }
    @endphp
        @csrf
        @method('PUT')
        
        {{-- Card con encabezado --}}
        <x-wire-card class="mb-8">
            <div class="flex justify-between items-center lg:flex lg:justify-between lg:items-center">
                {{-- Lado izquierdo: Foto + Nombre --}}
                <div class="flex items-center">
                    <img src="{{ $patient->user->profile_photo_url }}" 
                        alt="{{ $patient->user->name }}"
                        class="h-20 w-20 rounded-full object-cover">
                    
                    <div class="ml-4">
                        <p class="font-bold text-2xl">{{ $patient->user->name }}</p>
                    </div>
                </div>
                
                {{-- Lado derecho: Botones --}}
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

        <x-wire-card>
            <div x-data="{ tab: '{{ $initialTab }}' }">
                
                {{-- Menú de pestañas --}}
                <div class="border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500">
                        
                        {{-- Tab 1: Datos Personales --}}
                        <li class="me-2">
                            <a href="#" 
                            @click.prevent="tab = 'datos_personales'"
                            :class="tab === 'datos_personales' 
                                ? 'text-blue-600 border-blue-600 active' 
                                : 'text-gray-500 border-transparent hover:text-blue-600 hover:border-gray-300'"
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg group transition-colors duration-200">
                                
                                <i class="fa-solid fa-user mr-2"></i>
                                Datos Personales
                            </a>
                        </li>
                        
                        {{-- Tab 2: Antecedentes --}}
                        @php
                            $hasErrorAntecedentes = $errors->hasAny($errorTabs['antecedentes']);
                        @endphp
                        
                        <li class="me-2">
                            <a href="#" 
                            @click.prevent="tab = 'antecedentes'"
                            :class="{
                                'text-red-600 border-red-600': {{ $hasErrorAntecedentes ? 'true' : 'false' }} && tab !== 'antecedentes',
                                'text-red-600 border-red-600 active': {{ $hasErrorAntecedentes ? 'true' : 'false' }} && tab === 'antecedentes',
                                'text-blue-600 border-blue-600 active': !{{ $hasErrorAntecedentes ? 'true' : 'false' }} && tab === 'antecedentes',
                                'text-gray-500 border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'antecedentes' && !{{ $hasErrorAntecedentes ? 'true' : 'false' }}
                            }"
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg transition-colors duration-200">
                                
                                <i class="fa-solid fa-file-lines mr-2"></i>
                                Antecedentes
                                
                                @if($hasErrorAntecedentes)
                                    <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
                                @endif
                            </a>
                        </li>
                        
                        {{-- Tab 3: Información General --}}
                        @php
                            $hasErrorInfoGeneral = $errors->hasAny($errorTabs['informacion_general']);
                        @endphp
                        
                        <li class="me-2">
                            <a href="#" 
                            @click.prevent="tab = 'informacion_general'"
                            :class="{
                                'text-red-600 border-red-600': {{ $hasErrorInfoGeneral ? 'true' : 'false' }} && tab !== 'informacion_general',
                                'text-red-600 border-red-600 active': {{ $hasErrorInfoGeneral ? 'true' : 'false' }} && tab === 'informacion_general',
                                'text-blue-600 border-blue-600 active': !{{ $hasErrorInfoGeneral ? 'true' : 'false' }} && tab === 'informacion_general',
                                'text-gray-500 border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'informacion_general' && !{{ $hasErrorInfoGeneral ? 'true' : 'false' }}
                            }"
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg transition-colors duration-200">
                                
                                <i class="fa-solid fa-info mr-2"></i>
                                Información General
                                
                                @if($hasErrorInfoGeneral)
                                    <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
                                @endif
                            </a>
                        </li>
                        
                        {{-- Tab 4: Contacto de Emergencia --}}
                        @php
                            $hasErrorContacto = $errors->hasAny($errorTabs['contacto_emergencia']);
                        @endphp
                        
                        <li class="me-2">
                            <a href="#" 
                            @click.prevent="tab = 'contacto_emergencia'"
                            :class="{
                                'text-red-600 border-red-600': {{ $hasErrorContacto ? 'true' : 'false' }} && tab !== 'contacto_emergencia',
                                'text-red-600 border-red-600 active': {{ $hasErrorContacto ? 'true' : 'false' }} && tab === 'contacto_emergencia',
                                'text-blue-600 border-blue-600 active': !{{ $hasErrorContacto ? 'true' : 'false' }} && tab === 'contacto_emergencia',
                                'text-gray-500 border-transparent hover:text-blue-600 hover:border-gray-300': tab !== 'contacto_emergencia' && !{{ $hasErrorContacto ? 'true' : 'false' }}
                            }"
                            class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg transition-colors duration-200">
                                
                                <i class="fa-solid fa-heart mr-2"></i>
                                Contacto de Emergencia
                                
                                @if($hasErrorContacto)
                                    <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
                                @endif
                            </a>
                        </li>
                        
                    </ul>
                </div>

                {{-- Contenido de pestañas --}}
                <div class="p-4 mt-4">
                    
                    {{-- Tab 1: Datos Personales --}}
                    <div x-show="tab === 'datos_personales'">
                        
                        {{-- Alerta informativa personalizada --}}
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg shadow-sm">
                            <div class="flex flex-row items-center gap-4">
                                {{-- Ícono --}}
                                <div class="flex items-start flex-shrink-0">
                                    <i class="fa-solid fa-user-gear text-blue-500 text-2xl mt-1"></i>
                                </div>
                                
                                {{-- Texto --}}
                                <div class="ml-3">
                                    <h3 class="text-sm font-bold text-blue-800">
                                        Edición de Cuenta de Usuario
                                    </h3>
                                    <div class="mt-1 text-sm text-gray-700">
                                        <p>
                                            La información de acceso 
                                            <strong>(nombre, email y contraseña)</strong>
                                            debe gestionarse desde la cuenta de usuario asociada.
                                        </p>
                                    </div>
                                </div>
                                
                                {{-- Botón a la derecha --}}
                                <div class="flex-shrink-0">
                                    <x-wire-button 
                                        primary 
                                        href="{{ route('admin.users.edit', $patient->user) }}"
                                        target="_blank">
                                        Editar Usuario
                                        <i class="fa-solid fa-arrow-up-right-from-square ml-2"></i>
                                    </x-wire-button>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Grid de información de solo lectura --}}
                        <div class="grid lg:grid-cols-2 gap-4">
                            <div></div>
                            
                            <span class="text-gray-900 text-sm font-semibold ml-1">
                                Teléfono:
                            </span>
                            <span class="text-gray-500 text-sm">
                                {{ $patient->user->phone }}
                            </span>
                            
                            <span class="text-gray-900 text-sm font-semibold ml-1">
                                Email:
                            </span>
                            <span class="text-gray-500 text-sm">
                                {{ $patient->user->email }}
                            </span>
                            
                            <span class="text-gray-900 text-sm font-semibold ml-1">
                                Dirección:
                            </span>
                            <span class="text-gray-500 text-sm">
                                {{ $patient->user->address }}
                            </span>
                        </div>
                        
                    </div>

                    {{-- Tab 2: Antecedentes --}}
                    <div x-show="tab === 'antecedentes'" style="display: none;">
                        
                        <div class="grid lg:grid-cols-2 gap-4">
                            
                            {{-- Alergias conocidas --}}
                            <x-wire-textarea 
                                label="Alergias conocidas"
                                name="allergies"
                                :value="old('allergies', $patient->allergies)"
                                placeholder="Ejemplo: mariscos, penicilina..."
                            />
                            
                            {{-- Enfermedades crónicas --}}
                            <x-wire-textarea 
                                label="Enfermedades crónicas"
                                name="chronic_conditions"
                                :value="old('chronic_conditions', $patient->chronic_conditions)"
                            />
                            
                            {{-- Antecedentes quirúrgicos --}}
                            <x-wire-textarea 
                                label="Antecedentes quirúrgicos"
                                name="surgical_history"
                                :value="old('surgical_history', $patient->surgical_history)"
                            />
                            
                            {{-- Antecedentes familiares --}}
                            <x-wire-textarea 
                                label="Antecedentes familiares"
                                name="family_history"
                                :value="old('family_history', $patient->family_history)"
                            />
                            
                        </div>
                        
                    </div>

                    {{-- Tab 3: Información General --}}
                    <div x-show="tab === 'informacion_general'" style="display: none;">
                        
                        <div class="grid lg:grid-cols-2 gap-4">
                            
                            {{-- Select de tipo de sangre --}}
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
                            
                            {{-- Observaciones --}}
                            <x-wire-textarea 
                                label="Observaciones"
                                name="observations"
                                :value="old('observations', $patient->observations)"
                            />
                            
                        </div>
                        
                    </div>

                    {{-- Tab 4: Contacto de Emergencia --}}
                    <div x-show="tab === 'contacto_emergencia'" style="display: none;">
                        
                        <div class="space-y-4">
                            
                            {{-- Nombre de contacto --}}
                            <x-wire-input 
                                label="Nombre de contacto"
                                name="emergency_contact_name"
                                :value="old('emergency_contact_name', $patient->emergency_contact_name)"
                            />
                            
                            {{-- Teléfono con máscara de Alpine.js --}}
                            <x-wire-input 
                                label="Teléfono de contacto"
                                name="emergency_contact_phone"
                                placeholder="(555) 123-4567"
                                :value="old('emergency_contact_phone', $patient->emergency_contact_phone)"
                                x-mask="(999) 999-9999"
                            />
                            
                            {{-- Relación con el contacto --}}
                            <x-wire-input 
                                label="Relación con el contacto"
                                name="emergency_contact_relationship"
                                placeholder="Ejemplo: familiar, amigo..."
                                :value="old('emergency_contact_relationship', $patient->emergency_contact_relationship)"
                            />
                            
                        </div>
                        
                    </div>
                    
                </div> {{-- Cierre de contenido de pestañas --}}
            </div> {{-- Cierre de Alpine.js container --}}
        </x-wire-card>

    </form> {{-- Cierre del formulario --}}

</x-admin-layout>
