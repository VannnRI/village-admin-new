@extends('layouts.app')

@section('title', 'Edit Dokumen Umum')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Dokumen Umum</h1>
        <p class="text-gray-600">Edit dokumen arsip umum untuk desa {{ $village->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin-desa.archives.archives.general.update', $archive->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Judul Dokumen</label>
                <input type="text" name="title" value="{{ old('title', $archive->title) }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Kategori</option>
                    <option value="peraturan" {{ old('category', $archive->category) == 'peraturan' ? 'selected' : '' }}>Peraturan</option>
                    <option value="keuangan" {{ old('category', $archive->category) == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                    <option value="laporan" {{ old('category', $archive->category) == 'laporan' ? 'selected' : '' }}>Laporan</option>
                    <option value="surat" {{ old('category', $archive->category) == 'surat' ? 'selected' : '' }}>Surat</option>
                    <option value="lainnya" {{ old('category', $archive->category) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('category')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3">{{ old('description', $archive->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin-desa.archives.archives.general') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                    <i class="fas fa-save mr-2"></i>Update Dokumen
                </button>
            </div>
        </form>
    </div>
@endsection 