@extends('layouts.app')

@section('title', 'Dashboard Perangkat Desa')

@section('sidebar')
    <a href="{{ route('perangkat-desa.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 bg-green-100 rounded-lg">
        <i class="fas fa-tachometer-alt mr-3"></i>
        Dashboard
    </a>
    <a href="{{ route('perangkat-desa.letter-requests') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-envelope mr-3"></i>
        Permohonan Surat
    </a>
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
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Info Desa</h2>
        <p><strong>Nama Desa:</strong> {{ $village->name ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $village->address ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $village->email ?? '-' }}</p>
        <p><strong>Telepon:</strong> {{ $village->phone ?? '-' }}</p>
    </div>
@endsection 