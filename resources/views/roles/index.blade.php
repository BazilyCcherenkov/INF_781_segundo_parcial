<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Roles') }}
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
                    @if (session('error'))
                        <div class="mb-4 px-4 py-2 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Roles del sistema (guard web)</h3>
                        <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            + Crear Rol
                        </a>
                    </div>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 px-4">Nombre</th>
                                <th class="py-2 px-4">Permisos</th>
                                <th class="py-2 px-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-4 font-medium">{{ $role->name }}</td>
                                    <td class="py-2 px-4">
                                        @foreach ($role->permissions as $perm)
                                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 rounded mr-1">{{ $perm->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="py-2 px-4 space-x-2">
                                        <a href="{{ route('roles.edit', $role) }}" class="text-yellow-600 hover:underline">Editar</a>
                                        @if ($role->name !== 'admin')
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Eliminar el rol {{ $role->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm">(protegido)</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
