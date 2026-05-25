<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);

        // Warehouses predefinidos
        $warehouseA = Warehouse::create(['name' => 'Almacén Central', 'location' => 'Av. Principal 123']);
        $warehouseB = Warehouse::create(['name' => 'Almacén Norte', 'location' => 'Calle Secundaria 456']);

        // Usuario admin (todos los permisos web)
        $admin = User::factory()->create([
            'name' => 'Admin Principal',
            'email' => 'admin@almatrack.com',
        ]);
        $admin->assignRole('admin');

        // Supervisor web
        $supervisor = User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@almatrack.com',
        ]);
        $supervisor->assignRole('supervisor');

        // Almacenista (web)
        $almacenista = User::factory()->create([
            'name' => 'Almacenista',
            'email' => 'almacenista@almatrack.com',
        ]);
        $almacenista->assignRole('almacenista');

        // Repartidor (api) — creamos un usuario con rol web para que pueda
        // tener token de Sanctum y autenticarse por la API
        $repartidor = User::factory()->create([
            'name' => 'Repartidor',
            'email' => 'repartidor@almatrack.com',
        ]);
        // El rol 'repartidor' pertenece al guard api; hay que especificarlo
        $repartidor->assignRole('repartidor', 'api');
    }
}
