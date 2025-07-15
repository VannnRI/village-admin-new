@extends('layouts.app')

@section('title', 'Arsip Penduduk')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Arsip Penduduk</h1>
                <p class="text-gray-600">Data kependudukan desa {{ $village->name }}</p>
            </div>
            <a href="{{ route('admin-desa.archives.archives') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Penduduk</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $citizens->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-male text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Laki-laki</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $citizens->where('gender', 'L')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-pink-100 rounded-lg">
                    <i class="fas fa-female text-pink-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Perempuan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $citizens->where('gender', 'P')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Export Data Penduduk</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin-desa.archives.archives.download', ['type' => 'population', 'id' => 'excel']) }}" 
               class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-file-excel text-green-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Export Excel</h3>
                    <p class="text-sm text-gray-600">Download data dalam format Excel</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, NIK, atau KK..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" type="submit">
                <i class="fas fa-search mr-2"></i>
                Cari
            </button>
        </form>
    </div>

    <!-- Population Data Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Data Penduduk</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. KK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempat, Tgl Lahir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($citizens as $citizen)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $citizen->name }}</div>
                            <div class="text-sm text-gray-500">{{ $citizen->phone ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $citizen->nik }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $citizen->kk_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($citizen->gender == 'L') bg-blue-100 text-blue-800
                                @else bg-pink-100 text-pink-800
                                @endif">
                                {{ $citizen->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($citizen->birth_date)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="max-w-xs truncate">{{ $citizen->address }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            @if(request('q') && $totalCitizens > 0)
                            <div class="flex flex-col items-center">
                                <i class="fas fa-search text-4xl text-gray-300 mb-2"></i>
                                <p>Tidak ditemukan data penduduk sesuai pencarian.</p>
                            </div>
                            @else
                            <div class="flex flex-col items-center">
                                <i class="fas fa-users text-4xl text-gray-300 mb-2"></i>
                                <p>Belum ada data penduduk</p>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Demographic Charts -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Jenis Kelamin</h3>
            <div class="flex items-center justify-center h-48">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $citizens->where('gender', 'L')->count() }}</div>
                    <div class="text-sm text-gray-600">Laki-laki</div>
                </div>
                <div class="mx-8 text-gray-300">|</div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-pink-600">{{ $citizens->where('gender', 'P')->count() }}</div>
                    <div class="text-sm text-gray-600">Perempuan</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Umur</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">0-17 tahun</span>
                    <span class="text-sm font-medium text-gray-900">{{ $umur_0_17 }} orang</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">18-60 tahun</span>
                    <span class="text-sm font-medium text-gray-900">{{ $umur_18_60 }} orang</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">>60 tahun</span>
                    <span class="text-sm font-medium text-gray-900">{{ $umur_60 }} orang</span>
                </div>
            </div>
        </div>
    </div>
@endsection 