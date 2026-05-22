<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CandidatureTracker') }} — @yield('title', 'Dashboard')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            window.__dark = localStorage.getItem('dark') === 'true';
            if (window.__dark) document.documentElement.classList.add('dark');
        </script>
        <script>
            window.theme = {
                toggle(btn) {
                    const next = !window.__dark;
                    window.__dark = next;
                    localStorage.setItem('dark', next);
                    document.documentElement.classList.toggle('dark', next);
                    this._updateBtn(btn, next);
                },
                _updateBtn(btn, dark) {
                    btn.querySelector('[data-theme-sun]').style.display = dark ? 'none' : '';
                    btn.querySelector('[data-theme-moon]').style.display = dark ? '' : 'none';
                    btn.querySelector('[data-theme-label]').textContent = dark ? 'Light mode' : 'Dark mode';
                }
            };
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-950">
        <div class="min-h-screen flex"
             x-data="{ sidebarOpen: window.innerWidth >= 1024 }"
             x-init="$watch('sidebarOpen', val => { if (window.innerWidth >= 1024 && !val) sidebarOpen = true }); window.addEventListener('resize', () => { if (window.innerWidth >= 1024) sidebarOpen = true })">

            {{-- Mobile Overlay --}}
            <div x-show="sidebarOpen && window.innerWidth < 1024"
                 x-transition:enter="transition-opacity ease-linear duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-30 bg-gray-900/50 dark:bg-gray-950/70 lg:hidden">
            </div>

            {{-- Sidebar --}}
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-transform ease-in-out duration-200"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition-transform ease-in-out duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed lg:static inset-y-0 left-0 z-40 w-64 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-800 flex flex-col shadow-lg lg:shadow-none">
                @include('layouts.navigation')
                <script>(function(){var b=document.querySelector('[data-theme-btn]');if(b)window.theme._updateBtn(b,window.__dark)})()</script>
            </div>

            {{-- Main Content --}}
            <div class="flex-1 flex flex-col min-w-0">
                {{-- Top bar with mobile menu + page header --}}
                <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-sm sticky top-0 z-20">
                    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">
                        <div class="flex items-center gap-3">
                            <button @click="sidebarOpen = !sidebarOpen" class="p-1.5 -ml-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors lg:hidden">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            @isset($header)
                                <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100 truncate">
                                    {{ $header }}
                                </h1>
                            @endisset
                        </div>
                        @if (isset($headerAction))
                            <div>{{ $headerAction }}</div>
                        @endif
                    </div>
                </header>

                <main class="flex-1">
                    @if (session('success'))
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
                            <div class="flex items-center justify-between px-5 py-3 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-lg shadow-sm" role="alert">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ session('success') }}</span>
                                </div>
                                <button onclick="this.parentElement.remove()" class="shrink-0 p-1 rounded hover:bg-emerald-100 dark:hover:bg-emerald-800/50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
                            <div class="flex items-center justify-between px-5 py-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg shadow-sm" role="alert">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium">{{ session('error') }}</span>
                                </div>
                                <button onclick="this.parentElement.remove()" class="shrink-0 p-1 rounded hover:bg-red-100 dark:hover:bg-red-800/50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
                </main>

                <footer class="border-t border-gray-200 dark:border-gray-800">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        <p class="text-center text-xs text-gray-400 dark:text-gray-600">
                            CandidatureTracker &mdash; Track your job applications efficiently
                        </p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
