# Refactorización: Componentes de Pestañas Reutilizables

## Archivos creados

| Archivo | Descripción |
|---|---|
| `resources/views/components/tabs.blade.php` | Contenedor Alpine (`x-data`) con slots `header` y `slot` |
| `resources/views/components/tab-link.blade.php` | Botón de navegación con lógica de estados activo/error |
| `resources/views/components/tab-content.blade.php` | Wrapper de contenido con `x-show` |

## Archivos modificados

| Archivo | Cambio |
|---|---|
| `resources/views/admin/patients/edit.blade.php` | Refactorizado para usar los 3 nuevos componentes |
| `app/Http/Controllers/Admin/PatientController.php` | `edit()` pasa `$initialTab`; `update()` tiene mapa de tabs para errores |

---

## Flujo de datos

```
PatientController::edit()
  └─ calcula $initialTab desde session('initialTab', 'datos_personales')
  └─ pasa variable a la vista

edit.blade.php
  └─ <x-tabs :active="$initialTab">        ← prop PHP → Alpine x-data
       └─ <x-tab-link tab="..." :error="$errors->hasAny([...])">
              ├─ :class Alpine → azul activo | rojo activo | rojo inactivo | gris inactivo
              └─ ícono fa-circle-exclamation si $error === true
       └─ <x-tab-content tab="...">
              └─ x-show="tab === '...'" controla visibilidad en JS

PatientController::update() [en fallo de validación]
  └─ Laravel redirige automáticamente con withErrors()
  └─ edit() recibe la sesión de errores → $errors->hasAny() activa los estilos rojos
```

---

## El error intencional del profesor

El bug estaba en **`tabs.blade.php`**, en el valor inicial del `x-data`:

```blade
{{-- ❌ INCORRECTO (error del profesor) --}}
@props(['active' => 'datos-personales'])
<div x-data="{ tab: '{{ $active }}' }">

{{-- ✅ CORRECTO (implementado) --}}
@props(['active' => 'datos_personales'])
<div x-data="{ tab: '{{ $active }}' }">
```

**¿Dónde estaba el bug?**
El `@props` declaraba el valor default con **guiones** (`datos-personales`), pero los IDs de los tabs en la vista usan **guiones bajos** (`datos_personales`). Alpine compara el valor de `x-data.tab` con los strings en `x-show` y `:class`. Si el default no coincide exactamente, la primera pestaña nunca se activa y el usuario ve el contenido de **todos** los tabs al mismo tiempo (ya que `x-show` para cada uno evalúa como `false`, pero el primero tendría `style="display: none"` dejando la página visualmente vacía).

**Categoría del bug:** Tipo 1 — inconsistencia en el identificador de pestaña entre el componente y la vista.

---

## Principio DRY aplicado

### Antes (código repetitivo por cada pestaña)
```blade
{{-- ~18 líneas por pestaña (×4 tabs = 72 líneas solo en navegación) --}}
@php $hasError = $errors->hasAny([...]); @endphp
<li class="me-2">
    <a href="#" @click.prevent="tab = 'nombre_tab'"
       :class="{
           'text-red-600 border-red-600': {{ $hasError ? 'true' : 'false' }} && tab !== 'nombre_tab',
           'text-red-600 border-red-600 active': {{ $hasError ? 'true' : 'false' }} && tab === 'nombre_tab',
           'text-blue-600 border-blue-600 active': !{{ $hasError ? 'true' : 'false' }} && tab === 'nombre_tab',
           'text-gray-500 border-transparent hover:...': tab !== 'nombre_tab' && !{{ $hasError ? 'true' : 'false' }}
       }"
       class="inline-flex items-center justify-center p-4 border-b-2 rounded-t-lg transition-colors duration-200">
        Nombre Tab
        @if($hasError)
            <i class="fa-solid fa-circle-exclamation ms-2 animate-pulse"></i>
        @endif
    </a>
</li>
```

### Después (con componente reutilizable)
```blade
{{-- 3 líneas por pestaña --}}
<x-tab-link tab="nombre_tab" :error="$errors->hasAny(['campo1','campo2'])">
    Nombre Tab
</x-tab-link>
```

**Reducción:** de ~345 líneas a ~235 líneas en `edit.blade.php`. La lógica de `:class` que se repetía 3 veces ahora vive en un solo componente.
