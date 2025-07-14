@php
    $currentRoute = request()->route()->getName();
@endphp

<a href="{{ route('masyarakat.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'masyarakat.dashboard' ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-tachometer-alt mr-3"></i>
    Dashboard
</a>

<a href="{{ route('masyarakat.profile') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'masyarakat.profile' ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-user mr-3"></i>
    Profil Saya
</a>

<a href="{{ route('masyarakat.letter-form') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'masyarakat.letter-form' ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-envelope-open mr-3"></i>
    Ajukan Surat
</a>

<a href="{{ route('masyarakat.letters.status') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'masyarakat.letters.status' ? 'bg-green-100' : 'hover:bg-gray-100' }} rounded-lg">
    <i class="fas fa-list mr-3"></i>
    Status Permohonan
</a> 