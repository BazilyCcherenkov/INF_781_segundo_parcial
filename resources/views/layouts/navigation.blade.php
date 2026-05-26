<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-700 to-indigo-800 border-b border-indigo-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span class="text-white font-bold text-lg">AlmaTrack</span>
                    </a>
                </div>

                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-blue-600">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @can('ver productos')
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-white hover:bg-blue-600">
                            {{ __('Productos') }}
                        </x-nav-link>
                    @endcan

                    @can('registrar movimiento')
                        <x-nav-link :href="route('movements.index')" :active="request()->routeIs('movements.*')" class="text-white hover:bg-blue-600">
                            {{ __('Movimientos') }}
                        </x-nav-link>
                    @endcan

                    @can('gestionar roles')
                        <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" class="text-white hover:bg-blue-600">
                            {{ __('Roles') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none transition ease-in-out duration-150">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                            @php
                                $role = Auth::user()->roles->first();
                            @endphp
                            @if ($role)
                                <span class="ml-2 px-2 py-0.5 text-xs bg-indigo-900 text-indigo-200 rounded-full">{{ $role->name }}</span>
                            @endif
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-indigo-200 hover:text-white hover:bg-blue-600 focus:outline-none focus:bg-blue-600 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-indigo-800">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:bg-blue-600">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @can('ver productos')
                <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-white hover:bg-blue-600">
                    {{ __('Productos') }}
                </x-responsive-nav-link>
            @endcan

            @can('registrar movimiento')
                <x-responsive-nav-link :href="route('movements.index')" :active="request()->routeIs('movements.*')" class="text-white hover:bg-blue-600">
                    {{ __('Movimientos') }}
                </x-responsive-nav-link>
            @endcan

            @can('gestionar roles')
                <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')" class="text-white hover:bg-blue-600">
                    {{ __('Roles') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <div class="pt-4 pb-1 border-t border-indigo-700 bg-indigo-800">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-indigo-300">{{ Auth::user()->email }}</div>
                @php $role = Auth::user()->roles->first(); @endphp
                @if ($role)
                    <div class="mt-1">
                        <span class="px-2 py-0.5 text-xs bg-indigo-900 text-indigo-200 rounded-full">{{ $role->name }}</span>
                    </div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white hover:bg-blue-600">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-white hover:bg-blue-600">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>