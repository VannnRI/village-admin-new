@php
    $currentRoute = request()->route()->getName();
@endphp

<a href="{{ route('admin-desa.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'admin-desa.dashboard' ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-tachometer-alt mr-3"></i>
    Dashboard
</a>

<a href="{{ route('admin-desa.citizens.index') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.citizens') ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-users mr-3"></i>
    Data Penduduk
</a>

<a href="{{ route('admin-desa.letter-requests.index') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.letter-requests') ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-envelope mr-3"></i>
    Pengajuan Surat
</a>

<a href="{{ route('admin-desa.village.profile') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'admin-desa.village.profile' ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-home mr-3"></i>
    Profil Desa
</a>

<a href="{{ route('admin-desa.archives.archives') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.archives') ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-archive mr-3"></i>
    Arsip Administrasi
</a>

<a href="{{ route('admin-desa.letter-templates.index') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'admin-desa.letter-templates') ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-file-alt mr-3"></i>
    Template Surat
</a>

<a href="{{ route('admin-desa.government-structure') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'admin-desa.government-structure' ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-sitemap mr-3"></i>
    Struktur Pemerintahan Desa
</a> 