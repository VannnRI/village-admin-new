@extends('layouts.app')

@section('title', 'Arsip Umum')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Arsip Umum</h1>
                <p class="text-gray-600">Dokumen-dokumen umum desa {{ $village->name }}</p>
            </div>
            <a href="{{ route('admin-desa.archives.archives') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <div x-data="{ modalHapus: null, showWarning: false }">
        <!-- Upload Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Upload Dokumen Baru</h2>
            <form class="space-y-4" method="POST" action="{{ route('admin-desa.archives.archives.general.store') }}" enctype="multipart/form-data" @submit.prevent="
                showWarning = false;
                let form = $event.target;
                let required = ['title','category','file'];
                let valid = true;
                required.forEach(function(name) {
                    let el = form.querySelector('[name='+name+']');
                    if(!el || !el.value) valid = false;
                });
                if(!valid) { showWarning = true; return false; }
                form.submit();
            ">
                @csrf
                <div x-show="showWarning" class="text-red-600 text-sm font-semibold">Data belum diisi. Mohon lengkapi semua field wajib.</div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul Dokumen</label>
                        <input type="text" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Peraturan Desa 2024">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Kategori</option>
                            <option value="peraturan">Peraturan</option>
                            <option value="keuangan">Keuangan</option>
                            <option value="laporan">Laporan</option>
                            <option value="surat">Surat</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Deskripsi singkat dokumen"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">File Dokumen</label>
                    <input type="file" name="file" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" accept=".pdf,.doc,.docx,.xls,.xlsx">
                    <p class="text-sm text-gray-500 mt-1">Format yang didukung: PDF, DOC, DOCX, XLS, XLSX (Maks. 10MB)</p>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">
                        <i class="fas fa-upload mr-2"></i>
                        Upload Dokumen
                    </button>
                </div>
            </form>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari dokumen..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    <option value="peraturan" {{ request('category')=='peraturan' ? 'selected' : '' }}>Peraturan</option>
                    <option value="keuangan" {{ request('category')=='keuangan' ? 'selected' : '' }}>Keuangan</option>
                    <option value="laporan" {{ request('category')=='laporan' ? 'selected' : '' }}>Laporan</option>
                    <option value="surat" {{ request('category')=='surat' ? 'selected' : '' }}>Surat</option>
                    <option value="lainnya" {{ request('category')=='lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600" type="submit">
                    <i class="fas fa-search mr-2"></i>
                    Cari
                </button>
            </form>
        </div>

        <!-- Documents List -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Dokumen Umum</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Upload</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($generalDocuments as $document)
                        <tr class="hover:bg-gray-50 cursor-pointer">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $document->title }}</div>
                                        <div class="text-sm text-gray-500">{{ $document->file }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $document->category ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $document->date ? \Carbon\Carbon::parse($document->date)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $document->size ? number_format($document->size / 1048576, 2) . ' MB' : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin-desa.archives.archives.download', ['type' => 'general', 'format' => $document->file]) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                <a href="{{ route('admin-desa.archives.archives.general.edit', $document->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" @click.stop="modalHapus = {{ $document->id }}" class="text-red-600 hover:text-red-900" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                @if(request('q') || request('category'))
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-search text-4xl text-gray-300 mb-2"></i>
                                    <p>Tidak ditemukan dokumen sesuai pencarian.</p>
                                </div>
                                @else
                                Belum ada dokumen arsip umum.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal Konfirmasi Hapus -->
        <div x-show="modalHapus" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md animate-fade-in">
                <div class="flex items-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-3xl mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h3>
                </div>
                <p class="mb-6 text-gray-700">Yakin ingin menghapus dokumen ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-end gap-2">
                    <button @click="modalHapus = null" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                    <form :action="'{{ url('/admin-desa/archives/general') }}/' + modalHapus" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 