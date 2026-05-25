<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Middleware('auth')]
#[Middleware('permission:gestionar roles')]
class RoleController extends Controller
{
    public function index(): View
    {
        return view('roles.index', [
            'roles' => Role::where('guard_name', 'web')->with('permissions')->get(),
        ]);
    }

    public function create(): View
    {
        return view('roles.create', [
            'permissions' => Permission::where('guard_name', 'web')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        if (!empty($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        }

        // Refrescar caché de permisos para que los cambios apliquen sin reiniciar
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Role $role): View|RedirectResponse
    {
        // Impedir eliminar el rol 'admin' (rol crítico del sistema)
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', 'El rol admin no puede ser editado.');
        }

        return view('roles.edit', [
            'role' => $role->load('permissions'),
            'permissions' => Permission::where('guard_name', 'web')->get(),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', 'El rol admin no puede ser modificado.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $validated['name']]);

        if (isset($validated['permissions'])) {
            $role->syncPermissions($validated['permissions']);
        } else {
            $role->syncPermissions([]);
        }

        // Refrescar caché de permisos
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        // Impedir eliminar el rol 'admin'
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')->with('error', 'El rol admin no puede ser eliminado.');
        }

        $role->delete();

        // Refrescar caché
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado.');
    }
}
