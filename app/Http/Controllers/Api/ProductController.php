<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(): JsonResponse
    {
        if (!auth()->user()->hasPermissionTo('ver productos', 'api')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => Product::with('warehouse:id,name')->get(),
        ]);
    }
}
