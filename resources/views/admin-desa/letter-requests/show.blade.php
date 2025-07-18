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
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Data Masyarakat</h2>
        <table class="table-auto w-full mb-6 border border-gray-200 rounded">
            <tbody>
                <tr><th class="text-left p-2 w-1/3">Nama Pemohon</th><td class="p-2">{{ $request->citizen->name ?? '-' }}</td></tr>
                <tr><th class="text-left p-2">NIK</th><td class="p-2">{{ $request->citizen->nik ?? '-' }}</td></tr>
                <tr><th class="text-left p-2">No KK</th><td class="p-2">{{ $request->citizen->kk_number ?? '-' }}</td></tr>
                <tr><th class="text-left p-2">No Telepon</th><td class="p-2">{{ $request->citizen->phone ?? '-' }}</td></tr>
                <tr><th class="text-left p-2">Alamat</th><td class="p-2">{{ $request->citizen->address ?? '-' }}</td></tr>
            </tbody>
        </table>
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Data Pengisian Dinamis</h2>
        <table class="table-auto w-full mb-6 border border-gray-200 rounded">
            <tbody>
                @forelse($fields as $field)
                    <tr>
                        <th class="text-left p-2 w-1/3">{{ $field->field_label ?? ucwords(str_replace('_', ' ', $field->field_name)) }}</th>
                        <td class="p-2">{{ $dynamicFields[$field->field_name] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="p-2 text-gray-500">Tidak ada data dinamis.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mb-4">
            <strong>Jenis Surat:</strong> {{ $request->letterType->name ?? '-' }}<br>
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