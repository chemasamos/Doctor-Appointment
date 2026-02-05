<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Gestión de Pacientes</h2>
                
                @livewire('admin.datatables.patient-table')
            </div>
        </div>
    </div>
</x-admin-layout>
