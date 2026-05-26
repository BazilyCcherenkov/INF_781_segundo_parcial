<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-700">Listado de productos</h3>
                            <span class="px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full">{{ $products->total() }} registros</span>
                        </div>
                        @can('crear productos')
                            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition shadow-sm">
                                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Nuevo Producto
                            </a>
                        @endcan
                    </div>

                    @if ($products->isEmpty())
                        <div class="text-center py-12 text-gray-400">
                            <svg class="h-16 w-16 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-lg">No hay productos registrados</p>
                            @can('crear productos')
                                <a href="{{ route('products.create') }}" class="mt-2 inline-block text-blue-600 hover:underline">Crear el primer producto</a>
                            @endcan
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="border-b-2 border-gray-200">
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stock</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Precio</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Almacén</th>
                                        <th class="py-3 px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($products as $product)
                                        <tr class="hover:bg-blue-50 transition">
                                            <td class="py-3 px-4 text-sm font-mono text-gray-500">{{ $product->sku }}</td>
                                            <td class="py-3 px-4">
                                                <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline font-medium">{{ $product->name }}</a>
                                            </td>
                                            <td class="py-3 px-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-700">${{ number_format($product->price, 2) }}</td>
                                            <td class="py-3 px-4 text-sm text-gray-500">{{ $product->warehouse->name ?? 'N/A' }}</td>
                                            <td class="py-3 px-4">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:text-blue-800 text-sm" title="Ver">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                    @can('editar productos')
                                                        <a href="{{ route('products.edit', $product) }}" class="text-yellow-600 hover:text-yellow-800 text-sm" title="Editar">
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                        </a>
                                                    @endcan
                                                    @can('eliminar productos')
                                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                                                              onsubmit="return confirm('¿Eliminar el producto {{ $product->name }}? Esta acción no se puede deshacer.')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" title="Eliminar">
                                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>