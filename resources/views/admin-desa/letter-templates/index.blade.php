@extends('layouts.app')

@section('title', 'Template Surat')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md p-4 sm:p-6 lg:p-8 w-full">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-xl sm:text-2xl font-bold text-green-700 flex items-center">
            <i class="fas fa-file-alt mr-3"></i> Template Surat
        </h2>
        <a href="{{ route('admin-desa.letter-templates.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-semibold shadow flex items-center">
            <i class="fas fa-plus mr-2"></i> <span class="hidden sm:inline">Buat Template Baru</span><span class="sm:hidden">Buat Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        <div class="min-w-full">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nama Surat</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Waktu Proses (Hari)</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jumlah Field</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($templates as $template)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $template->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $template->processing_days }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $template->fields_count }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <a href="{{ route('admin-desa.letter-templates.edit', $template->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded font-semibold text-xs sm:text-sm">
                                        <i class="fas fa-edit mr-1"></i><span class="hidden sm:inline">Kelola</span>
                                    </a>
                                    <form action="{{ route('admin-desa.letter-templates.destroy', $template->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded font-semibold text-xs sm:text-sm" onclick="return confirm('Yakin ingin menghapus template ini beserta semua field di dalamnya?')">
                                            <i class="fas fa-trash mr-1"></i><span class="hidden sm:inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-8">
                                Anda belum membuat template surat. <a href="{{ route('admin-desa.letter-templates.create') }}" class="text-green-600 hover:underline">Buat sekarang</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 