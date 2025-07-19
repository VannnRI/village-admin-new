@php
    $currentRoute = request()->route()->getName();
    $village = Auth::user()->villages()->first();
@endphp

<!-- Sidebar Header -->
<div class="flex flex-col items-center justify-center py-6 px-2 bg-gradient-to-br from-green-200 to-green-50 rounded-xl mb-4 shadow">
    <div class="w-16 h-16 rounded-full bg-white shadow flex items-center justify-center overflow-hidden border-4 border-green-300 mb-2">
        <i class="fas fa-user-cog text-green-500 text-3xl"></i>
    </div>
    <div class="text-center">
        <div class="text-base font-bold text-green-700">{{ $village->name ?? 'Desa' }}</div>
        <div class="text-xs text-gray-500">Perangkat Desa</div>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="flex flex-col gap-1">
    <a href="{{ route('perangkat-desa.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'perangkat-desa.dashboard' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-tachometer-alt mr-3"></i>
        Dashboard
    </a>
    <a href="{{ route('perangkat-desa.letter-requests') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'perangkat-desa.letter-requests') ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-envelope mr-3"></i>
        Permohonan Surat
    </a>
    <a href="{{ route('perangkat-desa.profile') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'perangkat-desa.profile' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-user mr-3"></i>
        Profil Saya
    </a>
</nav> 