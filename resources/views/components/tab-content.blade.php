@props(['tab'])

<div x-show="tab === '{{ $tab }}'" class="mt-4">
    {{ $slot }}
</div>

{{--
=============================================================
 COMPONENTE: x-tab-content
=============================================================

 ¿QUÉ ES?
 Componente envolvente para el CONTENIDO de cada pestaña.
 Controla la visibilidad de su contenido usando Alpine.js,
 mostrándose solo cuando la pestaña correspondiente está activa.

 ¿CÓMO FUNCIONA?
 Usa la directiva Alpine `x-show="tab === '{{ $tab }}'"` que
 evalúa reactivamente si la variable `tab` del x-data padre
 (definido en x-tabs) coincide con el identificador de esta
 pestaña. Alpine actualiza el display en el DOM sin recargar
 la página, haciendo la navegación completamente instantánea.

 PROPS:
   - tab (string, requerido)
     Identificador de la pestaña cuyo contenido contiene.
     Debe coincidir EXACTAMENTE con el valor `tab` del
     x-tab-link correspondiente.

 SLOT:
   - $slot → El contenido HTML de la pestaña (formularios,
     campos, grids, etc.)

 USO EN BLADE:
   <x-tab-content tab="antecedentes">
       <x-wire-textarea name="allergies" label="Alergias" />
       <x-wire-textarea name="chronic_conditions" label="Enfermedades crónicas" />
   </x-tab-content>

 NOTA TÉCNICA:
   Alpine.js `x-show` oculta el elemento con `display: none`
   pero mantiene el DOM activo, lo que significa que los campos
   del formulario dentro de pestañas ocultas SÍ se incluyen
   en el submit del formulario. Esto es intencional.
=============================================================
--}}
