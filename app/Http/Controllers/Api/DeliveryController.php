<?php

namespace App\Http\Controllers\Api;

use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class DeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * POST /api/deliveries/{delivery}/confirm
     *
     * Exige el permiso 'confirmar entrega' del guard api.
     * Solo un repartidor autenticado con token Sanctum puede ejecutarlo.
     */
    public function confirm(Delivery $delivery): JsonResponse
    {
        // Verificamos permiso específico del guard api
        if (!auth()->user()->hasPermissionTo('confirmar entrega', 'api')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $delivery->update([
            'status' => 'confirmed',
            'repartidor_id' => auth()->id(),
            'confirmed_at' => now(),
        ]);

        return response()->json([
            'message' => 'Entrega confirmada exitosamente.',
            'data' => $delivery->fresh(),
        ]);
    }
}
