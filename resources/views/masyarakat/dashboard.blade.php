@extends('layouts.app')

@section('title', 'Dashboard Masyarakat')

@section('sidebar')
    @include('masyarakat.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Selamat Datang, {{ $citizen->name ?? '-' }}</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mb-6">
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user text-green-600 mr-2"></i>
                Informasi Pribadi
            </h3>
            <div class="space-y-2">
                <p><span class="font-medium">Nama:</span> {{ $citizen->name ?? '-' }}</p>
                <p><span class="font-medium">NIK:</span> {{ $citizen->nik ?? '-' }}</p>
                <p><span class="font-medium">No KK:</span> {{ $citizen->kk_number ?? '-' }}</p>
                <p><span class="font-medium">Alamat:</span> {{ $citizen->address ?? '-' }}</p>
            </div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-home text-green-600 mr-2"></i>
                Informasi Desa
            </h3>
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map-marker-alt text-blue-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nama Desa</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $village->name ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-map text-green-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kecamatan</p>
                        <p class="text-sm text-gray-900">{{ $village->district ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-building text-purple-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Kabupaten</p>
                        <p class="text-sm text-gray-900">{{ $village->regency ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('masyarakat.letter-form') }}" class="bg-green-600 hover:bg-green-700 text-white rounded-lg p-4 text-center transition duration-200">
            <i class="fas fa-envelope-open text-2xl mb-2"></i>
            <div class="font-semibold">Ajukan Surat</div>
        </a>
        
        <a href="{{ route('masyarakat.letters.status') }}" class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg p-4 text-center transition duration-200">
            <i class="fas fa-list text-2xl mb-2"></i>
            <div class="font-semibold">Status Surat</div>
        </a>
        
        <a href="{{ route('masyarakat.profile') }}" class="bg-purple-600 hover:bg-purple-700 text-white rounded-lg p-4 text-center transition duration-200">
            <i class="fas fa-user text-2xl mb-2"></i>
            <div class="font-semibold">Profil</div>
        </a>
    </div>
</div>
@endsection 