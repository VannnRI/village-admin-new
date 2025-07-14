@extends('layouts.app')

@section('title', 'Arsip Administrasi')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Arsip Administrasi</h1>
        <p class="text-gray-600">Kelola arsip administrasi desa {{ $village->name }}</p>
    </div>

    <!-- Archive Categories -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Arsip Umum -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-blue-500 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-white rounded-lg">
                        <i class="fas fa-folder text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-white">Arsip Umum</h3>
                        <p class="text-blue-100">Dokumen umum desa</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">
                    Berisi dokumen-dokumen umum desa seperti peraturan, APBDes, laporan, dan dokumen administrasi lainnya.<br>
                    <span class="block mt-2 text-sm text-blue-700">Unggah dan kelola dokumen penting desa Anda di sini. Semua file yang diarsipkan akan tersimpan rapi dan dapat diunduh kapan saja oleh Admin Desa.</span>
                </p>
                <a href="{{ route('admin-desa.archives.archives.general') }}" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Arsip Umum
                </a>
            </div>
        </div>

        <!-- Arsip Penduduk -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-green-500 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-white rounded-lg">
                        <i class="fas fa-users text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-white">Arsip Penduduk</h3>
                        <p class="text-green-100">Data kependudukan</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">Berisi data lengkap penduduk desa yang dapat diarsipkan dan diekspor dalam berbagai format.</p>
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-user mr-2 text-blue-500"></i>
                        Data Penduduk
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                        Statistik Kependudukan
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-download mr-2 text-blue-500"></i>
                        Export Data
                    </div>
                </div>
                <a href="{{ route('admin-desa.archives.archives.population') }}" class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Arsip Penduduk
                </a>
            </div>
        </div>

        <!-- Arsip Surat -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="bg-purple-500 p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-white rounded-lg">
                        <i class="fas fa-envelope text-purple-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-white">Arsip Surat</h3>
                        <p class="text-purple-100">Surat menyurat</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">Berisi arsip pengajuan surat dari masyarakat yang telah diproses dan diselesaikan.</p>
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-clock mr-2 text-yellow-500"></i>
                        Surat Pending
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-check mr-2 text-green-500"></i>
                        Surat Disetujui
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-times mr-2 text-red-500"></i>
                        Surat Ditolak
                    </div>
                </div>
                <a href="{{ route('admin-desa.archives.archives.letters') }}" class="w-full bg-purple-500 text-white py-2 px-4 rounded-lg hover:bg-purple-600 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Arsip Surat
                </a>
            </div>
        </div>
    </div>
@endsection 