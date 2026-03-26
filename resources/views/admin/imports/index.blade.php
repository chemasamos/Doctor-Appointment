<x-admin-layout
    title="Importación Masiva de Pacientes"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Importación',
        ],
    ]">

    <div class="mt-4">

        @if(session()->has('alert'))
            <div class="p-4 mb-4 text-sm text-{{ session('alert.type') == 'success' ? 'green' : 'red' }}-800 rounded-lg bg-{{ session('alert.type') == 'success' ? 'green' : 'red' }}-50 dark:bg-gray-800 dark:text-{{ session('alert.type') == 'success' ? 'green' : 'red' }}-400" role="alert">
                {{ session('alert.message') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{ route('admin.imports.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">
                            Sube un archivo CSV o Excel con las columnas: name, email, phone, address, id_number, allergies
                        </label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" name="file" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        Importar
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-bold mb-4">Ejemplo del formato esperado</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">name</th>
                                <th scope="col" class="px-6 py-3">email</th>
                                <th scope="col" class="px-6 py-3">phone</th>
                                <th scope="col" class="px-6 py-3">address</th>
                                <th scope="col" class="px-6 py-3">id_number</th>
                                <th scope="col" class="px-6 py-3">allergies</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white dark:bg-gray-800">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Juan Pérez</td>
                                <td class="px-6 py-4">juan@ejemplo.com</td>
                                <td class="px-6 py-4">5551234567</td>
                                <td class="px-6 py-4">Calle 1</td>
                                <td class="px-6 py-4">12345678</td>
                                <td class="px-6 py-4">Ninguna</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
