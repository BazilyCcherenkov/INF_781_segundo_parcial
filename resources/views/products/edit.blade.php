<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Producto: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('products.update', $product) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="sku" class="block text-sm font-medium">SKU</label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                            @error('sku') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium">Descripción</label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="stock" class="block text-sm font-medium">Stock</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" min="0" required
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium">Precio</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" min="0" required
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="warehouse_id" class="block text-sm font-medium">Almacén</label>
                            <select name="warehouse_id" id="warehouse_id" required
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                                <option value="">Seleccione...</option>
                                @foreach (\App\Models\Warehouse::all() as $warehouse)
                                    <option value="{{ $warehouse->id }}" @selected(old('warehouse_id', $product->warehouse_id) == $warehouse->id)>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
