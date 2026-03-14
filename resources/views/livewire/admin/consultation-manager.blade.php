<div class="mt-4">

    {{-- Flash alert --}}
    @if (session('alert'))
        @php $alert = session('alert'); @endphp
        <div class="mb-4 p-4 rounded-lg text-sm font-medium
            {{ $alert['type'] === 'success' ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300' }}">
            <i class="fa-solid {{ $alert['type'] === 'success' ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-2"></i>
            {{ $alert['message'] }}
        </div>
    @endif

    {{-- Card principal --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        {{-- Cabecera del paciente --}}
        <div class="flex items-start justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ $appointment->patient->user->name }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fa-solid fa-id-card mr-1"></i>
                    DNI: {{ $appointment->patient->user->id_number ?? 'No registrado' }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    <i class="fa-solid fa-user-doctor mr-1"></i>
                    Dr(a). {{ $appointment->doctor->user->name }}
                    &nbsp;|&nbsp;
                    <i class="fa-solid fa-calendar mr-1"></i>
                    {{ $appointment->date->format('d/m/Y') }}
                    {{ substr($appointment->start_time, 0, 5) }} – {{ substr($appointment->end_time, 0, 5) }}
                </p>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                <button wire:click="$set('showHistoryModal', true)"
                    class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fa-solid fa-notes-medical text-blue-600"></i>
                    Ver Historia
                </button>
                <button wire:click="$set('showPreviousModal', true)"
                    class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fa-solid fa-clock-rotate-left text-purple-600"></i>
                    Consultas Anteriores
                </button>
            </div>
        </div>

        <hr class="mb-6 border-gray-200">

        {{-- Tabs con Alpine.js entangle --}}
        <div x-data="{ tab: @entangle('activeTab') }">

            {{-- Nav de pestañas --}}
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex gap-6" aria-label="Tabs">
                    <button type="button"
                        @click="tab = 'consulta'"
                        :class="tab === 'consulta'
                            ? 'border-b-2 border-blue-600 text-blue-600 font-semibold'
                            : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent'"
                        class="flex items-center gap-2 pb-3 text-sm transition-colors">
                        <i class="fa-solid fa-clipboard-list"></i>
                        Consulta
                    </button>
                    <button type="button"
                        @click="tab = 'receta'"
                        :class="tab === 'receta'
                            ? 'border-b-2 border-blue-600 text-blue-600 font-semibold'
                            : 'text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-2 border-transparent'"
                        class="flex items-center gap-2 pb-3 text-sm transition-colors">
                        <i class="fa-solid fa-prescription-bottle"></i>
                        Receta
                    </button>
                </nav>
            </div>

            {{-- ─── Pestaña Consulta ─── --}}
            <div x-show="tab === 'consulta'" x-cloak>

                {{-- Diagnóstico --}}
                <div class="mb-5">
                    <label for="diagnosis" class="block mb-2 text-sm font-medium text-gray-700">
                        Diagnóstico <span class="text-red-500">*</span>
                    </label>
                    <textarea id="diagnosis" wire:model="diagnosis" rows="4"
                        placeholder="Describa el diagnóstico del paciente aquí..."
                        class="w-full bg-gray-50 text-gray-900 text-sm rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none transition
                            {{ $errors->has('diagnosis') ? 'border-2 border-red-500' : 'border border-gray-300' }}"></textarea>
                    @error('diagnosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tratamiento --}}
                <div class="mb-5">
                    <label for="treatment" class="block mb-2 text-sm font-medium text-gray-700">
                        Tratamiento <span class="text-red-500">*</span>
                    </label>
                    <textarea id="treatment" wire:model="treatment" rows="4"
                        placeholder="Describa el tratamiento recomendado aquí..."
                        class="w-full bg-gray-50 text-gray-900 text-sm rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none transition
                            {{ $errors->has('treatment') ? 'border-2 border-red-500' : 'border border-gray-300' }}"></textarea>
                    @error('treatment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notas --}}
                <div class="mb-5">
                    <label for="notes" class="block mb-2 text-sm font-medium text-gray-700">
                        Notas <span class="text-gray-400 text-xs">(opcional)</span>
                    </label>
                    <textarea id="notes" wire:model="notes" rows="3"
                        placeholder="Agregue notas adicionales sobre la consulta..."
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none transition"></textarea>
                </div>
            </div>

            {{-- ─── Pestaña Receta ─── --}}
            <div x-show="tab === 'receta'" x-cloak>

                <div class="space-y-3">
                    @foreach($medications as $index => $med)
                        <div class="grid grid-cols-12 gap-3 items-end">
                            {{-- Medicamento --}}
                            <div class="col-span-5">
                                @if($loop->first)
                                    <label class="block mb-1 text-xs font-semibold text-gray-600 uppercase tracking-wide">Medicamento</label>
                                @endif
                                <input type="text"
                                    wire:model="medications.{{ $index }}.medication_name"
                                    placeholder="Ej: Amoxicilina 500mg"
                                    class="w-full bg-gray-50 text-gray-900 text-sm rounded-lg p-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none transition
                                        {{ $errors->has('medications.'.$index.'.medication_name') ? 'border-2 border-red-500' : 'border border-gray-300' }}">
                                @error('medications.'.$index.'.medication_name')
                                    <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Dosis --}}
                            <div class="col-span-3">
                                @if($loop->first)
                                    <label class="block mb-1 text-xs font-semibold text-gray-600 uppercase tracking-wide">Dosis</label>
                                @endif
                                <input type="text"
                                    wire:model="medications.{{ $index }}.dosage"
                                    placeholder="1 cada 8 horas"
                                    class="w-full bg-gray-50 text-gray-900 text-sm rounded-lg p-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none transition
                                        {{ $errors->has('medications.'.$index.'.dosage') ? 'border-2 border-red-500' : 'border border-gray-300' }}">
                                @error('medications.'.$index.'.dosage')
                                    <p class="mt-0.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- Frecuencia/Duración --}}
                            <div class="col-span-3">
                                @if($loop->first)
                                    <label class="block mb-1 text-xs font-semibold text-gray-600 uppercase tracking-wide">Frecuencia / Duración</label>
                                @endif
                                <input type="text"
                                    wire:model="medications.{{ $index }}.frequency_duration"
                                    placeholder="Ej: cada 8 h por 7 días"
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 focus:ring-2 focus:ring-blue-400 focus:outline-none transition">
                            </div>
                            {{-- Botón eliminar --}}
                            <div class="col-span-1">
                                <button type="button" wire:click="removeMedication({{ $index }})"
                                    class="w-full inline-flex items-center justify-center text-white bg-red-500 hover:bg-red-600 rounded-lg p-2.5 transition">
                                    <i class="fa-solid fa-trash text-xs"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" wire:click="addMedication"
                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    <i class="fa-solid fa-plus text-blue-600"></i>
                    Añadir Medicamento
                </button>
            </div>

        </div>{{-- /x-data --}}

        {{-- Botón Guardar --}}
        <div class="flex justify-end mt-8 pt-6 border-t border-gray-200">
            <button type="button" wire:click="saveConsultation"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 text-white bg-blue-700 hover:bg-blue-800 disabled:opacity-60 font-medium rounded-lg px-6 py-2.5 transition">
                <span wire:loading.remove wire:target="saveConsultation">
                    <i class="fa-solid fa-floppy-disk mr-1"></i>
                    Guardar Consulta
                </span>
                <span wire:loading wire:target="saveConsultation">
                    <i class="fa-solid fa-spinner fa-spin mr-1"></i>
                    Guardando...
                </span>
            </button>
        </div>

    </div>{{-- /card --}}

</div>{{-- /mt-4 --}}

{{-- ═══════════════════════════════════════════════
     Modal: Ver Historia Médica
═══════════════════════════════════════════════ --}}
@if($showHistoryModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        wire:click.self="$set('showHistoryModal', false)">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6" @click.stop>

            {{-- Cabecera modal --}}
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold text-gray-900">
                    <i class="fa-solid fa-notes-medical text-blue-600 mr-2"></i>
                    Historia médica del paciente
                </h3>
                <button wire:click="$set('showHistoryModal', false)"
                    class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- Datos médicos en grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-1">
                        <i class="fa-solid fa-droplet mr-1"></i> Tipo de sangre
                    </p>
                    <p class="text-sm text-gray-800 font-medium">
                        {{ $appointment->patient->bloodType->name ?? 'No registrado' }}
                    </p>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <p class="text-xs font-semibold text-yellow-600 uppercase tracking-wide mb-1">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Alergias
                    </p>
                    <p class="text-sm text-gray-800">
                        {{ $appointment->patient->allergies ?? 'No registradas' }}
                    </p>
                </div>
                <div class="bg-red-50 rounded-lg p-4">
                    <p class="text-xs font-semibold text-red-600 uppercase tracking-wide mb-1">
                        <i class="fa-solid fa-heart-crack mr-1"></i> Enfermedades crónicas
                    </p>
                    <p class="text-sm text-gray-800">
                        {{ $appointment->patient->chronic_conditions ?? 'No registradas' }}
                    </p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <p class="text-xs font-semibold text-purple-600 uppercase tracking-wide mb-1">
                        <i class="fa-solid fa-scalpel mr-1"></i> Antecedentes quirúrgicos
                    </p>
                    <p class="text-sm text-gray-800">
                        {{ $appointment->patient->surgical_history ?? 'No registrados' }}
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 text-center">
                <a href="{{ route('admin.patients.edit', $appointment->patient) }}"
                    class="text-blue-600 hover:underline text-sm font-medium">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i>
                    Ver / Editar Historia Médica completa
                </a>
            </div>
        </div>
    </div>
@endif

{{-- ═══════════════════════════════════════════════
     Modal: Consultas Anteriores
═══════════════════════════════════════════════ --}}
@if($showPreviousModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
        wire:click.self="$set('showPreviousModal', false)">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6 max-h-[80vh] flex flex-col" @click.stop>

            {{-- Cabecera modal --}}
            <div class="flex items-center justify-between mb-5 flex-shrink-0">
                <h3 class="text-lg font-bold text-gray-900">
                    <i class="fa-solid fa-clock-rotate-left text-purple-600 mr-2"></i>
                    Consultas Anteriores
                </h3>
                <button wire:click="$set('showPreviousModal', false)"
                    class="text-gray-400 hover:text-gray-600 transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- Lista de consultas --}}
            <div class="overflow-y-auto flex-1 space-y-4 pr-1">
                @forelse($previousConsultations as $prev)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    <i class="fa-solid fa-calendar-day text-blue-500 mr-1"></i>
                                    {{ $prev->date->format('d/m/Y') }} a las {{ substr($prev->start_time, 0, 5) }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Atendido por: Dr(a). {{ $prev->doctor->user->name }}
                                </p>
                            </div>
                            <a href="{{ route('admin.appointments.consult', $prev) }}"
                                class="text-xs font-medium text-blue-600 border border-blue-300 rounded-lg px-3 py-1 hover:bg-blue-50 transition flex-shrink-0">
                                <i class="fa-solid fa-stethoscope mr-1"></i>
                                Consultar Detalle
                            </a>
                        </div>
                        <div class="space-y-1 text-sm text-gray-700">
                            <p>
                                <span class="font-medium text-gray-600">Diagnóstico:</span>
                                {{ Str::limit($prev->consultation->diagnosis, 100) }}
                            </p>
                            <p>
                                <span class="font-medium text-gray-600">Tratamiento:</span>
                                {{ Str::limit($prev->consultation->treatment, 100) }}
                            </p>
                            @if($prev->consultation->notes)
                                <p>
                                    <span class="font-medium text-gray-600">Notas:</span>
                                    {{ Str::limit($prev->consultation->notes, 80) }}
                                </p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 text-gray-400">
                        <i class="fa-solid fa-calendar-xmark text-4xl mb-3 block"></i>
                        <p class="text-sm">No hay consultas anteriores registradas.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
@endif
