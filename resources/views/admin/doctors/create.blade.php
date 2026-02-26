<x-admin-layout
    title="Nuevo Doctor | Admin"
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
            'name' => 'Nuevo',
        ],
    ]">

    <x-wire-card class="mt-4" title="Nuevo Doctor">
        <form action="{{ route('admin.doctors.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

                {{-- Nombre --}}
                <x-wire-input
                    name="name"
                    label="Nombre"
                    placeholder="Nombre completo"
                    autocomplete="name"
                    required
                    value="{{ old('name') }}"
                />

                {{-- Email --}}
                <x-wire-input
                    name="email"
                    label="Email"
                    placeholder="correo@ejemplo.com"
                    type="email"
                    autocomplete="email"
                    required
                    value="{{ old('email') }}"
                />

                {{-- Matrícula / ID --}}
                <x-wire-input
                    name="id_number"
                    label="Matrícula / ID"
                    placeholder="Identificación única"
                    required
                    value="{{ old('id_number') }}"
                />

                {{-- Teléfono --}}
                <x-wire-input
                    name="phone"
                    label="Teléfono"
                    placeholder="1234567890"
                    type="tel"
                    required
                    value="{{ old('phone') }}"
                />

                {{-- Contraseña --}}
                <x-wire-input
                    name="password"
                    label="Contraseña"
                    placeholder="Mínimo 8 caracteres"
                    type="password"
                    autocomplete="new-password"
                    required
                />

                {{-- Confirmar contraseña --}}
                <x-wire-input
                    name="password_confirmation"
                    label="Confirmar contraseña"
                    placeholder="Repite la contraseña"
                    type="password"
                    required
                />

                {{-- Dirección (Full Width) --}}
                <div class="lg:col-span-2">
                    <x-wire-textarea
                        name="address"
                        label="Dirección"
                        placeholder="Calle, Número, Colonia..."
                        required
                        :value="old('address')"
                    />
                </div>

                {{-- Especialidad (Full Width, Half at lg) --}}
                <div class="lg:col-span-2 lg:w-1/2">
                    <x-wire-native-select
                        label="Especialidad"
                        name="speciality_id"
                        required>
                        <option value="">Selecciona una especialidad</option>
                        @foreach($specialities as $id => $name)
                            <option value="{{ $id }}" @if(old('speciality_id') == $id) selected @endif>
                                {{ $name }}
                            </option>
                        @endforeach
                    </x-wire-native-select>
                </div>

                {{-- N° Licencia Médica --}}
                <x-wire-input
                    name="medical_license_number"
                    label="N° Licencia Médica"
                    placeholder="Número de cédula profesional"
                    inputmode="numeric"
                    value="{{ old('medical_license_number') }}"
                />

                {{-- Biografía (Full Width) --}}
                <div class="lg:col-span-2">
                    <x-wire-textarea
                        name="biography"
                        label="Biografía"
                        placeholder="Breve descripción profesional del doctor..."
                        :value="old('biography')"
                    />
                </div>

            </div>

            <div class="flex justify-end">
                <x-wire-button type="submit" blue label="Guardar" />
            </div>
        </form>
    </x-wire-card>

    <div class="mt-4">
        <x-wire-button flat secondary href="{{ route('admin.doctors.index') }}">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Volver a la lista de doctores
        </x-wire-button>
    </div>

</x-admin-layout>
