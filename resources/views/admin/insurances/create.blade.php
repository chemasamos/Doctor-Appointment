<x-admin-layout
    title="Nueva Aseguradora | Admin"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Aseguradoras',
            'href' => route('admin.insurances.index'),
        ],
        [
            'name' => 'Nueva Aseguradora',
        ],
    ]">

    <x-wire-card class="mt-4" title="Registrar Aseguradora">

        <p class="text-sm text-gray-500 mb-6">
            Complete los datos de la nueva aseguradora para agregarla al directorio.
        </p>

        <form action="{{ route('admin.insurances.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

                {{-- Nombre de la empresa --}}
                <x-wire-input
                    name="nombre_empresa"
                    label="Nombre de la empresa"
                    placeholder="Ej. AXA Seguros S.A. de C.V."
                    autocomplete="organization"
                    required
                    value="{{ old('nombre_empresa') }}"
                />

                {{-- Teléfono de contacto --}}
                <x-wire-input
                    name="telefono_contacto"
                    label="Teléfono de contacto"
                    placeholder="Ej. 55 1234 5678"
                    type="tel"
                    required
                    value="{{ old('telefono_contacto') }}"
                />

                {{-- Notas adicionales (ancho completo) --}}
                <div class="lg:col-span-2">
                    <x-wire-textarea
                        name="notas_adicionales"
                        label="Notas adicionales"
                        placeholder="Información relevante: convenios, horarios de atención, contacto..."
                        rows="5"
                        :value="old('notas_adicionales')"
                    />
                </div>

            </div>

            <div class="flex justify-end gap-3">
                <x-wire-button
                    flat
                    secondary
                    type="button"
                    label="Cancelar"
                    onclick="window.location='{{ route('admin.insurances.index') }}'"
                />
                <x-wire-button
                    type="submit"
                    blue
                    label="Guardar Aseguradora"
                />
            </div>

        </form>
    </x-wire-card>

</x-admin-layout>
