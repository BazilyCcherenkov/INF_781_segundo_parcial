<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);

        $warehouseA = Warehouse::firstOrCreate(
            ['name' => 'Almacén Central'],
            ['location' => 'Av. Principal 123']
        );
        $warehouseB = Warehouse::firstOrCreate(
            ['name' => 'Almacén Norte'],
            ['location' => 'Calle Secundaria 456']
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@almatrack.com'],
            ['name' => 'Admin Principal', 'password' => 'password']
        );
        $admin->assignRole('admin');

        $supervisor = User::firstOrCreate(
            ['email' => 'supervisor@almatrack.com'],
            ['name' => 'Supervisor', 'password' => 'password']
        );
        $supervisor->assignRole('supervisor');

        $almacenista = User::firstOrCreate(
            ['email' => 'almacenista@almatrack.com'],
            ['name' => 'Almacenista', 'password' => 'password']
        );
        $almacenista->assignRole('almacenista');
        $almacenista->warehouse_id = $warehouseA->id;
        $almacenista->save();

        $repartidor = User::firstOrCreate(
            ['email' => 'repartidor@almatrack.com'],
            ['name' => 'Repartidor', 'password' => 'password']
        );
        // Rol en guard api: attach directo porque assignRole() usa guard web por defecto
        $repartidorRole = Role::findByName('repartidor', 'api');
        $alreadyAssigned = $repartidor->roles()
            ->where('role_id', $repartidorRole->id)
            ->exists();
        if (!$alreadyAssigned) {
            $repartidor->roles()->attach($repartidorRole->id);
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        }
    }
}
