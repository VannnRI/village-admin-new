@extends('layouts.app')

@section('title', 'Kelola User')

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

        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola User</h1>
                <p class="text-gray-600">Daftar admin desa dan perangkat desa</p>
            </div>
            <a href="{{ route('super-admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Tambah User</span><span class="sm:hidden">Tambah</span>
            </a>
        </div>

        <form method="GET" action="{{ route('super-admin.users') }}" class="mb-4 flex flex-col sm:flex-row gap-2 items-start sm:items-center">
            <div class="relative w-full sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-search text-green-700"></i>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, username, desa, role..." class="pl-10 pr-3 py-2 w-full rounded-lg border-2 border-green-500 focus:border-green-700 focus:ring-2 focus:ring-green-200 shadow-lg transition-all duration-200 bg-white placeholder-gray-600 text-gray-900 font-semibold" />
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow-lg transition-all duration-200 font-bold flex items-center gap-2">
                <i class="fas fa-search"></i> <span class="hidden sm:inline">Cari</span>
            </button>
            @if(request('q'))
                <a href="{{ route('super-admin.users') }}" class="ml-2 text-sm text-green-700 hover:text-green-900 underline transition-all duration-200 font-semibold">Reset</a>
            @endif
        </form>

        <div class="overflow-x-auto">
            <div class="bg-white rounded-lg shadow overflow-hidden w-full max-w-full md:max-w-4xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar User</h2>
                </div>
                
                @if($users->count() > 0)
                    <div class="overflow-x-auto bg-white px-2">
                        <table class="min-w-[600px] md:min-w-[900px] divide-y divide-gray-300 text-sm md:text-base">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">User</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden sm:table-cell">Desa</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:table-cell">Role</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:table-cell">Status</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <i class="fas fa-user text-gray-600"></i>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                                        <div class="text-sm text-gray-500">{{ $user->username }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">
                                                <div class="text-sm text-gray-900">
                                                    @foreach($user->villages as $village)
                                                        {{ $village->name }}
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden md:table-cell">
                                                @foreach($user->roles as $role)
                                                    @if($role->name === 'admin_desa')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            Admin Desa
                                                        </span>
                                                    @elseif($role->name === 'perangkat_desa')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Perangkat Desa
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden md:table-cell">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                <div class="flex flex-col sm:flex-row gap-2">
                                                    <a href="{{ route('super-admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm">
                                                        <i class="fas fa-edit mr-1"></i><span class="hidden sm:inline">Edit</span>
                                                    </a>
                                                    @foreach($user->roles as $role)
                                                        @if($role->name === 'admin_desa' || $role->name === 'perangkat_desa')
                                                            <button onclick="resetPassword({{ $user->id }}, '{{ $user->name }}')" class="text-blue-600 hover:text-blue-900 text-xs sm:text-sm">
                                                                <i class="fas fa-key mr-1"></i><span class="hidden sm:inline">Reset Password</span>
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                    <form action="{{ route('super-admin.users.delete', $user->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 text-xs sm:text-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                            <i class="fas fa-trash mr-1"></i><span class="hidden sm:inline">Hapus</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="px-6 py-8 text-center">
                        <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
                        @if(request('q'))
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada user ditemukan untuk pencarian "{{ request('q') }}"</h3>
                            <a href="{{ route('super-admin.users') }}" class="text-sm text-gray-500 hover:underline">Tampilkan semua user</a>
                        @else
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada user</h3>
                            <p class="text-gray-600 mb-4">Mulai dengan menambahkan admin desa atau perangkat desa.</p>
                            <a href="{{ route('super-admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                <i class="fas fa-plus mr-2"></i>Tambah User Pertama
                            </a>
                        @endif
                    </div>
                @endif
            </div>
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
                        Apakah Anda yakin ingin mereset password untuk user <span id="resetUserName" class="font-semibold"></span>?
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
            document.getElementById('resetPasswordForm').action = `/super-admin/users/${userId}/reset-password`;
            document.getElementById('resetPasswordModal').classList.remove('hidden');
        }

        function closeResetModal() {
            document.getElementById('resetPasswordModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('resetPasswordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeResetModal();
            }
        });
    </script>
@endsection 