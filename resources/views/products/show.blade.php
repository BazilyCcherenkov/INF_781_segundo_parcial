<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Producto: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="font-medium text-gray-500">SKU</dt>
                            <dd>{{ $product->sku }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Nombre</dt>
                            <dd>{{ $product->name }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Descripción</dt>
                            <dd>{{ $product->description ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Stock</dt>
                            <dd>{{ $product->stock }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Precio</dt>
                            <dd>${{ number_format($product->price, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-500">Almacén</dt>
                            <dd>{{ $product->warehouse->name ?? 'N/A' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 space-x-2">
                        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Volver</a>
                        @can('editar productos')
                            <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
