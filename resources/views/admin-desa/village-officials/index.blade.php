@extends('layouts.app')

@section('title', 'Struktur Pemerintahan Desa')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
<div class="container" x-data="{ modalHapus: null }">
    <div class="container mx-auto max-w-4xl bg-white rounded-xl shadow-lg p-10 mt-8">
        <h2 class="text-3xl font-extrabold mb-8 text-center">Struktur Pemerintahan Desa</h2>
        <h3 class="text-xl font-bold mb-6">Daftar Seluruh Perangkat Desa</h3>
        <div class="overflow-x-auto rounded-lg shadow mb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jabatan</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">NIP</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($village->officials as $official)
                    <tr>
                        <form action="{{ route('admin-desa.village-officials.update', $official->id) }}" method="POST" class="contents">
                            @csrf
                            @method('PUT')
                            <td class="px-6 py-2"><input type="text" name="position" value="{{ $official->position }}" class="w-full border rounded px-3 py-2" required></td>
                            <td class="px-6 py-2"><input type="text" name="name" value="{{ $official->name }}" class="w-full border rounded px-3 py-2" required></td>
                            <td class="px-6 py-2"><input type="text" name="nip" value="{{ $official->nip }}" class="w-full border rounded px-3 py-2"></td>
                            <td class="px-6 py-2 flex flex-wrap gap-2 justify-center">
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">Update</button>
                        </form>
                        <button type="button" @click="modalHapus = {{ $official->id }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">Hapus</button>
                            </td>
                    </tr>
                    @endforeach
                    <tr>
                        <form action="{{ route('admin-desa.village-officials.store') }}" method="POST" class="contents">
                            @csrf
                            <td class="px-6 py-2"><input type="text" name="position" placeholder="Jabatan" class="w-full border rounded px-3 py-2" required></td>
                            <td class="px-6 py-2"><input type="text" name="name" placeholder="Nama" class="w-full border rounded px-3 py-2" required></td>
                            <td class="px-6 py-2"><input type="text" name="nip" placeholder="NIP" class="w-full border rounded px-3 py-2"></td>
                            <td class="px-6 py-2 text-center"><button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">Tambah</button></td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-base text-gray-700 mt-6 bg-gray-50 border border-gray-200 rounded-lg p-5">
            <b>Tips:</b> Untuk menampilkan nama kepala desa di surat, pastikan ada baris dengan jabatan <b>Kepala Desa</b>.<br>
            Variabel di template surat: <code>@{{ kepala_desa_nama }}</code> dan <code>@{{ kepala_desa_nip }}</code>.<br>
            Untuk perangkat lain, gunakan format variabel sesuai jabatan (spasi/titik diganti underscore, huruf kecil semua).
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div x-show="modalHapus" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4" @click.away="modalHapus = null">
            <div class="flex items-center mb-4">
                <i class="fas fa-exclamation-triangle text-red-500 text-3xl mr-3"></i>
                <h3 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h3>
            </div>
            <p class="mb-6 text-gray-700">Yakin ingin menghapus perangkat desa ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex justify-end gap-2">
                <button @click="modalHapus = null" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</button>
                <form :action="'{{ url('/admin-desa/village-officials') }}/' + modalHapus" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold transition">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 