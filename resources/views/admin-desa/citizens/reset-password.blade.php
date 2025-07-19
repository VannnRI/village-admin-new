@extends('layouts.app')

@section('title', 'Reset Password Masyarakat')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
<div class="container mx-auto max-w-4xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Reset Password Masyarakat</h1>
        <p class="text-gray-600">Kelola password masyarakat. Akun akan dibuat otomatis saat login dengan NIK + Tanggal Lahir</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Daftar Masyarakat</h2>
        
        <form method="GET" action="{{ route('admin-desa.citizens.reset-password') }}" class="mb-4">
            <div class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, NIK, atau username..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>

        @if($citizens->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($citizens as $citizen)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $citizen->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $citizen->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $citizen->nik }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($citizen->user)
                                        {{ $citizen->user->username }}
                                    @else
                                        <span class="text-red-500">Belum ada akun</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($citizen->user)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Belum Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($citizen->user)
                                        <button onclick="resetPassword({{ $citizen->user->id }}, '{{ $citizen->name }}')" 
                                                class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-key mr-1"></i>Reset Password
                                        </button>
                                    @else
                                        <span class="text-gray-400">Akun akan dibuat otomatis saat login</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada masyarakat ditemukan</h3>
                <p class="text-gray-600">Tidak ada data masyarakat yang sesuai dengan pencarian.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Reset Password -->
<div id="resetPasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-key text-blue-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Reset Password</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin mereset password untuk <span id="resetUserName" class="font-semibold"></span>?
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    Password akan direset menjadi: <span class="font-mono bg-gray-100 px-2 py-1 rounded">password123</span>
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="resetPasswordForm" method="POST" class="inline">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 mr-2">
                        Reset Password
                    </button>
                    <button type="button" onclick="closeResetModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function resetPassword(userId, userName) {
        document.getElementById('resetUserName').textContent = userName;
        document.getElementById('resetPasswordForm').action = `/admin-desa/citizens/${userId}/reset-password`;
        document.getElementById('resetPasswordModal').classList.remove('hidden');
    }

    function closeResetModal() {
        document.getElementById('resetPasswordModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.getElementById('resetPasswordModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeResetModal();
        }
    });
</script>
@endsection 