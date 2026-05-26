<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movimientos de Inventario') }}
        </h2>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                        <div class="flex items-center space-x-2">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-700">Historial de movimientos</h3>
                            <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full">{{ $movements->total() }} registros</span>
                        </div>
                        @can('registrar movimiento')
                            <a href="{{ route('movements.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition shadow-sm">
                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Nuevo Movimiento
                            </a>
                        @endcan
                    </div>

                    @if ($movements->isEmpty())
                        <div class="text-center py-12 text-gray-400">
                            <svg class="h-16 w-16 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                            <p class="text-lg">No hay movimientos registrados</p>
                            <a href="{{ route('movements.create') }}" class="mt-2 inline-block text-blue-600 hover:underline">Registrar primer movimiento</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="border-b-2 border-gray-200">
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Producto</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipo</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cantidad</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Almacén</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Registró</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($movements as $mov)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="py-3 px-4 text-sm text-gray-500 font-mono">#{{ $mov->id }}</td>
                                            <td class="py-3 px-4 text-sm">{{ $mov->product->name ?? 'N/A' }}</td>
                                            <td class="py-3 px-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $mov->type === 'entry' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        @if ($mov->type === 'entry')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                                        @endif
                                                    </svg>
                                                    {{ $mov->type === 'entry' ? 'Entrada' : 'Salida' }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm font-medium">{{ $mov->quantity }}</td>
                                            <td class="py-3 px-4 text-sm text-gray-500">{{ $mov->warehouse->name ?? 'N/A' }}</td>
                                            <td class="py-3 px-4 text-sm text-gray-500">{{ $mov->user->name ?? 'N/A' }}</td>
                                            <td class="py-3 px-4">
                                                @if ($mov->approved)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Aprobado
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Pendiente
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-400">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $movements->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>