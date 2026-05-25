<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard — AlmaTrack') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Bienvenido, {{ Auth::user()->name }}</h3>

                    @can('aprobar movimiento')
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-2">Movimientos pendientes de aprobación</h4>
                            @php
                                $pendingMovements = \App\Models\Movement::where('approved', false)
                                    ->with(['product', 'warehouse', 'user'])
                                    ->latest()
                                    ->get();
                            @endphp

                            @if ($pendingMovements->isEmpty())
                                <p class="text-gray-500 text-sm">No hay movimientos pendientes.</p>
                            @else
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="border-b">
                                            <th class="py-2 px-4 text-sm">Producto</th>
                                            <th class="py-2 px-4 text-sm">Tipo</th>
                                            <th class="py-2 px-4 text-sm">Cantidad</th>
                                            <th class="py-2 px-4 text-sm">Almacén</th>
                                            <th class="py-2 px-4 text-sm">Registró</th>
                                            <th class="py-2 px-4 text-sm">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pendingMovements as $mov)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="py-2 px-4 text-sm">{{ $mov->product->name }}</td>
                                                <td class="py-2 px-4 text-sm">
                                                    <span class="px-2 py-1 rounded text-xs {{ $mov->type === 'entry' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                        {{ $mov->type === 'entry' ? 'Entrada' : 'Salida' }}
                                                    </span>
                                                </td>
                                                <td class="py-2 px-4 text-sm">{{ $mov->quantity }}</td>
                                                <td class="py-2 px-4 text-sm">{{ $mov->warehouse->name }}</td>
                                                <td class="py-2 px-4 text-sm">{{ $mov->user->name }}</td>
                                                <td class="py-2 px-4 text-sm">
                                                    <form action="{{ route('movements.approve', $mov) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded text-xs hover:bg-green-600">
                                                            Aprobar
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    @endcan

                    @can('ver productos')
                        <div class="mt-4">
                            <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Ver listado de productos</a>
                        </div>
                    @endcan

                    @can('registrar movimiento')
                        <div class="mt-2">
                            <a href="{{ route('movements.create') }}" class="text-blue-600 hover:underline">Registrar movimiento</a>
                        </div>
                    @endcan

                    @can('gestionar roles')
                        <div class="mt-2">
                            <a href="{{ route('roles.index') }}" class="text-blue-600 hover:underline">Gestionar roles</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
