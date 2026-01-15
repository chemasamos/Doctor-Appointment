<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phone' => 'required|digits_between:7,15',
            'address' => 'required|string|max:255',
            'id_number' => 'required|string|min:5|max:20',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address'],
            'id_number' => $data['id_number'],
        ]);

        // Securely assign the role
        $role = Role::findById($data['role_id'], 'web');
        $user->syncRoles($role);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Usuario creado!',
            'text' => 'El usuario se ha creado correctamente.'
        ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|confirmed|min:8',
            'phone' => 'required|digits_between:7,15',
            'address' => 'required|string|max:255',
            'id_number' => 'required|string|min:5|max:20|unique:users,id_number,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'id_number' => $data['id_number'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        // Sync role
        $role = Role::findById($data['role_id'], 'web');
        $user->syncRoles($role);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario actualizado',
            'text' => 'El usuario ha sido actualizado correctamente.'
        ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Acción no válida',
                'text' => 'No puedes eliminar tu propia cuenta.'
            ]);
            return redirect()->route('admin.users.index');
        }

        // Desasociar roles antes de borrar (soft delete)
        $user->syncRoles([]);

        $user->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario eliminado',
            'text' => 'El usuario ha sido eliminado correctamente.'
        ]);

        return redirect()->route('admin.users.index');
    }
}