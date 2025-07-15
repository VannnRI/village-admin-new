<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Administrasi Desa')</title>

    <!-- Tailwind + FontAwesome + AlpineJS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-gray-100">

<!-- Wrapper -->
<div class="min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-green-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-4">
                    <!-- Hamburger for mobile -->
                    <button @click="sidebarOpen = true" class="text-white lg:hidden focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <i class="fas fa-home text-white text-2xl hidden lg:block"></i>
                    <h1 class="text-white text-xl font-semibold">Sistem Administrasi Desa</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white hidden sm:inline">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Body layout -->
    <div class="flex flex-1 overflow-hidden relative">
        <!-- Sidebar for Desktop (Always Visible) -->
        <aside class="hidden lg:block w-64 bg-white shadow-lg min-h-screen z-10">
            <div class="p-4">
                <nav class="space-y-2">
                    @yield('sidebar')
                </nav>
            </div>
        </aside>

        <!-- Sidebar for Mobile -->
        <div 
            x-show="sidebarOpen"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-40 block lg:hidden"
            @click.outside="sidebarOpen = false"
        >
            <div class="p-4">
                <nav class="space-y-2">
                    @yield('sidebar')
                </nav>
            </div>
        </div>

        <!-- Overlay when sidebar open (Mobile only) -->
        <div 
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 bg-black bg-opacity-40 z-30 lg:hidden"
            @click="sidebarOpen = false"
        ></div>

        <!-- Main Content -->
        <main class="flex-1 p-4 overflow-x-auto">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
