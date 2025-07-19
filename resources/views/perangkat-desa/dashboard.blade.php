@extends('layouts.app')

@section('title', 'Dashboard Perangkat Desa')

@section('sidebar')
    @include('perangkat-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Perangkat Desa</h1>
        <p class="text-gray-600">Selamat datang di panel Perangkat Desa untuk desa {{ $village->name ?? '-' }}.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pending ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $approved ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <i class="fas fa-times text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $rejected ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
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