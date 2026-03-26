<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold">Gestión de Pacientes</h2>
                    <x-wire-button green href="{{ route('admin.imports.index') }}">
                        <i class="fa-solid fa-file-excel mr-2"></i> Importar desde Excel
                    </x-wire-button>
                </div>
                
                @livewire('admin.datatables.patient-table')
            </div>
        </div>
    </div>
</x-admin-layout>
