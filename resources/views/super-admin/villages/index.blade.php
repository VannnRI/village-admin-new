@extends('layouts.app')

@section('title', 'Kelola Desa')

@section('sidebar')
    <a href="{{ route('super-admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-tachometer-alt mr-3"></i>
        Dashboard
    </a>
    <a href="{{ route('super-admin.villages') }}" class="flex items-center px-4 py-2 text-gray-700 bg-green-100 rounded-lg">
        <i class="fas fa-home mr-3"></i>
        Kelola Desa
    </a>
    <a href="{{ route('super-admin.users') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-users mr-3"></i>
        Kelola User
    </a>
@endsection

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelola Desa</h1>
            <p class="text-gray-600">Daftar semua desa dalam sistem</p>
        </div>
        <a href="{{ route('super-admin.villages.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Tambah Desa</span><span class="sm:hidden">Tambah</span>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden w-full max-w-full md:max-w-4xl">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Desa</h2>
        </div>
        
        @if($villages->count() > 0)
            <div class="overflow-x-auto bg-white px-2" style="border-radius: 0 0 0.5rem 0.5rem; max-width:100%;">
                <table class="min-w-[600px] md:min-w-[900px] divide-y divide-gray-300 text-sm md:text-base">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nama Desa</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Alamat</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden sm:table-cell">Kontak</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 hidden md:table-cell">Dibuat</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($villages as $village)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            <div class="text-sm font-medium text-gray-900">{{ $village->name }}</div>
                                            @if($village->description)
                                                <div class="text-sm text-gray-500">{{ Str::limit($village->description, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 break-words max-w-xs">
                                            <div class="text-sm text-gray-900 break-words">{{ $village->address ?? '-' }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden sm:table-cell">
                                            <div class="text-sm text-gray-900">{{ $village->phone ?? '-' }}</div>
                                            <div class="text-sm text-gray-500">{{ $village->email ?? '-' }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 hidden md:table-cell">
                                            {{ $village->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <div class="flex flex-col sm:flex-row gap-2">
                                                <a href="{{ route('super-admin.villages.edit', $village->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm">
                                                    <i class="fas fa-edit mr-1"></i><span class="hidden sm:inline">Edit</span>
                                                </a>
                                                <form action="{{ route('super-admin.villages.delete', $village->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus desa ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs sm:text-sm">
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
            @else
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-home text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada desa</h3>
                    <p class="text-gray-600 mb-4">Mulai dengan menambahkan desa pertama Anda.</p>
                    <a href="{{ route('super-admin.villages.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Desa Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection 