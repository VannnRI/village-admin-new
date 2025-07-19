@extends('layouts.app')

@section('title', 'Profil Saya')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
<div class="container mx-auto max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
        <p class="text-gray-600">Kelola informasi akun Anda</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Profil -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Profil</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->username }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <p class="mt-1 text-sm text-gray-900">
                        @foreach(Auth::user()->roles as $role)
                            @if($role->name === 'admin_desa')
                                Admin Desa
                            @elseif($role->name === 'perangkat_desa')
                                Perangkat Desa
                            @else
                                {{ $role->name }}
                            @endif
                        @endforeach
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Desa</label>
                    <p class="mt-1 text-sm text-gray-900">
                        @foreach(Auth::user()->villages as $village)
                            {{ $village->name }}
                        @endforeach
                    </p>
                </div>
            </div>
        </div>

        <!-- Ubah Username -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubah Username</h2>
            <form action="{{ route('admin-desa.profile.update-username') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="new_username" class="block text-sm font-medium text-gray-700">Username Baru</label>
                        <input type="text" name="new_username" id="new_username" value="{{ old('new_username') }}" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                        @error('new_username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password" required
                                   class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <button type="button" onclick="togglePassword('current_password')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 z-20">
                                <i id="current_password-icon" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        Ubah Username
                    </button>
                </div>
            </form>
        </div>

        <!-- Ubah Password -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubah Password</h2>
            <form action="{{ route('admin-desa.profile.update-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="current_password_pw" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="current_password_pw" id="current_password_pw" required
                                   class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <button type="button" onclick="togglePassword('current_password_pw')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 z-20">
                                <i id="current_password_pw-icon" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('current_password_pw')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password" required
                                   class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <button type="button" onclick="togglePassword('new_password')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 z-20">
                                <i id="new_password-icon" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                   class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                            <button type="button" onclick="togglePassword('new_password_confirmation')" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 z-20">
                                <i id="new_password_confirmation-icon" class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
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