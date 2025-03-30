<nav
    x-data="{ open: false }"
    class="bg-gray-100 fixed top-0 right-0 left-0 z-10"
>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex gap-2 items-center">
                    <a href="{{ route('home') }}">
                        <img
                            src="{{ asset('assets/images/logo.png') }}"
                            class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200"
                        />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div
                    class="hidden space-x-8 sm:-my-px sm:ms-5 md:ms-10 sm:flex"
                >
                    <x-nav-link wire:navigate.hover
                        :href="route('home')"
                        :active="request()->routeIs('home')"
                    >
                        Beranda
                    </x-nav-link>
                </div>
                <div
                    class="hidden space-x-8 sm:-my-px sm:ms-5 md:ms-10 sm:flex"
                >
                    <x-nav-link wire:navigate.hover
                        :href="route('about')"
                        :active="request()->routeIs('about')"
                    >
                        Tentang Kami
                    </x-nav-link>
                </div>
                <div
                    class="hidden space-x-8 sm:-my-px sm:ms-5 md:ms-10 sm:flex"
                >
                    <x-nav-link wire:navigate.hover
                        :href="route('products')"
                        :active="request()->routeIs('products')"
                    >
                        Hasil Pengolahan
                    </x-nav-link>
                </div>
                <div
                    class="hidden space-x-8 sm:-my-px sm:ms-5 md:ms-10 sm:flex"
                >
                    <x-nav-link wire:navigate.hover
                        :href="route('posts')"
                        :active="request()->routeIs('posts')"
                    >
                        Kegiatan
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                        >
                            <div>
                                <p class="text-xs md:text-sm">Hi {{ Auth::user()->name }}</p>
                            </div>
                            <div class="ms-1">
                                <svg
                                    class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profil
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                            >
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
                @guest
                    <a
                        href="{{ route('login') }}" wire:navigate.hover
                        class="btn border-0 bg-gray-100 hover:shadow-none text-gray-500 hover:text-black {{ request()->routeIs('login') ? 'text-black' : ''}}"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="size-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"
                            />
                        </svg>
                        Login
                    </a>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                >
                    <svg
                        class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <path
                            :class="{'hidden': open, 'inline-flex': ! open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{'hidden': ! open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link wire:navigate.hover
                :href="route('home')"
                :active="request()->routeIs('home')"
            >
                Beranda
            </x-responsive-nav-link>
            <x-responsive-nav-link wire:navigate.hover
                :href="route('about')"
                :active="request()->routeIs('about')"
            >
                Tentang Kami
            </x-responsive-nav-link>
            <x-responsive-nav-link wire:navigate.hover
                :href="route('products')"
                :active="request()->routeIs('products')"
            >
                Hasil Olahan
            </x-responsive-nav-link>
            <x-responsive-nav-link wire:navigate.hover
                :href="route('posts')"
                :active="request()->routeIs('posts')"
            >
                Kegiatan
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="@auth pt-4 @endauth pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
                <div class="px-4">
                    <div
                        class="font-medium text-base text-gray-800 dark:text-gray-200"
                    >
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>
            @endauth

            <div class="mt-3 space-y-1">
                @guest
                    <a
                    href="{{ route('login') }}" wire:navigate.hover
                    class="btn mb-2 border-0 bg-gray-100 hover:shadow-none text-gray-500 hover:text-black {{ request()->routeIs('login') ? 'text-black' : ''}}"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"
                        />
                    </svg>
                    Login
                </a>    
                @endguest
                
                @auth
                    <x-responsive-nav-link wire:navigate.hover :href="route('profile.edit')">
                        Profil
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link
                            :href="route('logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();"
                        >
                            Logout
                        </x-responsive-nav-link>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
