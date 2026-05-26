<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Producto: ') . $product->name }}
            </h2>
            <span class="text-sm text-gray-500">SKU: {{ $product->sku }}</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">SKU: <span class="font-mono">{{ $product->sku }}</span></p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    Stock: {{ $product->stock }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</label>
                            <p class="mt-1 text-sm">{{ $product->description ?? 'Sin descripción' }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</label>
                            <p class="mt-1 text-2xl font-bold text-green-600">${{ number_format($product->price, 2) }}</p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Almacén</label>
                            <p class="mt-1 text-sm">{{ $product->warehouse->name ?? 'N/A' }}</p>
                            @if ($product->warehouse)
                                <p class="text-xs text-gray-400">{{ $product->warehouse->location }}</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Creado</label>
                            <p class="mt-1 text-sm">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-between pt-4 border-t">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Volver al listado
                        </a>
                        <div class="space-x-2">
                            @can('editar productos')
                                <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 transition shadow-sm">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Editar
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>