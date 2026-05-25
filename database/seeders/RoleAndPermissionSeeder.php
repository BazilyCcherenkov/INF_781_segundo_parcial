<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Seed roles and permissions for both web and api guards.
     *
     * Los permisos del guard web y del guard api son independientes en
     * spatie/laravel-permission: aunque un permiso se llame igual
     * (ej. 'ver productos'), se registra por separado para cada guard.
     * Esto garantiza que un token de API (guard api) no pueda escalar
     * privilegios hacia rutas web (guard web) aunque el nombre del
     * permiso coincida.
     */
    public function run(): void
    {
        // Limpiar caché antes de empezar
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        /* ──────────── Permisos del guard web ──────────── */
        $webPermissions = [
            'ver productos',
            'crear productos',
            'editar productos',
            'eliminar productos',
            'registrar movimiento',
            'aprobar movimiento',
            'gestionar roles',
        ];

        foreach ($webPermissions as $perm) {
            Permission::findOrCreate($perm, 'web');
        }

        /* ──────────── Permisos del guard api ──────────── */
        $apiPermissions = [
            'ver productos',
            'confirmar entrega',
        ];

        foreach ($apiPermissions as $perm) {
            Permission::findOrCreate($perm, 'api');
        }

        // Refrescar caché después de crear permisos
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        /* ──────────── Roles guard web ──────────── */
        $admin = Role::findOrCreate('admin', 'web');
        $admin->syncPermissions($webPermissions);

        $supervisor = Role::findOrCreate('supervisor', 'web');
        $supervisor->syncPermissions([
            'ver productos',
            'editar productos',
            'registrar movimiento',
            'aprobar movimiento',
        ]);

        $almacenista = Role::findOrCreate('almacenista', 'web');
        $almacenista->syncPermissions([
            'ver productos',
            'registrar movimiento',
        ]);

        /* ──────────── Roles guard api ──────────── */
        $repartidor = Role::findOrCreate('repartidor', 'api');
        $repartidor->syncPermissions([
            'ver productos',
            'confirmar entrega',
        ]);

        // Refrescar caché al final
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
