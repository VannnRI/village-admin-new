@extends('layouts.app')

@section('title', 'Profil Saya')

@section('sidebar')
    @include('masyarakat.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Profil Saya</h2>
    
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 lg:gap-6">
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user text-green-600 mr-2"></i>
                Data Pribadi
            </h3>
            <div class="space-y-3">
                <!-- Data Pribadi (Read Only) -->
                <div class="space-y-3 mb-6">
                    <h4 class="font-semibold text-gray-700 mb-3">Data Pribadi (Tidak Dapat Diubah)</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                        <div>
                            <label class="font-medium text-gray-600">Nama:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->name }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">NIK:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->nik }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">No KK:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->kk_number }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">Tempat Lahir:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->birth_place ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">Tanggal Lahir:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->birth_date ? \Carbon\Carbon::parse($citizen->birth_date)->format('d/m/Y') : '-' }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">Jenis Kelamin:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">Agama:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->religion ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">Status Perkawinan:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->marital_status ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">Pendidikan:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->education ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">Pekerjaan:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->job ?? '-' }}</div>
                        </div>
                        <div>
                            <label class="font-medium text-gray-600">Kewarganegaraan:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->nationality ?? '-' }}</div>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="font-medium text-gray-600">Alamat:</label>
                            <div class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 text-gray-700">{{ $citizen->address }}</div>
                        </div>
                    </div>
                </div>

                <!-- Data yang Dapat Diubah -->
                <form action="{{ route('masyarakat.profile.update') }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <h4 class="font-semibold text-gray-700 mb-3">Data yang Dapat Diubah</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                        <div>
                            <label class="font-medium">Email:</label>
                            <input type="email" name="email" class="w-full border rounded px-2 py-1" value="{{ old('email', $citizen->email) }}" placeholder="Masukkan email Anda">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-medium">No Telepon:</label>
                            <input type="text" name="phone" class="w-full border rounded px-2 py-1" value="{{ old('phone', $citizen->phone) }}" placeholder="Masukkan nomor telepon">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan Perubahan</button>
                </form>
            </div>
        </div>
        

        
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-home text-green-600 mr-2"></i>
                Informasi Desa
            </h3>
            <div class="space-y-3">
                <div><span class="font-medium">Nama Desa:</span> {{ $village->name ?? '-' }}</div>
                <div><span class="font-medium">Kecamatan:</span> {{ $village->district ?? '-' }}</div>
                <div><span class="font-medium">Kabupaten:</span> {{ $village->regency ?? '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection 