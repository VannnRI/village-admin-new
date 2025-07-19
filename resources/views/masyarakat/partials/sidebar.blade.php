@php
    $currentRoute = request()->route()->getName();
    $user = Auth::user();
@endphp

<!-- Sidebar Header -->
<div class="flex flex-col items-center justify-center py-6 px-2 bg-gradient-to-br from-green-200 to-green-50 rounded-xl mb-4 shadow">
    <div class="w-16 h-16 rounded-full bg-white shadow flex items-center justify-center overflow-hidden border-4 border-green-300 mb-2">
        <i class="fas fa-user text-green-500 text-3xl"></i>
    </div>
    <div class="text-center">
        <div class="text-base font-bold text-green-700">{{ $user->name ?? 'Pengguna' }}</div>
        <div class="text-xs text-gray-500">Masyarakat</div>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="flex flex-col gap-1">
    <a href="{{ route('masyarakat.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'masyarakat.dashboard' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-tachometer-alt mr-3"></i>
        Dashboard
    </a>
    <a href="{{ route('masyarakat.profile') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'masyarakat.profile' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-user mr-3"></i>
        Profil Saya
    </a>
    <a href="{{ route('masyarakat.letter-form') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'masyarakat.letter-form' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-envelope-open mr-3"></i>
        Ajukan Surat
    </a>
    <a href="{{ route('masyarakat.letters.status') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'masyarakat.letters.status' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-list mr-3"></i>
        Status Permohonan
    </a>
</nav> 