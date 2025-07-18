@extends('layouts.app')

@section('title', 'Pengajuan Surat')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Pengajuan Surat</h1>
        <p class="text-gray-600">Kelola pengajuan surat dari masyarakat desa {{ $village->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Pengajuan Surat</h2>
            <form method="GET" action="" class="flex gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama/NIK/jenis surat/status..." class="border rounded px-3 py-1 text-sm" />
                <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded text-sm">Cari</button>
            </form>
        </div>
        
        @if($letterRequests->count() > 0)
            <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <div class="min-w-full">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    No. Pengajuan
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Pemohon
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Jenis Surat
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Tanggal Pengajuan
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Status
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($letterRequests as $request)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->request_number }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->applicant_name }}</div>
                                        <div class="text-sm text-gray-500">NIK: {{ $request->applicant_nik }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->letterType->name }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="text-sm text-gray-900">{{ $request->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        @if($request->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($request->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Disetujui
                                            </span>
                                        @elseif($request->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Ditolak
                                            </span>
                                        @elseif($request->status === 'completed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Selesai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <a href="{{ route('admin-desa.letter-requests.show', $request->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm">
                                                <i class="fas fa-eye mr-1"></i><span class="hidden sm:inline">Detail</span>
                                            </a>
                                            @if($request->status === 'approved')
                                                <a href="{{ route('admin-desa.letter-requests.download', $request->id) }}" class="text-blue-600 hover:text-blue-900 text-xs sm:text-sm" title="Download Surat">
                                                    <i class="fas fa-download mr-1"></i><span class="hidden sm:inline">Download</span>
                                                </a>
                                            @endif
                                        </div>
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
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ditemukan pengajuan surat sesuai pencarian.</h3>
                    <p class="text-gray-600 mb-4">Coba kata kunci lain atau periksa kembali ejaan pencarian Anda.</p>
                </div>
            @else
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-envelope text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengajuan surat</h3>
                    <p class="text-gray-600 mb-4">Masyarakat belum mengajukan surat apapun.</p>
                </div>
            @endif
        @endif
    </div>
@endsection 