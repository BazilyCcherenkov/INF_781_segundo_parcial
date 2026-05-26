<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class MovementController extends Controller
{
    #[Middleware('auth')]
    #[Middleware('permission:registrar movimiento')]
    public function index(): View
    {
        $movements = Movement::with(['product', 'warehouse', 'user', 'approver'])
            ->latest()
            ->paginate(15);

        return view('movements.index', compact('movements'));
    }

    #[Middleware('auth')]
    #[Middleware('permission:registrar movimiento', only: ['create', 'store'])]
    public function create(): View
    {
        return view('movements.create', [
            'products' => Product::with('warehouse')->get(),
        ]);
    }

    #[Middleware('auth')]
    #[Middleware('permission:registrar movimiento', only: ['create', 'store'])]
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'type' => 'required|in:entry,exit',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Policy check: almacenista solo puede registrar movimientos de su almacén
        $movement = new Movement($validated);
        $movement->user_id = auth()->id();

        Gate::authorize('create', [$movement, $validated['warehouse_id']]);

        $movement->save();

        return redirect()->route('dashboard')->with('success', 'Movimiento registrado, pendiente de aprobación.');
    }

    #[Middleware('auth')]
    #[Middleware('permission:aprobar movimiento', only: ['approve'])]
    public function approve(Movement $movement): RedirectResponse
    {
        Gate::authorize('approve', $movement);

        $movement->update([
            'approved' => true,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        // Actualizar stock del producto
        $product = $movement->product;
        if ($movement->type === 'entry') {
            $product->increment('stock', $movement->quantity);
        } else {
            $product->decrement('stock', $movement->quantity);
        }

        return redirect()->route('dashboard')->with('success', 'Movimiento aprobado.');
    }
}
