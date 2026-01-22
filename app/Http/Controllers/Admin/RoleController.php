<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Muestra un listado del recurso.
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Muestra el formulario para crear un nuevo recurso.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
        // Validar
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        // Crear el rol
        Role::create(['name' => $request->name]);

        // Alerta de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol creado correctamente',
            'text' => 'El rol ha sido creado correctamente'
        ]);

        // Redirigir
        return redirect()->route('admin.roles.index');
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit(Role $role)
    {
        // Proteger los primeros 4 roles del sistema
        if ($role->id <= 4) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No puedes editar este rol'
            ]);
            
            return redirect()->route('admin.roles.index');
        }

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, Role $role)
    {
        // Proteger los primeros 4 roles del sistema
        if ($role->id <= 4) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No puedes editar este rol'
            ]);
            
            return redirect()->route('admin.roles.index');
        }

        // Validar que el nombre sea único excepto para este rol
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        // Si el nombre no cambia, no actualizar
        if ($role->name === $request->name) {
            session()->flash('swal', [
                'icon' => 'info',
                'title' => 'Sin cambios',
                'text' => 'No se ha realizado ningún cambio'
            ]);
            return redirect()->route('admin.roles.edit', $role);
        }

        // Actualizar el rol
        $role->update(['name' => $request->name]);

        // Alerta de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado correctamente',
            'text' => 'El rol ha sido actualizado correctamente'
        ]);

        // Redirigir
        return redirect()->route('admin.roles.index');
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy(Role $role)
    {
        // Proteger los primeros 4 roles del sistema
        if ($role->id <= 4) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No puedes eliminar este rol protegido.'
            ]);
            
            return redirect()->route('admin.roles.index');
        }

        try {
            // Verificar usuarios asignados usando Eloquent (spatie relationship)
            if ($role->users()->count() > 0) {
                session()->flash('swal', [
                    'icon' => 'error',
                    'title' => 'No se puede eliminar',
                    'text' => 'Este rol tiene ' . $role->users()->count() . ' usuario(s) asignado(s). Reasígnalos antes de eliminar.'
                ]);
                
                return redirect()->route('admin.roles.index');
            }

            $roleName = $role->name;
            $role->delete(); // Elimina y cascadea permisos si está configurado, o simplemente borra el rol

            session()->flash('swal', [
                'icon' => 'success',
                'title' => 'Rol eliminado',
                'text' => 'El rol "' . $roleName . '" ha sido eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error eliminando rol: ' . $e->getMessage());
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error al eliminar',
                'text' => 'Ocurrió un error inesperado al intentar eliminar el rol.'
            ]);
        }

        return redirect()->route('admin.roles.index');
    }
}