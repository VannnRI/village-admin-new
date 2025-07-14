@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Perangkat Desa</h1>
    <a href="{{ route('village-officials.create') }}" class="btn btn-primary mb-3">Tambah Perangkat Desa</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jabatan</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($officials as $official)
            <tr>
                <td>{{ $official->position }}</td>
                <td>{{ $official->name }}</td>
                <td>{{ $official->nip }}</td>
                <td>
                    <a href="{{ route('village-officials.edit', $official->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('village-officials.destroy', $official->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection 