@extends('layouts.app')
@section('title', 'Preview Template Surat')
@section('content')
<div class="container mx-auto max-w-3xl bg-white rounded-lg shadow-md p-8 my-8">
    <h2 class="text-xl font-bold mb-4">Preview Template Surat</h2>
    <div class="border p-4 rounded bg-gray-50">
        {!! $html !!}
    </div>
    <a href="javascript:window.close()" class="mt-6 inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Tutup</a>
</div>
@endsection 