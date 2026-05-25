<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Listado de productos</h3>
                        @can('crear productos')
                            <a href="{{ route('products.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                + Crear Producto
                            </a>
                        @endcan
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 px-4">SKU</th>
                                <th class="py-2 px-4">Nombre</th>
                                <th class="py-2 px-4">Stock</th>
                                <th class="py-2 px-4">Precio</th>
                                <th class="py-2 px-4">Almacén</th>
                                <th class="py-2 px-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-4">{{ $product->sku }}</td>
                                    <td class="py-2 px-4">{{ $product->name }}</td>
                                    <td class="py-2 px-4">{{ $product->stock }}</td>
                                    <td class="py-2 px-4">${{ number_format($product->price, 2) }}</td>
                                    <td class="py-2 px-4">{{ $product->warehouse->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 space-x-2">
                                        <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">Ver</a>

                                        @can('editar productos')
                                            <a href="{{ route('products.edit', $product) }}" class="text-yellow-600 hover:underline">Editar</a>
                                        @endcan

                                        @can('eliminar productos')
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
