@extends('layouts.app')

@section('title', 'Tambah User')

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
        <h1 class="text-3xl font-bold text-gray-900">Tambah User</h1>
        <p class="text-gray-600">Buat akun admin desa atau perangkat desa</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('super-admin.users.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="village_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Desa <span class="text-red-500">*</span>
                    </label>
                    <select name="village_id" id="village_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="">Pilih Desa</option>
                        @foreach($villages as $village)
                            <option value="{{ $village->id }}" {{ old('village_id') == $village->id ? 'selected' : '' }}>
                                {{ $village->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('village_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role_id" id="role_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <button type="button" onclick="togglePassword('password')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 z-20">
                            <i id="password-icon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                        <button type="button" onclick="togglePassword('password_confirmation')" 
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 z-20">
                            <i id="password_confirmation-icon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('super-admin.users') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-save mr-2"></i>Simpan User
                </button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection 