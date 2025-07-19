@extends('layouts.app')

@section('title', 'Arsip Surat')

@section('sidebar')
    <a href="{{ route('admin-desa.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-tachometer-alt mr-3"></i>
        Dashboard
    </a>
    <a href="{{ route('admin-desa.citizens.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-users mr-3"></i>
        Data Penduduk
    </a>
    <a href="{{ route('admin-desa.letter-requests.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-envelope mr-3"></i>
        Pengajuan Surat
    </a>
    <a href="{{ route('admin-desa.village.profile') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-home mr-3"></i>
        Profil Desa
    </a>
    <a href="{{ route('admin-desa.archives.archives') }}" class="flex items-center px-4 py-2 text-gray-700 bg-green-100 rounded-lg">
        <i class="fas fa-archive mr-3"></i>
        Arsip Administrasi
    </a>
@endsection

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Arsip Surat</h1>
                <p class="text-gray-600">Arsip pengajuan surat dari masyarakat desa {{ $village->name }}</p>
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
                    <i class="fas fa-envelope text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Surat</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $letterRequests->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $pendingLetters->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $approvedLetters->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-times text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Ditolak</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $rejectedLetters->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Export Data Surat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin-desa.archives.download', ['type' => 'letters', 'id' => 'excel']) }}" 
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

    <!-- Filter Tabs -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6">
                <a href="#" class="border-b-2 border-blue-500 py-4 px-1 text-sm font-medium text-blue-600">
                    Semua ({{ $letterRequests->count() }})
                </a>
                <a href="#" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Pending ({{ $pendingLetters->count() }})
                </a>
                <a href="#" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Disetujui ({{ $approvedLetters->count() }})
                </a>
                <a href="#" class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Ditolak ({{ $rejectedLetters->count() }})
                </a>
            </nav>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Cari nama pemohon atau jenis surat..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex gap-2">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Disetujui</option>
                    <option value="rejected">Ditolak</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Jenis Surat</option>
                    <option value="1">Surat Keterangan Domisili</option>
                    <option value="2">Surat Keterangan Usaha</option>
                    <option value="3">Surat Pengantar KTP</option>
                </select>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    <i class="fas fa-search mr-2"></i>
                    Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Letters Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Data Pengajuan Surat</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($letterRequests as $request)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $request->citizen->name ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $request->citizen->nik ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $request->letterType->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($request->created_at)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($request->status == 'approved') bg-green-100 text-green-800
                                @elseif($request->status == 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @if($request->status == 'pending') Pending
                                @elseif($request->status == 'approved') Disetujui
                                @elseif($request->status == 'rejected') Ditolak
                                @else {{ ucfirst($request->status) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="max-w-xs truncate">{{ $request->notes ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="#" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="text-yellow-600 hover:text-yellow-900">
                                    <i class="fas fa-print"></i>
                                </a>
                                <a href="#" class="text-purple-600 hover:text-purple-900">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-envelope text-4xl text-gray-300 mb-2"></i>
                                <p>Belum ada pengajuan surat</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Letter Type Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Jenis Surat</h3>
            <div class="space-y-3">
                @php
                    $letterTypeStats = $letterRequests->groupBy('letter_type_id')->map(function($group) {
                        return $group->count();
                    });
                @endphp
                @forelse($letterTypeStats as $typeId => $count)
                    @php
                        $letterType = \App\Models\LetterType::find($typeId);
                    @endphp
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ $letterType->name ?? 'Unknown' }}</span>
                        <span class="text-sm font-medium text-gray-900">{{ $count }} surat</span>
                    </div>
                @empty
                    <div class="text-center text-gray-500">
                        <p>Belum ada data statistik</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pengajuan</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Pending</span>
                    <span class="text-sm font-medium text-yellow-600">{{ $pendingLetters->count() }} surat</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Disetujui</span>
                    <span class="text-sm font-medium text-green-600">{{ $approvedLetters->count() }} surat</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Ditolak</span>
                    <span class="text-sm font-medium text-red-600">{{ $rejectedLetters->count() }} surat</span>
                </div>
            </div>
        </div>
    </div>
@endsection 