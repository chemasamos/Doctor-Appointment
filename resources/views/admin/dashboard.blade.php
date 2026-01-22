<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Panel',
        'href' => route('admin.dashboard')
    ],
    [
        'name' => 'Perfil',
    ]
]">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800">¡Bienvenido al panel de administración!</h1>
        <p class="mt-2 text-gray-600">Desde aquí puedes gestionar usuarios, roles y permisos.</p>
    </div>
</x-admin-layout>
