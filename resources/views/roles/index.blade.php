<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Roles') }}
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
            @if (session('error'))
                <div class="mb-6 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 rounded shadow-sm flex items-center">
                    <svg class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
                        <div class="flex items-center space-x-2">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-700">Roles del sistema (guard web)</h3>
                        </div>
                        <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition shadow-sm">
                            <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Nuevo Rol
                        </a>
                    </div>

                    @if ($roles->isEmpty())
                        <div class="text-center py-12 text-gray-400">
                            <p class="text-lg">No hay roles configurados</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($roles as $role)
                                <div class="border rounded-lg p-5 hover:shadow-md transition {{ $role->name === 'admin' ? 'border-purple-200 bg-purple-50' : 'border-gray-200' }}">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h4 class="font-semibold text-gray-800 capitalize">{{ $role->name }}</h4>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $role->guard_name }}</p>
                                        </div>
                                        @if ($role->name === 'admin')
                                            <span class="px-2 py-0.5 text-xs bg-purple-200 text-purple-700 rounded-full">Sistema</span>
                                        @endif
                                    </div>

                                    <div class="flex flex-wrap gap-1 mb-4">
                                        @foreach ($role->permissions as $perm)
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded">{{ $perm->name }}</span>
                                        @endforeach
                                    </div>

                                    <div class="flex items-center space-x-2 pt-3 border-t border-gray-100">
                                        <a href="{{ route('roles.edit', $role) }}"
                                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-yellow-700 bg-yellow-50 rounded hover:bg-yellow-100 transition {{ $role->name === 'admin' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                           @if ($role->name === 'admin') onclick="return false" @endif>
                                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Editar
                                        </a>
                                        @if ($role->name !== 'admin')
                                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('¿Eliminar el rol {{ $role->name }}? Se desasignará de los usuarios que lo tengan.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded hover:bg-red-100 transition">
                                                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-400">
                                                Protegido
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>