<!-- C:\xampp\htdocs\AppMedic\resources\views\layouts\navigationOpciones.blade.php -->
<nav x-data="{ open: false, openCitas: false }" class="bg-white border-b border-gray-100">
    <!-- Menú de Navegación Principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <!-- Enlace al dashboard -->
                    <a href="{{ route('dashboardOpciones') }}">
                        <!-- Componente del logo de la aplicación -->
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Enlaces de Navegación -->
                @auth
                    @if(Auth::user()->rol == 'medico' || Auth::user()->rol == 'secretaria')
                        <!-- Enlace a Pacientes -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('dashboardOpciones')" :active="request()->routeIs('dashboardOpciones')">
                                {{ __('Pacientes') }}
                            </x-nav-link>
                        </div>

                        <!-- Enlace a Citas con Submenú -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex relative">
                            <x-nav-link href="#" @click="openCitas = !openCitas" class="flex items-center">
                                {{ __('Citas') }}
                                <svg class="ml-1 h-4 w-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </x-nav-link>

                            <!-- Submenú para Citas -->
                            <div x-show="openCitas" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="top: 100%;">
                                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                    <a href="{{ route('citas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ __('Calendario') }}</a>
                                    <a href="{{ route('tablaCitas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ __('Tabla') }}</a>
                                </div>
                            </div>
                        </div>

                        <!-- Enlace a Servicios -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('servicios')" :active="request()->routeIs('servicios')">
                                {{ __('Servicios') }}
                            </x-nav-link>
                        </div>

                        <!-- Enlace a Productos -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('productos')" :active="request()->routeIs('productos')">
                                {{ __('Productos') }}
                            </x-nav-link>
                        </div>

                        <!-- Enlace a Consultas -->
                        @if(Auth::user()->rol != 'secretaria')
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <x-nav-link :href="route('consultas.porConsultar')" :active="request()->routeIs('consultas.porConsultar')">
                                    {{ __('Consultas') }}
                                </x-nav-link>
                            </div>
                        @endif
                    @elseif(Auth::user()->rol == 'admin')
                        <!-- Enlace a Pacientes -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('dashboardOpciones')" :active="request()->routeIs('dashboardOpciones')">
                                {{ __('Pacientes') }}
                            </x-nav-link>
                        </div>

                        <!-- Enlace a Médicos -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('medicos')" :active="request()->routeIs('medicos')">
                                {{ __('Usuarios') }}
                            </x-nav-link>
                        </div>

                        <!-- Enlace a Citas -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('tablaCitas')" :active="request()->routeIs('tablaCitas')">
                                {{ __('Citas') }}
                            </x-nav-link>
                        </div>

                        <!-- Enlace a Servicios -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('servicios')" :active="request()->routeIs('servicios')">
                                {{ __('Servicios') }}
                            </x-nav-link>
                        </div>

                        <!-- Enlace a Productos -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('productos')" :active="request()->routeIs('productos')">
                                {{ __('Productos') }}
                            </x-nav-link>
                        </div>

                        <!-- Enlace a Consultas -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link :href="route('consultas.porConsultar')" :active="request()->routeIs('consultas.porConsultar')">
                                {{ __('Consultas') }}
                            </x-nav-link>
                        </div>
                    @endif
                @endauth
            </div>

            <!-- Menú de Configuración -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- Botón de Desplegable para el menú de configuración -->
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div class="mr-2 font-medium text-sm text-gray-500">{{ Auth::user()->email }} </div>

                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->rol }}</div>

                            <div class="ms-1">
                                <!-- Icono de Flecha -->
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 111.414 1.414l-4 4a1 1 01-1.414 0l-4-4a1 1 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Enlace al Perfil -->
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Autenticación -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
            </div>

            <!-- Botón de Menú para Móviles -->
            <div class="-me-2 flex items-center sm:hidden">
                <!-- Botón para abrir/cerrar el menú de navegación responsivo -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <!-- Icono de Menú -->
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <!-- Icono de Cerrar -->
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú de Navegación Responsivo -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
            @if(Auth::user()->rol == 'medico')
                <!-- Enlace a Pacientes (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboardOpciones')" :active="request()->routeIs('dashboardOpciones')">
                        {{ __('Pacientes') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Citas (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('citas')" :active="request()->routeIs('citas')">
                        {{ __('Calendario') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('tablaCitas')" :active="request()->routeIs('tablaCitas')">
                        {{ __('Tabla') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Servicios (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('servicios')" :active="request()->routeIs('servicios')">
                        {{ __('Servicios') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Productos (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('productos')" :active="request()->routeIs('productos')">
                        {{ __('Productos') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Consultas (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('consultas.porConsultar')" :active="request()->routeIs('consultas.porConsultar')">
                        {{ __('Consultas') }}
                    </x-responsive-nav-link>
                </div>
            @elseif(Auth::user()->rol == 'admin')
                <!-- Enlace a Pacientes (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboardOpciones')" :active="request()->routeIs('dashboardOpciones')">
                        {{ __('Pacientes') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Médicos (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('medicos')" :active="request()->routeIs('medicos')">
                        {{ __('Usuarios') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Citas (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('tablaCitas')" :active="request()->routeIs('tablaCitas')">
                        {{ __('Citas') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Servicios (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('servicios')" :active="request()->routeIs('servicios')">
                        {{ __('Servicios') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Productos (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('productos')" :active="request()->routeIs('productos')">
                        {{ __('Productos') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Consultas (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('consultas.porConsultar')" :active="request()->routeIs('consultas.porConsultar')">
                        {{ __('Consultas') }}
                    </x-responsive-nav-link>
                </div>
            @elseif(Auth::user()->rol == 'secretaria')
                <!-- Enlace a Pacientes (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboardOpciones')" :active="request()->routeIs('dashboardOpciones')">
                        {{ __('Pacientes') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Citas (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('citas')" :active="request()->routeIs('citas')">
                        {{ __('Calendario') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('tablaCitas')" :active="request()->routeIs('tablaCitas')">
                        {{ __('Tabla') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Servicios (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('servicios')" :active="request()->routeIs('servicios')">
                        {{ __('Servicios') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Enlace a Productos (versión responsiva) -->
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('productos')" :active="request()->routeIs('productos')">
                        {{ __('Productos') }}
                    </x-responsive-nav-link>
                </div>
            @endif

            <!-- Opciones de Configuración Responsivas -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->nombres }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Enlace al Perfil (versión responsiva) -->
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Autenticación (versión responsiva) -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
