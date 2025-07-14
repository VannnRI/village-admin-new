@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('sidebar')
    <a href="{{ route('super-admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 bg-green-100 rounded-lg">
        <i class="fas fa-tachometer-alt mr-3"></i>
        Dashboard
    </a>
    <a href="{{ route('super-admin.villages') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-home mr-3"></i>
        Kelola Desa
    </a>
    <a href="{{ route('super-admin.users') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-users mr-3"></i>
        Kelola User
    </a>
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Super Admin</h1>
        <p class="text-gray-600">Selamat datang di panel Super Admin</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-home text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Desa</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalVillages }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-user-tie text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Admin Desa</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalAdminDesa }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-user-cog text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Perangkat Desa</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalPerangkatDesa }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('super-admin.villages.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-plus text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Tambah Desa</h3>
                    <p class="text-sm text-gray-600">Buat desa baru dalam sistem</p>
                </div>
            </a>

            <a href="{{ route('super-admin.users.create') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-user-plus text-green-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Tambah User</h3>
                    <p class="text-sm text-gray-600">Buat akun admin desa atau perangkat desa</p>
                </div>
            </a>
        </div>
    </div>
@endsection 