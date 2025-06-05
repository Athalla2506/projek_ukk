<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gradient-to-br from-indigo-50 to-white dark:from-gray-200 dark:to-indigo-400">
        <div class="flex min-h-screen">
            <flux:sidebar sticky stashable class="border-e border-indigo-200 bg-white dark:border-indigo-700 dark:bg-indigo-700 w-64 shadow-lg">
                <flux:sidebar.toggle class="lg:hidden text-indigo-600 dark:text-indigo-300" icon="x-mark" />

                <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo class="text-indigo-600 dark:text-indigo-300" />
                </a>

                <flux:navlist variant="outline" class="mt-6">
                    <flux:navlist.group :heading="__('Platform')" class="grid gap-1">
                        <flux:navlist.item 
                            icon="home" 
                            :href="route('dashboard')" 
                            :current="request()->routeIs('dashboard')" 
                            wire:navigate
                            class="hover:bg-indigo-50 dark:hover:bg-indigo-800/50 transition-colors duration-200"
                        >
                            {{ __('Dashboard') }}
                        </flux:navlist.item>

                        

                            <flux:navlist.item 
                                icon="building-office-2" 
                                :href="route('industri.index')"  
                                :current="request()->routeIs('industri.index')"
                                wire:navigate
                                class="hover:bg-indigo-50 dark:hover:bg-indigo-800/50 transition-colors duration-200"
                            >
                                {{ __('Industri') }}
                            </flux:navlist.item>
                        
                    </flux:navlist.group>
                </flux:navlist>

                <flux:spacer />

                <!-- Desktop User Menu -->
                <flux:dropdown position="bottom" align="start">
                    <flux:profile
                        :name="auth()->user()->name"
                        :initials="auth()->user()->initials()"
                        icon-trailing="chevrons-up-down"
                        class="bg-indigo-100 dark:bg-indigo-800/50 hover:bg-indigo-200 dark:hover:bg-indigo-700/50 transition-colors duration-200 rounded-lg shadow-sm text-lg"
                    />

                    <flux:menu class="w-[250px] bg-white dark:bg-indigo-900 shadow-2xl border border-indigo-200 dark:border-indigo-700 rounded-lg">
                        <flux:menu.radio.group>
                            <div class="p-2 font-normal">
                                <div class="flex items-center gap-3 px-2 py-2 text-start text-base hover:bg-indigo-50 dark:hover:bg-indigo-800/50 rounded-lg transition-all duration-200">
                                    <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-lg shadow-md">
                                        <span
                                            class="flex h-full w-full items-center justify-center rounded-lg bg-indigo-200 text-indigo-700 dark:bg-indigo-700 dark:text-white font-semibold text-lg"
                                        >
                                            {{ auth()->user()->initials() }}
                                        </span>
                                    </span>

                                    <div class="grid flex-1 text-start leading-tight">
                                        <span class="truncate font-bold text-indigo-700 dark:text-indigo-200 text-base">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-sm text-indigo-500 dark:text-indigo-300">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator class="border-indigo-100 dark:border-indigo-700" />

                        <flux:menu.radio.group class="p-1">
                            <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate 
                                class="hover:bg-indigo-50 dark:hover:bg-indigo-800/50 text-indigo-600 dark:text-indigo-200 rounded-lg transition-all duration-200 text-base">
                                {{ __('Settings') }}
                            </flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator class="border-indigo-100 dark:border-indigo-700" />

                        <form method="POST" action="{{ route('logout') }}" class="w-full p-1">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" 
                                class="w-full hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg transition-all duration-200 text-base">
                                {{ __('Log Out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </flux:sidebar>

            <div class="flex-1 flex flex-col">
                <!-- Mobile User Menu -->
                <flux:header class="lg:hidden bg-white/80 dark:bg-indigo-900/50 border-b border-indigo-100 dark:border-indigo-700 backdrop-blur-sm">
                    <flux:sidebar.toggle class="lg:hidden text-indigo-600 dark:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-800/50 rounded-lg p-2 transition-colors duration-200" icon="bars-2" inset="left" />

                    <flux:spacer />

                    <flux:dropdown position="top" align="end">
                        <flux:profile
                            :initials="auth()->user()->initials()"
                            icon-trailing="chevron-down"
                            class="bg-indigo-100 dark:bg-indigo-800/50 hover:bg-indigo-200 dark:hover:bg-indigo-700/50 transition-colors duration-200 rounded-lg text-lg"
                        />

                        <flux:menu class="w-[250px] bg-white dark:bg-indigo-900 shadow-2xl border border-indigo-200 dark:border-indigo-700 rounded-lg">
                            <flux:menu.radio.group>
                                <div class="p-2 font-normal">
                                    <div class="flex items-center gap-3 px-2 py-2 text-start text-base hover:bg-indigo-50 dark:hover:bg-indigo-800/50 rounded-lg transition-all duration-200">
                                        <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-lg shadow-md">
                                            <span
                                                class="flex h-full w-full items-center justify-center rounded-lg bg-indigo-200 text-indigo-700 dark:bg-indigo-700 dark:text-white font-semibold text-lg"
                                            >
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-start leading-tight">
                                            <span class="truncate font-bold text-indigo-700 dark:text-indigo-200 text-base">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-sm text-indigo-500 dark:text-indigo-300">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator class="border-indigo-100 dark:border-indigo-700" />

                            <flux:menu.radio.group class="p-1">
                                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate
                                    class="hover:bg-indigo-50 dark:hover:bg-indigo-800/50 text-indigo-600 dark:text-indigo-200 rounded-lg transition-all duration-200 text-base">
                                    {{ __('Settings') }}
                                </flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator class="border-indigo-100 dark:border-indigo-700" />

                            <form method="POST" action="{{ route('logout') }}" class="w-full p-1">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" 
                                    class="w-full hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg transition-all duration-200 text-base">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </flux:header>

                <main class="p-6 flex-1">
                    {{ $slot }}
                </main>

                @fluxScripts
            </div>
        </div>
    </body>
</html>