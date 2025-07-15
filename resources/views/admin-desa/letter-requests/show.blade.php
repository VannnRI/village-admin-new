@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Detail Pengajuan Surat</h1>
        <p class="text-gray-600">Detail pengajuan surat dari masyarakat desa {{ $village->name }}</p>
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
        @if($request->status == 'approved')
        <div class="flex gap-4 mt-6">
            <a href="{{ route('admin-desa.letter-requests.download', $request->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                <i class="fas fa-download mr-2"></i>Download Surat
            </a>
        </div>
        @endif
        <div class="mt-8">
            <a href="{{ route('admin-desa.letter-requests.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Kembali ke Daftar Pengajuan
            </a>
        </div>
    </div>
@endsection 