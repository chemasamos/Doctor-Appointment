<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Header card --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            {{-- Avatar with initials --}}
            <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg flex-shrink-0">
                @php
                    $nameParts = explode(' ', trim($doctor->user->name ?? 'Doctor'));
                    $initials = strtoupper(substr($nameParts[0] ?? 'D', 0, 1)) . strtoupper(substr($nameParts[1] ?? 'R', 0, 1));
                @endphp
                {{ $initials }}
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $doctor->user->name ?? 'Doctor' }}
                </h2>
                <p class="text-sm text-gray-400">
                    Licencia: {{ $medical_license_number ?? 'N/A' }}
                </p>
            </div>
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <a href="{{ route('admin.doctors.index') }}"
               class="px-4 py-2 text-sm border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Volver
            </a>
            <button wire:click="save" wire:loading.attr="disabled"
                    class="px-4 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition flex items-center gap-2 disabled:opacity-75">
                <span wire:loading.remove wire:target="save">✓ Guardar cambios</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>
    </div>

    {{-- Form card --}}
    <div class="bg-white rounded-2xl shadow p-6 space-y-6">

        {{-- Especialidad --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Especialidad
            </label>
            <select wire:model="speciality_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                <option value="">Seleccionar especialidad</option>
                @foreach($specialities as $speciality)
                    <option value="{{ $speciality->id }}"
                        @selected($speciality_id == $speciality->id)>
                        {{ $speciality->name }}
                    </option>
                @endforeach
            </select>
            @error('speciality_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Número de licencia médica --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Número de licencia médica
            </label>
            <input type="text"
                   wire:model="medical_license_number"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Ej. 12345678">
            @error('medical_license_number')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Biografía --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Biografía
            </label>
            <textarea wire:model="biography"
                      rows="4"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-y"
                      placeholder="Escribe una breve biografía profesional..."></textarea>
            @error('biography')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>
</div>
