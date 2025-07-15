@extends('layouts.app')

@section('title', 'Status Permohonan Surat')

@section('sidebar')
    @include('masyarakat.partials.sidebar')
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-md w-full max-w-full overflow-hidden">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800">Status Permohonan Surat</h2>
    </div>

    <!-- Scrollable Table Wrapper -->
    <div class="overflow-x-auto w-full px-2">
        <table class="w-full min-w-[800px] text-sm">
            <thead class="bg-gray-50">
                <tr class="divide-x divide-gray-200">
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">No</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">No Permohonan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Jenis Surat</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Tujuan</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($requests as $i => $request)
                    <tr class="divide-x divide-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap">{{ $i+1 }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">{{ $request->request_number }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">{{ $request->letter_name }}</td>
                        <td class="px-4 py-4 whitespace-normal break-words max-w-xs">{{ $request->purpose }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">{{ $request->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($request->status == 'approved')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                            @elseif($request->status == 'rejected')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                @if($request->notes)
                                <div class="mt-2 bg-red-50 border border-red-200 rounded p-2 text-xs text-red-700 shadow-sm whitespace-normal break-words max-w-xs">
                                    <strong>Alasan:</strong> {{ $request->notes }}
                                </div>
                                @endif
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Diproses</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($request->status == 'approved')
                                <a href="{{ route('masyarakat.letters.download', $request->id) }}" class="text-green-600 hover:text-green-900 font-semibold">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                            @elseif($request->status == 'rejected')
                                <a href="{{ route('masyarakat.letter-form', ['resubmit_id' => $request->id]) }}" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded hover:bg-blue-200 transition">
                                    <i class="fas fa-redo mr-1"></i>Ajukan Ulang
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada permohonan surat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
