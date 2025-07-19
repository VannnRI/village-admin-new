@extends('layouts.app')

@section('title', 'Dashboard Admin Desa')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin Desa</h1>
        <p class="text-gray-600">Selamat datang di panel Admin Desa {{ $village->name }}</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Penduduk</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalCitizens }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Surat Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pendingLetters }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Surat Disetujui</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $approvedLetters }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <a href="{{ route('admin-desa.citizens.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-user-plus text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Tambah Penduduk</h3>
                    <p class="text-sm text-gray-600">Tambah data penduduk baru</p>
                </div>
            </a>

            <a href="{{ route('admin-desa.letter-requests.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-envelope text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Lihat Pengajuan</h3>
                    <p class="text-sm text-gray-600">Kelola pengajuan surat dari masyarakat</p>
                </div>
            </a>

            <a href="{{ route('admin-desa.village.profile') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-edit text-green-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Edit Profil Desa</h3>
                    <p class="text-sm text-gray-600">Update informasi desa</p>
                </div>
            </a>

            <a href="{{ route('admin-desa.archives.archives') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-archive text-purple-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Arsip Administrasi</h3>
                    <p class="text-sm text-gray-600">Kelola arsip umum, penduduk, dan surat</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h2>
        <div class="space-y-4">
            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-info text-blue-600"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Selamat datang di platform administrasi desa</p>
                    <p class="text-xs text-gray-500">Mulai kelola data penduduk dan pengajuan surat</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Desa -->
    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-home text-green-600 mr-3"></i>
            Info Desa
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nama Desa</p>
                        <p class="text-base font-semibold text-gray-900">{{ $village->name ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map text-green-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Alamat</p>
                        <p class="text-base text-gray-900">{{ $village->address ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-envelope text-purple-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="text-base text-gray-900">{{ $village->email ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-phone text-orange-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Telepon</p>
                        <p class="text-base text-gray-900">{{ $village->phone ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-globe text-indigo-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Website</p>
                        <p class="text-base text-gray-900">{{ $village->website ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 