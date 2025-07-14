@extends('layouts.app')

@section('title', 'Data Penduduk')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Data Penduduk</h1>
            <p class="text-gray-600">Kelola data penduduk desa {{ $village->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin-desa.citizens.template.download') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                <i class="fas fa-download mr-2"></i>Download Template
            </a>
            <button onclick="document.getElementById('importForm').classList.toggle('hidden')" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700">
                <i class="fas fa-upload mr-2"></i>Import Data
            </button>
            <a href="{{ route('admin-desa.citizens.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i>Tambah Penduduk
            </a>
        </div>
    </div>

    <!-- Import Form -->
    <div id="importForm" class="hidden mb-6 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Import Data Penduduk</h3>
        <form action="{{ route('admin-desa.citizens.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex items-center space-x-4">
                <input type="file" name="file" accept=".xlsx,.xls" required 
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    <i class="fas fa-upload mr-2"></i>Upload & Import
                </button>
            </div>
            <div class="mt-2 text-sm text-gray-600">
                <p><strong>Keterangan:</strong></p>
                <p>• Format file: Excel (.xlsx, .xls)</p>
                <p>• Download template terlebih dahulu untuk format yang benar</p>
                <p>• <strong>Field Wajib (Harus Diisi):</strong></p>
                <ul class="list-disc list-inside ml-4">
                    <li>NIK (16 digit)</li>
                    <li>Nama Lengkap</li>
                    <li>No KK (16 digit)</li>
                    <li>Tempat Lahir</li>
                    <li>Tanggal Lahir (format: dd/mm/yyyy)</li>
                    <li>Alamat</li>
                    <li>Jenis Kelamin (L/P)</li>
                    <li>Agama</li>
                    <li>Status Perkawinan</li>
                    <li>Pendidikan</li>
                    <li>Pekerjaan</li>
                    <li>Kewarganegaraan</li>
                </ul>
                <p>• <strong>Field Opsional:</strong> No Telepon, Email</p>
                <p>• Data dengan NIK yang sudah ada akan dilewati</p>
                <p>• Format tanggal: dd/mm/yyyy (contoh: 01/01/1990)</p>
                <p>• Jenis kelamin: L (Laki-laki) atau P (Perempuan)</p>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <div class="bg-white rounded-lg shadow overflow-hidden w-full max-w-full md:max-w-4xl">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Penduduk</h2>
            </div>
            
            @if($citizens->count() > 0)
                <div class="overflow-x-auto bg-white px-2">
                    <table class="min-w-[600px] md:min-w-[900px] divide-y divide-gray-300 text-sm md:text-base">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                        NIK
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Tempat Lahir
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Tanggal Lahir
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden sm:table-cell">
                                        Kewarganegaraan
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:table-cell">
                                        Alamat
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:table-cell">
                                        Kontak
                                    </th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($citizens as $citizen)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            <div class="text-sm font-medium text-gray-900">{{ $citizen->nik }}</div>
                                            <div class="text-sm text-gray-500">KK: {{ $citizen->kk_number }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <div class="text-sm font-medium text-gray-900">{{ $citizen->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $citizen->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $citizen->birth_place ?? '-' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ $citizen->birth_date->format('d/m/Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">
                                            {{ $citizen->nationality ?? '-' }}
                                        </td>
                                        <td class="px-3 py-4 text-sm text-gray-500 hidden md:table-cell">
                                            <div class="max-w-xs truncate" title="{{ $citizen->address }}">
                                                {{ $citizen->address }}
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden md:table-cell">
                                            <div class="text-sm text-gray-900">{{ $citizen->phone ?? '-' }}</div>
                                            <div class="text-sm text-gray-500">{{ $citizen->email ?? '-' }}</div>
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <a href="{{ route('admin-desa.citizens.edit', $citizen->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm">
                                                    <i class="fas fa-edit mr-1"></i><span class="hidden sm:inline">Edit</span>
                                                </a>
                                                <form action="{{ route('admin-desa.citizens.destroy', $citizen->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data penduduk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs sm:text-sm">
                                                        <i class="fas fa-trash mr-1"></i><span class="hidden sm:inline">Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data penduduk</h3>
                    <p class="text-gray-600 mb-4">Mulai dengan menambahkan data penduduk pertama.</p>
                    <a href="{{ route('admin-desa.citizens.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Penduduk Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection 