<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Platform Administrasi Desa')</title>

    <!-- Alpine.js x-cloak CSS -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Tailwind + FontAwesome + AlpineJS -->
    @if(config('app.env') === 'production')
        <!-- Production: Use compiled CSS -->
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    @else
        <!-- Development: Use CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
                    <h1 class="text-white text-xl font-semibold hidden md:block">Platform Administrasi Desa</h1>
                    <h1 class="text-white text-lg font-semibold md:hidden">PAD</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white hidden sm:inline">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white hover:text-gray-200 flex items-center space-x-1">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden sm:inline">Logout</span>
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
            <!-- Toast Notification -->
            <div x-data="{ show: true }" class="fixed top-6 right-6 z-50">
                @if(session('success'))
                    <div x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="flex items-center bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-lg min-w-[320px] max-w-xs" style="box-shadow: 0 8px 24px rgba(0,0,0,0.08)">
                        <i class="fas fa-check-circle mr-3 text-2xl text-green-500"></i>
                        <span class="flex-1 font-medium">{{ session('success') }}</span>
                        <button @click="show = false" class="ml-4 text-green-700 hover:text-green-900 focus:outline-none text-xl">&times;</button>
                    </div>
                @endif
                @if(session('error'))
                    <div x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)" class="flex items-center bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-lg min-w-[320px] max-w-xs" style="box-shadow: 0 8px 24px rgba(0,0,0,0.08)">
                        <i class="fas fa-exclamation-circle mr-3 text-2xl text-red-500"></i>
                        <span class="flex-1 font-medium">{{ session('error') }}</span>
                        <button @click="show = false" class="ml-4 text-red-700 hover:text-red-900 focus:outline-none text-xl">&times;</button>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
