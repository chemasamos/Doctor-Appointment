@props(['tab', 'error' => false])

<li class="mr-2">
    <a href="#"
       @click.prevent="tab = '{{ $tab }}'"
       :class="{
           'text-red-600 border-red-600 border-b-2': tab === '{{ $tab }}' && {{ $error ? 'true' : 'false' }},
           'text-blue-600 border-blue-600 border-b-2': tab === '{{ $tab }}' && !{{ $error ? 'true' : 'false' }},
           'text-red-400 border-transparent': tab !== '{{ $tab }}' && {{ $error ? 'true' : 'false' }},
           'text-gray-500 border-transparent': tab !== '{{ $tab }}' && !{{ $error ? 'true' : 'false' }}
       }"
       class="inline-flex items-center gap-2 p-4 text-sm font-medium hover:text-gray-600 transition-colors duration-200">
        {{ $slot }}
        @if($error)
            <i class="fa-solid fa-circle-exclamation animate-pulse"></i>
        @endif
    </a>
</li>

{{--
=============================================================
 COMPONENTE: x-tab-link
=============================================================

 ¿QUÉ ES?
 Componente para cada botón/enlace de navegación del sistema
 de pestañas. Renderiza un <li> con un <a> que, al hacer
 clic, actualiza la variable Alpine `tab` del componente
 padre (x-tabs).

 ¿CÓMO FUNCIONA?
 Usa `@click.prevent="tab = '{{ $tab }}'"` para cambiar la
 pestaña activa. El estilo visual se controla con Alpine `:class`
 que evalúa en tiempo real si esta pestaña está activa y si
 tiene errores de validación ($error === true).

 PROPS:
   - tab   (string, requerido)
     Identificador único de la pestaña. Debe coincidir con el
     `tab` del x-tab-content correspondiente.
   - error (boolean, default: false)
     Indica si algún campo de esta pestaña tiene un error de
     validación. Cambia el color a rojo y muestra ícono animado.

 ESTADOS VISUALES (Alpine :class):
   ┌─────────┬────────────┬──────────────────────────────────┐
   │ Activa  │ Con error  │ Estilo                           │
   ├─────────┼────────────┼──────────────────────────────────┤
   │   ✅   │    ❌      │ Azul con borde inferior azul     │
   │   ✅   │    ✅      │ Rojo con borde inferior rojo     │
   │   ❌   │    ✅      │ Rojo tenue, borde transparente   │
   │   ❌   │    ❌      │ Gris, borde transparente         │
   └─────────┴────────────┴──────────────────────────────────┘

 SLOT:
   - $slot → Texto/contenido del botón (ej: "Antecedentes")
   - Si $error === true, agrega automáticamente el ícono
     fa-circle-exclamation con animación pulse.

 USO EN BLADE:
   <x-tab-link tab="antecedentes"
               :error="$errors->hasAny(['allergies','chronic_conditions'])">
       Antecedentes
   </x-tab-link>
=============================================================
--}}
