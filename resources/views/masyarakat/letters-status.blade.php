@extends('layouts.app')

@section('title', 'Status Permohonan Surat')

@section('sidebar')
    @include('masyarakat.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Status Permohonan Surat</h2>
    
    <div class="overflow-x-auto shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
        <div class="min-w-full">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">No</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">No Permohonan</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Jenis Surat</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tujuan</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($requests as $i => $request)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $i+1 }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $request->request_number }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $request->letter_name }}</td>
                            <td class="px-3 py-4 text-sm text-gray-500">
                                <div class="max-w-xs truncate" title="{{ $request->purpose }}">
                                    {{ $request->purpose }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $request->created_at->format('d/m/Y') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @if($request->status == 'approved')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                @elseif($request->status == 'rejected')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Diproses</span>
                                @endif
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                @if($request->status == 'approved')
                                    <a href="{{ route('masyarakat.letters.download', $request->id) }}" class="text-green-600 hover:text-green-900 flex items-center justify-center sm:justify-start">
                                        <i class="fas fa-download mr-1"></i>
                                        <span class="hidden sm:inline">Download Surat</span>
                                        <span class="sm:hidden">Download</span>
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada permohonan surat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 