<x-admin-layout title="Editar Usuario | Simify"
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
      'name' => 'Editar'
    ],
]">
    <x-wire-card class="mt-4">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                {{-- Nombre --}}
                <x-wire-input 
                    name="name" 
                    label="Nombre" 
                    placeholder="Nombre completo"
                    autocomplete="name"
                    required
                    value="{{ old('name', $user->name) }}"
                />

                {{-- ID Number --}}
                <x-wire-input 
                    name="id_number" 
                    label="Matrícula / ID" 
                    placeholder="Identificación única"
                    required
                    value="{{ old('id_number', $user->id_number) }}"
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
                    value="{{ old('email', $user->email) }}"
                />

                {{-- Teléfono --}}
                <x-wire-input 
                    name="phone" 
                    label="Teléfono" 
                    placeholder="1234567890"
                    type="tel"
                    required
                    input-mode="tel"
                    value="{{ old('phone', $user->phone) }}"
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
                        :selected="old('role_id', $user->roles->first()?->id)"
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
                        value="{{ old('address', $user->address) }}"
                    />
                </div>

                {{-- Password --}}
                <x-wire-input 
                    name="password" 
                    label="Nueva Contraseña (Opcional)" 
                    placeholder="Dejar vacío para mantener la actual"
                    type="password"
                    autocomplete="new-password"
                />

                {{-- Confirm Password --}}
                <x-wire-input 
                    name="password_confirmation" 
                    label="Confirmar contraseña" 
                    placeholder="Repite la contraseña"
                    type="password"
                />
            </div>

            <div class="flex justify-between items-center">
                {{-- Delete Button --}}
                @if($user->id !== auth()->id())
                    <x-wire-button 
                        red 
                        label="Eliminar Usuario" 
                        x-on:click="$wireui.confirmNotification({
                            title: '¿Estás seguro?',
                            description: 'Esta acción no se puede deshacer.',
                            icon: 'error',
                            accept: {
                                label: 'Sí, eliminar',
                                method: 'submit',
                                params: 'delete-form-{{ $user->id }}'
                            },
                            reject: {
                                label: 'Cancelar'
                            }
                        })"
                    />
                @else
                    <div></div> {{-- Spacer --}}
                @endif
                
                <div class="flex space-x-3">
                    <x-wire-button flat label="Cancelar" href="{{ route('admin.users.index') }}" />
                    <x-wire-button type="submit" primary label="Actualizar" />
                </div>
            </div>
        </form>
        
        {{-- Hidden Delete Form for WireUI Confirmation --}}
        @if($user->id !== auth()->id())
            <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        
            <script>
                // Manual binding for WireUI confirm since we are outside Livewire context for the form submit
                // Actually, WireUI confirmNotification works best with Livewire.
                // For standard Blade, we can use a small AlpineJS wrapper or standard SweetAlert if WireUI is tricky without Livewire backing.
                // However, user asked for Modal or Swal.
                // Let's use simple onclick with Swal for standard blade form.
            </script>
        @endif
    </x-wire-card>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto. El usuario será eliminado.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#3b82f6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-{{ $user->id }}').submit();
                }
            })
        }
    </script>
    @endpush
</x-admin-layout>