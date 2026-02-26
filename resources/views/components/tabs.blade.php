@props(['active' => 'datos_personales'])

<div x-data="{ tab: '{{ $active }}' }">
    {{-- Navegación de pestañas --}}
    <div class="border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px">
            {{ $header }}
        </ul>
    </div>

    {{-- Contenido --}}
    <div>
        {{ $slot }}
    </div>
</div>

{{--
=============================================================
 COMPONENTE: x-tabs
=============================================================

 ¿QUÉ ES?
 Componente contenedor principal del sistema de pestañas.
 Envuelve la navegación (encabezados) y el contenido de todas
 las pestañas en un mismo bloque Alpine.js reactivo.

 ¿CÓMO FUNCIONA?
 Inicializa Alpine.js con `x-data="{ tab: '...' }"`, donde
 `tab` es la variable compartida que controla cuál pestaña
 está activa. Los componentes hijos (x-tab-link y x-tab-content)
 leen y modifican esta variable para sincronizar la navegación
 con el contenido visible.

 PROPS:
   - active (string, default: 'datos_personales')
     Nombre de la pestaña que debe mostrarse al cargar la página.
     Debe coincidir EXACTAMENTE con el valor `tab` usado en los
     componentes hijos. ⚠️ Usar guión_bajo, NO guión-medio.

 SLOTS:
   - $header  → Slot nombrado. Aquí van los <x-tab-link>.
   - $slot    → Slot por defecto. Aquí van los <x-tab-content>.

 USO EN BLADE:
   <x-tabs :active="$initialTab">
       <x-slot name="header">
           <x-tab-link tab="mi_tab">Mi Pestaña</x-tab-link>
       </x-slot>
       <x-tab-content tab="mi_tab">
           Contenido aquí...
       </x-tab-content>
   </x-tabs>

 FLUJO DE DATOS:
   Controller → $initialTab → prop :active → Alpine x-data.tab
   → x-tab-link actualiza tab al hacer clic
   → x-tab-content muestra/oculta con x-show
=============================================================
--}}
