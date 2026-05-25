<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        // auth:sanctum valida el token de acceso personal
        // permission:ver productos,api — especificamos el guard api explícitamente
        // porque Sanctum usa el guard 'web' por defecto, pero los permisos del
        // repartidor están registrados en el guard 'api'.
        $this->middleware('auth:sanctum');
        $this->middleware('permission:ver productos,api');
    }

    /**
     * GET /api/products
     *
     * Solo accesible con token Sanctum de un usuario con rol 'repartidor'
     * (guard api) que tenga el permiso 'ver productos' del guard api.
     *
     * Un token de repartidor NUNCA podrá crear/eliminar productos:
     * - 'crear productos' solo existe en guard web, NO en guard api.
     * - 'eliminar productos' solo existe en guard web, NO en guard api.
     * - Aunque un permiso tenga el mismo nombre, Spatie los trata como
     *   entidades separadas por guard.
     * - Si se intenta POST /api/products, la ruta no está definida (404),
     *   y aunque se definiera, Spatie devolvería 403 porque el permiso
     *   'crear productos' no existe en el guard api.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Product::with('warehouse:id,name')->get(),
        ]);
    }
}
