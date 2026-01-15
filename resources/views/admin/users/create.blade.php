<x-admin-layout title="Crear Usuario | Simify"
:breadcrumbs="[
    [
      'name' => 'Dashboard',
      'href' => route('admin.dashboard')
    ],
    [
      'name' => 'Usuarios',
      'href' => route('admin.users.index')
    ],
    [
      'name' => 'Crear'
    ],
]">
    <x-wire-card class="mt-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                {{-- Nombre --}}
                <x-wire-input 
                    name="name" 
                    label="Nombre" 
                    placeholder="Nombre completo"
                    autocomplete="name"
                    required
                    value="{{ old('name') }}"
                />

                {{-- ID Number --}}
                <x-wire-input 
                    name="id_number" 
                    label="Matrícula / ID" 
                    placeholder="Identificación única"
                    required
                    value="{{ old('id_number') }}"
                />

                {{-- Email --}}
                <x-wire-input 
                    name="email" 
                    label="Email" 
                    placeholder="correo@ejemplo.com"
                    type="email"
                    autocomplete="email"
                    required
                    input-mode="email"
                    value="{{ old('email') }}"
                />

                {{-- Teléfono --}}
                <x-wire-input 
                    name="phone" 
                    label="Teléfono" 
                    placeholder="1234567890"
                    type="tel"
                    required
                    input-mode="tel"
                    value="{{ old('phone') }}"
                />

                {{-- Rol --}}
                <div class="space-y-1">
                    <x-wire-native-select 
                        label="Rol" 
                        name="role_id" 
                        placeholder="Seleccione un rol" 
                        :options="$roles" 
                        option-label="name" 
                        option-value="id"
                        required
                    />
                    <p class="text-xs text-gray-500">Define los permisos y accesos del usuario.</p>
                </div>

                {{-- Dirección (Full Width) --}}
                <div class="col-span-1 sm:col-span-2">
                    <x-wire-input 
                        name="address" 
                        label="Dirección" 
                        placeholder="Calle, Número, Colonia..."
                        required
                        value="{{ old('address') }}"
                    />
                </div>

                {{-- Password --}}
                <x-wire-input 
                    name="password" 
                    label="Contraseña" 
                    placeholder="Mínimo 8 caracteres"
                    type="password"
                    autocomplete="new-password"
                    required
                />

                {{-- Confirm Password --}}
                <x-wire-input 
                    name="password_confirmation" 
                    label="Confirmar contraseña" 
                    placeholder="Repite la contraseña"
                    type="password"
                    required
                />
            </div>

            <div class="flex justify-end">
                <x-wire-button type="submit" primary label="Guardar" />
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>