@extends('layouts.app')

@section('title', 'Edit Desa')

@section('sidebar')
    @php
        $user = Auth::user();
        $currentRoute = request()->route()->getName();
    @endphp
    <div class="flex flex-col items-center justify-center py-6 px-2 bg-gradient-to-br from-blue-200 to-green-50 rounded-xl mb-4 shadow">
        <div class="w-16 h-16 rounded-full bg-white shadow flex items-center justify-center overflow-hidden border-4 border-blue-300 mb-2">
            <i class="fas fa-user-shield text-blue-500 text-3xl"></i>
        </div>
        <div class="text-center">
            <div class="text-base font-bold text-blue-700">{{ $user->name ?? 'Super Admin' }}</div>
            <div class="text-xs text-gray-500">Super Admin</div>
        </div>
    </div>
    <nav class="flex flex-col gap-1">
        <a href="{{ route('super-admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 {{ $currentRoute == 'super-admin.dashboard' ? 'bg-blue-100 font-bold shadow' : 'hover:bg-blue-50' }} rounded-lg transition">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="{{ route('super-admin.villages') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'super-admin.villages') ? 'bg-blue-100 font-bold shadow' : 'hover:bg-blue-50' }} rounded-lg transition">
            <i class="fas fa-home mr-3"></i>
            Kelola Desa
        </a>
        <a href="{{ route('super-admin.users') }}" class="flex items-center px-4 py-2 text-gray-700 {{ str_starts_with($currentRoute, 'super-admin.users') ? 'bg-blue-100 font-bold shadow' : 'hover:bg-blue-50' }} rounded-lg transition">
            <i class="fas fa-users mr-3"></i>
            Kelola User
        </a>
    </nav>
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Desa</h1>
        <p class="text-gray-600">Edit informasi desa {{ $village->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('super-admin.villages.update', $village->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Desa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $village->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                        Kecamatan
                    </label>
                    <input type="text" name="district" id="district" value="{{ old('district', $village->district) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('district')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="regency" class="block text-sm font-medium text-gray-700 mb-2">
                        Kabupaten
                    </label>
                    <input type="text" name="regency" id="regency" value="{{ old('regency', $village->regency) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('regency')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <input type="text" name="address" id="address" value="{{ old('address', $village->address) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $village->phone) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $village->email) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                        Website
                    </label>
                    <input type="url" name="website" id="website" value="{{ old('website', $village->website) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('website')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Desa
                </label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">{{ old('description', $village->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="vision" class="block text-sm font-medium text-gray-700 mb-2">
                        Visi Desa
                    </label>
                    <textarea name="vision" id="vision" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">{{ old('vision', $village->vision) }}</textarea>
                    @error('vision')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mission" class="block text-sm font-medium text-gray-700 mb-2">
                        Misi Desa
                    </label>
                    <textarea name="mission" id="mission" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">{{ old('mission', $village->mission) }}</textarea>
                    @error('mission')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('super-admin.villages') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i>Update Desa
                </button>
            </div>
        </form>
    </div>
@endsection 