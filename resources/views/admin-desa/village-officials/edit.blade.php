@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Perangkat Desa</h1>
    <form action="{{ route('village-officials.update', $official->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="position" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="position" name="position" value="{{ $official->position }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $official->name }}" required>
        </div>
        <div class="mb-3">
            <label for="nip" class="form-label">NIP</label>
            <input type="text" class="form-control" id="nip" name="nip" value="{{ $official->nip }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('village-officials.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection 