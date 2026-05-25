<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Movimiento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('movements.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium">Producto</label>
                            <select name="product_id" id="product_id" required
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                                <option value="">Seleccione...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                        {{ $product->name }} (SKU: {{ $product->sku }}) — {{ $product->warehouse->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="warehouse_id" class="block text-sm font-medium">Almacén</label>
                            <select name="warehouse_id" id="warehouse_id" required
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                                <option value="">Seleccione...</option>
                                @foreach (\App\Models\Warehouse::all() as $warehouse)
                                    <option value="{{ $warehouse->id }}" @selected(old('warehouse_id') == $warehouse->id)>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warehouse_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium">Tipo</label>
                            <select name="type" id="type" required
                                    class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                                <option value="entry" @selected(old('type') == 'entry')>Entrada</option>
                                <option value="exit" @selected(old('type') == 'exit')>Salida</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium">Cantidad</label>
                            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" required
                                   class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium">Notas</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-2">
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancelar</a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
