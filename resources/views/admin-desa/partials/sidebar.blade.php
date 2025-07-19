@php
    $currentRoute = request()->route()->getName();
    $village = Auth::user()->villages()->first();
@endphp

<!-- Sidebar Header -->
<div class="flex flex-col items-center justify-center py-6 px-2 bg-gradient-to-br from-green-200 to-green-50 rounded-xl mb-4 shadow">
    <div class="w-16 h-16 rounded-full bg-white shadow flex items-center justify-center overflow-hidden border-4 border-green-300 mb-2">
        <i class="fas fa-home text-green-500 text-3xl"></i>
    </div>
    <div class="text-center">
        <div class="text-base font-bold text-green-700">{{ $village->name ?? 'Desa' }}</div>
        <div class="text-xs text-gray-500">Kode: {{ $village->village_code ?? '-' }}</div>
    </div>
</div>

<!-- Sidebar Menu -->
<nav class="flex flex-col gap-1">
    <a href="{{ route('admin-desa.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'admin-desa.dashboard' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-tachometer-alt mr-3"></i>
        Dashboard
    </a>
    <a href="{{ route('admin-desa.citizens.index') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.citizens') ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-users mr-3"></i>
        Data Penduduk
    </a>
    <a href="{{ route('admin-desa.letter-requests.index') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.letter-requests') ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-envelope mr-3"></i>
        Pengajuan Surat
    </a>
    <a href="{{ route('admin-desa.village.profile') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'admin-desa.village.profile' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-home mr-3"></i>
        Profil Desa
    </a>
    <a href="{{ route('admin-desa.archives.archives') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.archives') ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-archive mr-3"></i>
        Arsip Administrasi
    </a>
    <a href="{{ route('admin-desa.letter-templates.index') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.letter-templates') ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-file-alt mr-3"></i>
        Template Surat
    </a>
    <a href="{{ route('admin-desa.village-officials.index') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.village-officials') ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-sitemap mr-3"></i>
        Struktur Pemerintahan Desa
    </a>
    <a href="{{ route('admin-desa.citizens.reset-password') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'admin-desa.citizens.reset-password' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-key mr-3"></i>
        Reset Password Masyarakat
    </a>
    <a href="{{ route('admin-desa.profile') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'admin-desa.profile' ? 'bg-green-100 font-bold shadow' : 'hover:bg-green-50' }} rounded-lg transition">
        <i class="fas fa-user mr-3"></i>
        Profil Saya
    </a>
</nav> 