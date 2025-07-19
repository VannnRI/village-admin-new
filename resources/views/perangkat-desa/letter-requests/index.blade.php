@extends('layouts.app')

@section('title', 'Permohonan Surat')

@section('sidebar')
    @include('perangkat-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Permohonan Surat</h1>
            <p class="text-gray-600">Daftar permohonan surat dari masyarakat desa {{ $village->name }}</p>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Permohonan</h2>
            <form method="GET" action="" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/NIK/jenis surat/status..." class="border rounded px-3 py-1 text-sm" />
                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Cari</button>
            </form>
        </div>
        @if($requests->count() > 0)
            <div class="overflow-x-auto shadow md:rounded-lg">
                <div class="min-w-full">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">No</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nama Pemohon</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jenis Surat</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($requests as $i => $req)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $i+1 }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $req->citizen->name ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $req->letterType->name ?? '-' }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($req->status == 'pending')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($req->status == 'approved')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                        @elseif($req->status == 'rejected')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($req->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="{{ route('perangkat-desa.letter-requests.show', $req->id) }}" class="text-blue-600 hover:text-blue-900 text-xs sm:text-sm">
                                            <i class="fas fa-eye mr-1"></i><span class="hidden sm:inline">Detail</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            @if(request('q') && $totalLetterRequests > 0)
            <div class="px-6 py-8 text-center">
                <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ditemukan permohonan surat sesuai pencarian.</h3>
                <p class="text-gray-600 mb-4">Coba kata kunci lain atau periksa kembali ejaan pencarian Anda.</p>
            </div>
            @else
            <div class="px-6 py-8 text-center">
                <i class="fas fa-envelope text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada permohonan surat</h3>
            </div>
            @endif
        @endif
    </div>
    <div x-data="{ modalHapus: null }">
        <!-- Modal Konfirmasi Hapus -->
        <template x-if="modalHapus">
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md animate-fade-in">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-3xl mr-3"></i>
                        <h3 class="text-lg font-bold text-gray-800">Konfirmasi Hapus</h3>
                    </div>
                    <p class="mb-6 text-gray-700">Apakah Anda yakin ingin menghapus permohonan surat ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="flex justify-end gap-2">
                        <button @click="modalHapus = null" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Batal</button>
                        <form :action="'{{ url('/perangkat-desa/letter-requests') }}/' + modalHapus" method="POST" @submit="modalHapus = null">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-semibold">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection 