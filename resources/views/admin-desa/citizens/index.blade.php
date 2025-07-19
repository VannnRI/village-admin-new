@extends('layouts.app')

@section('title', 'Data Penduduk')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 lg:p-8 w-full">
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Data Penduduk</h1>
                <p class="text-gray-600">Kelola data penduduk desa {{ $village->name }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin-desa.citizens.template.download') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 flex items-center">
                    <i class="fas fa-download mr-2"></i>Download Template
                </a>
                <button onclick="document.getElementById('importForm').classList.toggle('hidden')" class="bg-yellow-600 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-700 flex items-center">
                    <i class="fas fa-upload mr-2"></i>Import Data
                </button>
                <a href="{{ route('admin-desa.citizens.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 flex items-center">
                    <i class="fas fa-plus mr-2"></i>Tambah Penduduk
                </a>
            </div>
        </div>
        <!-- Import Form -->
        <div id="importForm" class="hidden mb-6 bg-blue-50 rounded-lg shadow p-6 border border-blue-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Import Data Penduduk</h3>
            <form action="{{ route('admin-desa.citizens.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <input type="file" name="file" accept=".xlsx,.xls" required 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 flex items-center">
                        <i class="fas fa-upload mr-2"></i>Upload & Import
                    </button>
                </div>
            </form>
        </div>
        <div x-data="{ modalHapus: null }">
            <!-- Tabel Data -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-sm rounded-lg shadow divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="divide-x divide-gray-200">
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">NIK</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">No KK</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Alamat</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Jenis Kelamin</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($citizens as $i => $citizen)
                            <tr class="hover:bg-gray-50 divide-x divide-gray-200">
                                <td class="px-4 py-4 whitespace-nowrap">{{ $i+1 }}</td>
                                <td class="px-4 py-4 whitespace-nowrap font-mono">{{ $citizen->nik }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $citizen->name }}</td>
                                <td class="px-4 py-4 whitespace-nowrap font-mono">{{ $citizen->kk_number }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $citizen->address }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $citizen->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap flex gap-2">
                                    <a href="{{ route('admin-desa.citizens.edit', $citizen->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow flex items-center text-xs transition"><i class="fas fa-edit mr-1"></i>Edit</a>
                                    <button type="button" @click="modalHapus = {{ $citizen->id }}" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow flex items-center text-xs transition"><i class="fas fa-trash mr-1"></i>Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Modal Konfirmasi Hapus -->
            <div x-show="modalHapus" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4" @click.away="modalHapus = null">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-3xl mr-3"></i>
                        <h3 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h3>
                    </div>
                    <p class="mb-6 text-gray-700">Apakah Anda yakin ingin menghapus data penduduk ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="flex justify-end gap-2">
                        <button @click="modalHapus = null" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</button>
                        <form :action="'{{ url('/admin-desa/citizens') }}/' + modalHapus" method="POST" @submit.prevent="submitForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold transition">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 