<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

class ProductController extends Controller
{
    #[Middleware('auth')]
    #[Middleware('permission:ver productos', only: ['index', 'show'])]
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::with('warehouse')->paginate(10),
        ]);
    }

    #[Middleware('auth')]
    #[Middleware('permission:ver productos', only: ['index', 'show'])]
    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    #[Middleware('auth')]
    #[Middleware('permission:crear productos', only: ['create', 'store'])]
    public function create(): View
    {
        return view('products.create');
    }

    #[Middleware('auth')]
    #[Middleware('permission:crear productos', only: ['create', 'store'])]
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Producto creado.');
    }

    // Demostración de role_or_permission: un supervisor (sin crear) puede ver
    // el form de edición gracias a que tiene role:supervisor
    #[Middleware('auth')]
    #[Middleware('role_or_permission:supervisor|editar productos', only: ['edit', 'update'])]
    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    #[Middleware('auth')]
    #[Middleware('role_or_permission:supervisor|editar productos', only: ['edit', 'update'])]
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,'.$product->id,
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'warehouse_id' => 'required|exists:warehouses,id',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    #[Middleware('auth')]
    #[Middleware('permission:eliminar productos', only: ['destroy'])]
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado.');
    }
}
