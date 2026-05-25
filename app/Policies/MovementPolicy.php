<?php

namespace App\Policies;

use App\Models\Movement;
use App\Models\User;

class MovementPolicy
{
    /**
     * Un almacenista solo puede registrar movimientos de SU propio almacén
     * (campo warehouse_id). Supervisores y admins pueden registrar en cualquier almacén.
     */
    public function create(User $user, Movement $movement, int $warehouseId): bool
    {
        // Admin y supervisor pueden registrar movimientos en cualquier almacén
        if ($user->hasPermissionTo('aprobar movimiento')) {
            return true;
        }

        // Almacenista: solo en su propio almacén
        // Asumimos que el almacén del almacenista está en user->warehouse_id
        return $user->warehouse_id === $warehouseId;
    }

    /**
     * Solo quien tenga el permiso 'aprobar movimiento' puede aprobar.
     */
    public function approve(User $user, Movement $movement): bool
    {
        return $user->hasPermissionTo('aprobar movimiento');
    }
}
