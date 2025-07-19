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

    <div x-data="{ modalHapus: null }">
        <div class="overflow-x-auto shadow md:rounded-lg">
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
                                        <button @click="modalHapus = {{ $template->id }}" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded font-semibold text-xs sm:text-sm">
                                            <i class="fas fa-trash mr-1"></i><span class="hidden sm:inline">Hapus</span>
                                        </button>
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

        <!-- Modal Konfirmasi Hapus -->
        <div x-show="modalHapus" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4" @click.away="modalHapus = null">
                <div class="flex items-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h3>
                </div>
                <p class="mb-6 text-gray-700">Apakah Anda yakin ingin menghapus template surat ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-end gap-2">
                    <button @click="modalHapus = null" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Batal</button>
                    <form :action="'{{ url('/admin-desa/letter-templates') }}/' + modalHapus" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold transition">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 