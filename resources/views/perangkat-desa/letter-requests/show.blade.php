@extends('layouts.app')

@section('title', 'Detail Permohonan Surat')

@section('sidebar')
    <a href="{{ route('perangkat-desa.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
        <i class="fas fa-tachometer-alt mr-3"></i>
        Dashboard
    </a>
    <a href="{{ route('perangkat-desa.letter-requests') }}" class="flex items-center px-4 py-2 text-gray-700 bg-green-100 rounded-lg">
        <i class="fas fa-envelope mr-3"></i>
        Permohonan Surat
    </a>
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Detail Permohonan Surat</h1>
        <p class="text-gray-600">Detail permohonan surat dari masyarakat desa {{ $village->name }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <strong>Nama Pemohon:</strong> {{ $request->citizen->name ?? '-' }}<br>
            <strong>NIK:</strong> {{ $request->citizen->nik ?? '-' }}<br>
            <strong>No KK:</strong> {{ $request->citizen->kk_number ?? '-' }}<br>
            <strong>Jenis Surat:</strong> {{ $request->letterType->name ?? '-' }}<br>
            <strong>Tujuan Permohonan:</strong> {{ $request->purpose ?? '-' }}<br>
            <strong>No Telepon:</strong> {{ $request->citizen->phone ?? '-' }}<br>
            <strong>Alamat:</strong> {{ $request->citizen->address ?? '-' }}<br>
            @php
                $extraData = $request->data ? json_decode($request->data, true) : [];
                $keperluanText = isset($extraData['keperluan']) ? $extraData['keperluan'] : null;
                if(isset($extraData['keperluan'])) unset($extraData['keperluan']);
            @endphp
            @if($keperluanText)
            <strong>Keperluan:</strong> {{ $keperluanText }}<br>
            @endif
            <strong>Status:</strong>
            @if($request->status == 'pending')
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
            @elseif($request->status == 'approved')
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
            @elseif($request->status == 'rejected')
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
            @else
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ ucfirst($request->status) }}</span>
            @endif
        </div>
        @if($request->status == 'pending')
        <div class="flex gap-4 mt-6">
            <form action="{{ route('perangkat-desa.letter-requests.approve', $request->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-check mr-2"></i>Setujui
                </button>
            </form>
            <!-- Tombol Tolak dengan Modal -->
            <button type="button" onclick="document.getElementById('modal-reject').classList.remove('hidden')" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                <i class="fas fa-times mr-2"></i>Tolak
            </button>
        </div>
        <!-- Modal Popup Tolak -->
        <div id="modal-reject" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative animate-fade-in">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Alasan Penolakan Surat</h2>
                <form action="{{ route('perangkat-desa.letter-requests.reject', $request->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <textarea name="notes" rows="4" required class="w-full border border-red-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-200 focus:border-red-500 placeholder-gray-400" placeholder="Tuliskan alasan penolakan secara jelas..."></textarea>
                    <div class="flex justify-end gap-2 mt-2">
                        <button type="button" onclick="document.getElementById('modal-reject').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold">Kirim Penolakan</button>
                    </div>
                </form>
                <button type="button" onclick="document.getElementById('modal-reject').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-xl">&times;</button>
            </div>
        </div>
        <style>
        @keyframes fade-in { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: none; } }
        .animate-fade-in { animation: fade-in 0.2s ease; }
        </style>
        @endif
        @if($request->status == 'approved')
        <div class="flex gap-4 mt-6">
            <a href="{{ route('perangkat-desa.letter-requests.download', $request->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-download mr-2"></i>Download Surat
            </a>
        </div>
        @endif
        <div class="mt-8">
            <a href="{{ route('perangkat-desa.letter-requests') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Kembali ke Daftar Permohonan
            </a>
        </div>
    </div>
@endsection 