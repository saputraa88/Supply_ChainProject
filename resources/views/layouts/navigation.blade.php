<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">
                <!-- LOGO APLIKASI (Link dinamis sesuai Role) -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- MENU NAVIGASI (TAMPILAN DESKTOP) -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8 sm:ms-10">

                    @if(Auth::user()->role === 'admin')
                        <!-- 👑 HANYA TAMPIL UNTUK ADMIN -->
                        <x-nav-link
                            :href="route('admin.dashboard')"
                            :active="request()->routeIs('admin.dashboard')">
                            Panel Admin
                        </x-nav-link>
                    @else
                        <!-- 👥 HANYA TAMPIL UNTUK USER BIASA -->
                        <x-nav-link
                            :href="route('dashboard')"
                            :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link
                            :href="route('countries.index')"
                            :active="request()->routeIs('countries.*') && !request()->routeIs('countries.comparison')">
                            Negara
                        </x-nav-link>

                        <x-nav-link
                            :href="route('watchlist.index')"
                            :active="request()->routeIs('watchlist.index')">
                            Daftar Pantau
                        </x-nav-link>

                        <x-nav-link
                            :href="route('ports.index')"
                            :active="request()->routeIs('ports.*')">
                            Pelabuhan
                        </x-nav-link>

                        <x-nav-link
                            :href="route('countries.comparison')"
                            :active="request()->routeIs('countries.comparison')">
                            Bandingkan
                        </x-nav-link>

                        <x-nav-link
                            :href="route('currency.index')"
                            :active="request()->routeIs('currency.index')">
                            Daftar Kurs
                        </x-nav-link>

                        <x-nav-link
                            :href="route('historical.index')"
                            :active="request()->routeIs('historical.index')">
                            Visualisasi Data
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm rounded-md text-gray-500 bg-white hover:text-gray-700">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- MENU NAVIGASI (TAMPILAN RESPONSIF / MOBILE HP) -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            @if(Auth::user()->role === 'admin')
                <!-- 👑 HANYA TAMPIL UNTUK ADMIN (MOBILE) -->
                <x-responsive-nav-link
                    :href="route('admin.dashboard')"
                    :active="request()->routeIs('admin.dashboard')">
                    Panel Admin
                </x-responsive-nav-link>
            @else
                <!-- 👥 HANYA TAMPIL UNTUK USER BIASA (MOBILE) -->
                <x-responsive-nav-link
                    :href="route('dashboard')"
                    :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('countries.index')"
                    :active="request()->routeIs('countries.*') && !request()->routeIs('countries.comparison')">
                    Negara
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('watchlist.index')"
                    :active="request()->routeIs('watchlist.index')">
                    Daftar Pantau
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('ports.index')"
                    :active="request()->routeIs('ports.*')">
                    Pelabuhan
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('countries.comparison')"
                    :active="request()->routeIs('countries.comparison')">
                    Bandingkan
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('currency.index')"
                    :active="request()->routeIs('currency.index')">
                    Daftar Kurs
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('historical.index')"
                    :active="request()->routeIs('historical.index')">
                    Visualisasi Data
                </x-responsive-nav-link>
            @endif

        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Logout
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>