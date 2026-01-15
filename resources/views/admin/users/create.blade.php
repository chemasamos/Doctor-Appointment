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
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <x-wire-input 
                        name="name" 
                        label="Nombre" 
                        placeholder="Nombre completo"
                        autocomplete="name"
                        required
                        value="{{ old('name') }}"
                    />

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
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-wire-input 
                        name="password" 
                        label="Contraseña" 
                        placeholder="Mínimo 8 caracteres"
                        type="password"
                        autocomplete="new-password"
                        required
                    />

                    <x-wire-input 
                        name="password_confirmation" 
                        label="Confirmar contraseña" 
                        placeholder="Repite la contraseña"
                        type="password"
                        required
                    />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <x-wire-input 
                        name="phone" 
                        label="Teléfono" 
                        placeholder="1234567890"
                        type="tel"
                        required
                        input-mode="tel"
                        value="{{ old('phone') }}"
                    />

                    <x-wire-input 
                        name="address" 
                        label="Dirección" 
                        placeholder="Calle, Número, Colonia..."
                        required
                        value="{{ old('address') }}"
                    />
                </div>

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

                <div class="flex justify-end">
                    <x-wire-button type="submit" primary label="Guardar" />
                </div>
            </div>
        </form>
    </x-wire-card>
</x-admin-layout>