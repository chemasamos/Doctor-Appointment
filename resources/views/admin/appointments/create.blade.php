<x-admin-layout
    title="Nueva Cita | Admin"
    :breadcrumbs="[
        [
            'name' => 'Dashboard',
            'href' => route('admin.dashboard'),
        ],
        [
            'name' => 'Citas',
            'href' => route('admin.appointments.index'),
        ],
        [
            'name' => 'Nueva Cita',
        ],
    ]">

    <x-wire-card class="mt-4" title="Registrar Cita Médica">

        <p class="text-sm text-gray-500 mb-6">
            Complete los datos para programar una nueva cita médica.
        </p>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-300 rounded-lg">
                <p class="text-sm font-semibold text-red-800 mb-2">
                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                    Por favor corrija los siguientes errores:
                </p>
                <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.appointments.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">

                {{-- Paciente --}}
                <div>
                    <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-700">
                        Paciente <span class="text-red-500">*</span>
                    </label>
                    <select id="patient_id" name="patient_id"
                        class="bg-gray-50 border {{ $errors->has('patient_id') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- Seleccione un paciente --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Doctor --}}
                <div>
                    <label for="doctor_id" class="block mb-2 text-sm font-medium text-gray-700">
                        Doctor <span class="text-red-500">*</span>
                    </label>
                    <select id="doctor_id" name="doctor_id"
                        class="bg-gray-50 border {{ $errors->has('doctor_id') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- Seleccione un doctor --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha --}}
                <div>
                    <label for="date" class="block mb-2 text-sm font-medium text-gray-700">
                        Fecha <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date" name="date" value="{{ old('date') }}"
                        class="bg-gray-50 border {{ $errors->has('date') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hora de inicio --}}
                <div>
                    <label for="start_time" class="block mb-2 text-sm font-medium text-gray-700">
                        Hora de inicio <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}"
                        class="bg-gray-50 border {{ $errors->has('start_time') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('start_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hora de fin --}}
                <div>
                    <label for="end_time" class="block mb-2 text-sm font-medium text-gray-700">
                        Hora de fin <span class="text-red-500">*</span>
                    </label>
                    <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}"
                        class="bg-gray-50 border {{ $errors->has('end_time') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @error('end_time')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Motivo --}}
                <div class="lg:col-span-2">
                    <label for="reason" class="block mb-2 text-sm font-medium text-gray-700">
                        Motivo de la consulta <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reason" name="reason" rows="4"
                        placeholder="Describa el motivo de la consulta..."
                        class="bg-gray-50 border {{ $errors->has('reason') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="flex justify-end gap-3">
                <x-wire-button
                    flat
                    secondary
                    type="button"
                    label="Cancelar"
                    onclick="window.location='{{ route('admin.appointments.index') }}'"
                />
                <x-wire-button
                    type="submit"
                    blue
                    label="Guardar Cita"
                />
            </div>

        </form>
    </x-wire-card>

</x-admin-layout>
