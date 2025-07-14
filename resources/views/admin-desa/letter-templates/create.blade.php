@extends('layouts.app')

@section('title', 'Buat Template Surat Baru')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
<div class="container mx-auto max-w-2xl bg-white rounded-lg shadow-md p-8">
    <form action="{{ route('admin-desa.letter-templates.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Nama Template Surat</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" required value="{{ old('name') }}">
        </div>
        <div class="mb-4">
            <label for="processing_days" class="block font-semibold mb-1">Waktu Proses (Hari)</label>
            <input type="number" name="processing_days" id="processing_days" class="w-full border rounded px-3 py-2" required value="{{ old('processing_days') }}">
        </div>
        <div class="mb-4">
            <label for="is_active" class="block font-semibold mb-1">Status Aktif</label>
            <select name="is_active" id="is_active" class="w-full border rounded px-3 py-2">
                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-2">Field Dinamis (Isian Pengajuan Surat)</label>
            <div id="fields-list"></div>
            <button type="button" onclick="addField()" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded">+ Tambah Field</button>
            <input type="hidden" name="fields_json" id="fields_json">
        </div>
        <script>
        let fields = [];
        function renderFields() {
            let html = '';
            fields.forEach((f, i) => {
                html += `<div class='border rounded p-3 mb-2 bg-gray-50'>
                    <b>Field "+(i+1)+":</b> 
                    <input type='text' placeholder='Nama Field' value='${f.name}' onchange='fields[${i}].name=this.value;renderFields()' class='border px-2 py-1 rounded mr-2' style='width:120px;'>
                    <input type='text' placeholder='Label' value='${f.label}' onchange='fields[${i}].label=this.value;renderFields()' class='border px-2 py-1 rounded mr-2' style='width:160px;'>
                    <select onchange='fields[${i}].type=this.value;renderFields()' class='border px-2 py-1 rounded mr-2'>
                        <option value='text' ${f.type==='text'?'selected':''}>Text</option>
                        <option value='textarea' ${f.type==='textarea'?'selected':''}>Textarea</option>
                        <option value='select' ${f.type==='select'?'selected':''}>Select</option>
                        <option value='radio' ${f.type==='radio'?'selected':''}>Radio</option>
                        <option value='checkbox' ${f.type==='checkbox'?'selected':''}>Checkbox</option>
                    </select>
                    <label class='ml-2'><input type='checkbox' ${f.required?'checked':''} onchange='fields[${i}].required=this.checked;renderFields()'> Wajib</label>
                    <button type='button' onclick='fields.splice(${i},1);renderFields()' class='ml-2 text-red-600'>Hapus</button><br>`;
                if(['select','radio','checkbox'].includes(f.type)) {
                    html += `<input type='text' placeholder='Opsi (pisahkan dengan koma)' value='${f.options||''}' onchange='fields[${i}].options=this.value;renderFields()' class='border px-2 py-1 rounded mt-2' style='width:300px;'>`;
                }
                html += `</div>`;
            });
            document.getElementById('fields-list').innerHTML = html;
            document.getElementById('fields_json').value = JSON.stringify(fields);
        }
        function addField() {
            fields.push({name:'',label:'',type:'text',required:false,options:''});
            renderFields();
        }
        window.onload = renderFields;
        </script>
        <div class="mb-4">
            <label for="template_html" class="block font-semibold mb-1">Isi Template Surat</label>
            <textarea name="template_html" id="template_html" class="w-full border rounded px-3 py-2" rows="10">{{ old('template_html') }}</textarea>
        </div>
        <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
        <style>
            .cke_notification_update, .cke_notification_warning, .cke_notification_info {
                display: none !important;
            }
        </style>
        <script>
            CKEDITOR.replace('template_html', {
                updateNotification: false
            });
        </script>
        <div class="mb-6 mt-8 p-4 bg-gray-50 border rounded">
            <b>Daftar Variabel yang Bisa Digunakan di Template Surat:</b>
            <ul class="list-disc ml-6 mt-2 text-sm">
                <li><b>Field Otomatis dari Database (Profil Penduduk):</b>
                    <ul class="list-disc ml-6 mt-1">
                        <li>Nama: <code>@{{ name }}</code></li>
                        <li>NIK: <code>@{{ nik }}</code></li>
                        <li>No KK: <code>@{{ kk_number }}</code></li>
                        <li>Tempat Lahir: <code>@{{ birth_place }}</code></li>
                        <li>Tanggal Lahir: <code>@{{ birth_date }}</code></li>
                        <li>Alamat: <code>@{{ address }}</code></li>
                        <li>Telepon: <code>@{{ phone }}</code></li>
                        <li>Email: <code>@{{ email }}</code></li>
                        <li>Jenis Kelamin: <code>@{{ gender }}</code></li>
                        <li>Agama: <code>@{{ religion }}</code></li>
                        <li>Status Perkawinan: <code>@{{ marital_status }}</code></li>
                        <li>Pendidikan: <code>@{{ education }}</code></li>
                        <li>Pekerjaan: <code>@{{ job }}</code></li>
                        <li>Kewarganegaraan: <code>@{{ nationality }}</code></li>
                    </ul>
                    <div class="text-xs text-blue-600 mt-1">Field di atas bisa langsung dipanggil di template surat tanpa perlu menambah field baru.</div>
                </li>
                <li class="mt-2"><b>Data Desa:</b> <code>@{{ nama_desa }}</code>, <code>@{{ alamat_desa }}</code>, <code>@{{ telepon_desa }}</code>, <code>@{{ email_desa }}</code>, <code>@{{ kode_desa }}</code>, <code>@{{ kode_pos }}</code>, <code>@{{ kecamatan }}</code>, <code>@{{ kabupaten }}</code></li>
                <li><b>Data Surat:</b> <code>@{{ jenis_surat }}</code>, <code>@{{ tanggal_surat }}</code>, <code>@{{ bulan }}</code>, <code>@{{ bulan_romawi }}</code>, <code>@{{ tahun }}</code>, <code>@{{ nomor_urut }}</code>, <code>@{{ purpose }}</code></li>
                <li><b>Field Dinamis:</b> Gunakan <code>@{{ nama_field }}</code> sesuai field yang Anda tambahkan di atas (misal: <code>@{{ keterangan }}</code>, <code>@{{ tujuan }}</code>, <code>@{{ nama_alm }}</code>, dll).</li>
                <li class="mt-2"><b>Data Perangkat Desa (otomatis dari data perangkat desa):</b>
                    <ul class="list-disc ml-6 mt-1">
                        <li>Sesuai jabatan yang diinput, misal: <code>@{{ sekertaris_nama }}</code>, <code>@{{ sekertaris_nip }}</code>, <code>@{{ bendahara_nama }}</code>, dst.</li>
                        <li>Format: <code>@{{ nama_jabatan_nama }}</code> dan <code>@{{ nama_jabatan_nip }}</code> (spasi/titik diganti underscore, huruf kecil semua).</li>
                        <li>Contoh: Jabatan "Kaur Umum" &rarr; <code>@{{ kaur_umum_nama }}</code>, <code>@{{ kaur_umum_nip }}</code></li>
                    </ul>
                </li>
            </ul>
            <div class="mt-4 text-sm text-gray-700">
                <b>Cara Penggunaan:</b>
                <ol class="list-decimal ml-6 mt-1">
                    <li>Tulis nama variabel di dalam kurung kurawal ganda, contoh: <code>@{{ name }}</code>, <code>@{{ nik }}</code>.</li>
                    <li>Untuk field dinamis, gunakan nama field yang Anda buat di pengaturan field dinamis.</li>
                    <li>Variabel akan otomatis digantikan dengan data sesuai permohonan saat surat dicetak/digenerate.</li>
                </ol>
                <div class="mt-2">Anda bisa mengombinasikan variabel di atas sesuai kebutuhan format surat. Jika ingin menambah field khusus, tambahkan melalui pengaturan field dinamis pada jenis surat terkait.</div>
            </div>
        </div>
        <div class="flex justify-end mb-4">
            <button type="button" class="bg-blue-300 text-white px-4 py-2 rounded mr-2 cursor-not-allowed" disabled>Preview (tersedia setelah disimpan)</button>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('admin-desa.letter-templates.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded mr-2">Batal</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection 