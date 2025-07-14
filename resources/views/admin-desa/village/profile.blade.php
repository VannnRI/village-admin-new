@extends('layouts.app')

@section('title', 'Profil Desa')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Profil Desa</h1>
        <p class="text-gray-600">Kelola informasi dan profil desa {{ $village->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl w-full">
        <h2 class="text-2xl font-bold text-green-700 mb-8 flex items-center">
            <i class="fas fa-home mr-3"></i> Profil Desa
        </h2>
        <form action="{{ route('admin-desa.village.profile.update') }}" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Nama Desa</label>
                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('name', $village->name ?? '') }}" required>
            </div>
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Kecamatan</label>
                <input type="text" name="district" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('district', $village->district ?? '') }}">
            </div>
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Kabupaten</label>
                <input type="text" name="regency" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('regency', $village->regency ?? '') }}">
            </div>
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Alamat Desa</label>
                <input type="text" name="address" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('address', $village->address ?? '') }}" required>
            </div>
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Kode Pos</label>
                <input type="text" name="postal_code" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('postal_code', $village->postal_code ?? '') }}">
            </div>
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Kode Desa</label>
                <input type="text" name="village_code" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="{{ old('village_code', $village->village_code ?? '') }}">
            </div>
            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-semibold shadow">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection 