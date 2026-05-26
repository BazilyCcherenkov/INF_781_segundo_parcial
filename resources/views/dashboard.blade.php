<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard — AlmaTrack') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 rounded shadow-sm flex items-center">
                    <svg class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @php
                $user = Auth::user();
                $role = $user->roles->first();
                $productCount = \App\Models\Product::count();
                $warehouseCount = \App\Models\Warehouse::count();
                $pendingCount = \App\Models\Movement::where('approved', false)->count();
            @endphp

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Productos</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $productCount }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Almacenes</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $warehouseCount }}</p>
                        </div>
                    </div>
                </div>

                @can('aprobar movimiento')
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500">Pendientes</p>
                                <p class="text-2xl font-bold text-gray-800">{{ $pendingCount }}</p>
                            </div>
                        </div>
                    </div>
                @endcan

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-500">Rol actual</p>
                            <p class="text-2xl font-bold text-gray-800 capitalize">{{ $role->name ?? 'Sin rol' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- Quick Access --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-700">Acceso Rápido</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @can('ver productos')
                            <a href="{{ route('products.index') }}"
                               class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition group">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-blue-700">Ver listado de productos</span>
                                <svg class="ml-auto h-4 w-4 text-gray-300 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endcan

                        @can('registrar movimiento')
                            <a href="{{ route('movements.create') }}"
                               class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-green-50 transition group">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-green-700">Registrar movimiento</span>
                                <svg class="ml-auto h-4 w-4 text-gray-300 group-hover:text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endcan

                        @can('gestionar roles')
                            <a href="{{ route('roles.index') }}"
                               class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-purple-50 transition group">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span class="ml-3 text-gray-700 group-hover:text-purple-700">Gestionar roles</span>
                                <svg class="ml-auto h-4 w-4 text-gray-300 group-hover:text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endcan
                    </div>
                </div>

                {{-- Movements Pending Approval --}}
                @can('aprobar movimiento')
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-semibold text-gray-700">Movimientos Pendientes</h3>
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">{{ $pendingCount }} pendientes</span>
                        </div>
                        <div class="p-6">
                            @php
                                $pendingMovements = \App\Models\Movement::where('approved', false)
                                    ->with(['product', 'warehouse', 'user'])
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            @endphp

                            @if ($pendingMovements->isEmpty())
                                <div class="text-center py-6 text-gray-400">
                                    <svg class="h-10 w-10 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p>No hay movimientos pendientes.</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($pendingMovements as $mov)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="font-medium text-sm">{{ $mov->product->name }}</span>
                                                    <span class="px-2 py-0.5 rounded text-xs font-medium
                                                        {{ $mov->type === 'entry' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                        {{ $mov->type === 'entry' ? 'Entrada' : 'Salida' }}
                                                    </span>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $mov->quantity }} unidades · {{ $mov->warehouse->name }} · {{ $mov->user->name }}
                                                </div>
                                            </div>
                                            <form action="{{ route('movements.approve', $mov) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-3 py-1.5 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition flex items-center">
                                                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Aprobar
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($pendingCount > 5)
                                    <div class="mt-3 text-center">
                                        <a href="{{ route('movements.index') }}" class="text-sm text-blue-600 hover:underline">Ver todos los movimientos</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>