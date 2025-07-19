@extends('layouts.app')

@section('title', 'Profil Desa')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Profil Desa</h1>
        <p class="text-gray-600">Kelola informasi dan profil desa <span class="font-semibold text-green-700">{{ $village->name }}</span></p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-6 max-w-4xl w-full mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row items-center mb-8 p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
            <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-white shadow-lg flex items-center justify-center border-4 border-green-300 mb-4 md:mb-0 md:mr-6">
                <i class="fas fa-home text-green-600 text-4xl md:text-6xl"></i>
            </div>
            <div class="text-center md:text-left">
                <h2 class="text-2xl md:text-3xl font-bold text-green-800 mb-2">{{ $village->name }}</h2>
                <div class="text-sm text-green-600 bg-green-200 px-3 py-1 rounded-full font-medium inline-block mb-2">
                    Kode Desa: {{ $village->village_code ?? '-' }}
                </div>
                <div class="text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    {{ $village->district ?? '-' }}, {{ $village->regency ?? '-' }}
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="space-y-6">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Informasi Desa</h3>
                <p class="text-sm text-gray-600">Kelola informasi lengkap desa {{ $village->name }}</p>
            </div>
            
            <form action="{{ route('admin-desa.village.profile.update') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Nama Desa</label>
                        <input type="text" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('name', $village->name ?? '') }}" required>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Kecamatan</label>
                        <input type="text" name="district" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('district', $village->district ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Kabupaten</label>
                        <input type="text" name="regency" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('regency', $village->regency ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Alamat Desa</label>
                        <input type="text" name="address" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('address', $village->address ?? '') }}" required>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Kode Pos</label>
                        <input type="text" name="postal_code" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('postal_code', $village->postal_code ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Kode Desa</label>
                        <input type="text" name="village_code" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('village_code', $village->village_code ?? '') }}">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Email Desa</label>
                        <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('email', $village->email ?? '') }}" placeholder="contoh@desa.id">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                        <input type="tel" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('phone', $village->phone ?? '') }}" placeholder="0322-123456">
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Website Desa</label>
                        <input type="url" name="website" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" value="{{ old('website', $village->website ?? '') }}" placeholder="https://desa.id">
                    </div>
                </div>
                
                <div class="mt-8">
                    <label class="block font-semibold text-gray-700 mb-2">Deskripsi Desa</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" placeholder="Deskripsi singkat tentang desa...">{{ old('description', $village->description ?? '') }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Visi Desa</label>
                        <textarea name="vision" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" placeholder="Visi desa...">{{ old('vision', $village->vision ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">Misi Desa</label>
                        <textarea name="mission" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 transition" placeholder="Misi desa...">{{ old('mission', $village->mission ?? '') }}</textarea>
                    </div>
                </div>
                
                <div class="mt-10 flex justify-end">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold shadow-lg transition flex items-center gap-2 transform hover:scale-105">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 