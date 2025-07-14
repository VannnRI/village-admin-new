@extends('layouts.app')

@section('title', 'Struktur Pemerintahan Desa')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
<div class="container mx-auto max-w-4xl bg-white rounded-xl shadow-lg p-10 mt-8">
    <h2 class="text-3xl font-extrabold mb-8 text-center">Struktur Pemerintahan Desa</h2>
    <h3 class="text-xl font-bold mb-6">Daftar Seluruh Perangkat Desa</h3>
    <div class="overflow-x-auto rounded-lg shadow border border-gray-200 mb-6">
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
                    <form action="{{ route('admin-desa.village-officials.destroy', $official->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus perangkat ini?')" class="contents">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">Hapus</button>
                    </form>
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
@endsection 