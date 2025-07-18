@extends('layouts.app')

@section('title', 'Edit Template Surat')

@section('sidebar')
    @include('admin-desa.partials.sidebar')
@endsection

@section('content')
<div class="container mx-auto max-w-2xl bg-white rounded-lg shadow-md p-8">
    <form action="{{ route('admin-desa.letter-templates.update', $template->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Nama Template Surat</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" required value="{{ old('name', $template->name) }}">
        </div>
        <div class="mb-4">
            <label for="processing_days" class="block font-semibold mb-1">Waktu Proses (Hari)</label>
            <input type="number" name="processing_days" id="processing_days" class="w-full border rounded px-3 py-2" required value="{{ old('processing_days', $template->processing_days) }}">
        </div>
        <div class="mb-4">
            <label for="is_active" class="block font-semibold mb-1">Status Aktif</label>
            <select name="is_active" id="is_active" class="w-full border rounded px-3 py-2">
                <option value="1" {{ old('is_active', $template->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $template->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="template_html" class="block font-semibold mb-1">Isi Template Surat</label>
            <textarea name="template_html" id="template_html" class="w-full border rounded px-3 py-2" rows="10">{{ old('template_html', $template->template_html) }}</textarea>
        </div>
        <div class="mb-4 p-3 bg-yellow-50 border-l-4 border-yellow-400 text-sm text-gray-800 rounded">
            <b>Panduan Penambahan Field Dinamis:</b>
            <ul class="list-disc ml-5 mt-1">
                <li>Field dinamis adalah isian yang akan muncul di form pengajuan surat masyarakat.</li>
                <li><b>Nama Field</b>: Harus unik, tanpa spasi, gunakan huruf kecil/underscore (misal: <code>tujuan</code>, <code>nama_alm</code>).</li>
                <li><b>Label</b>: Teks yang tampil di form (boleh spasi, misal: <code>Nama Almarhum</code>).</li>
                <li><b>Tipe Field</b>: Pilih sesuai kebutuhan (text, number, date, textarea, select, radio, checkbox).</li>
                <li><b>Opsi Pilihan</b> (untuk select/radio/checkbox): Masukkan beberapa opsi, pisahkan dengan koma. Contoh: <code>Laki-Laki, Perempuan</code></li>
                <li><b>Wajib</b>: Centang jika field harus diisi masyarakat.</li>
                <li>Gunakan tombol <b>+ Tambah Field</b> untuk menambah isian baru.</li>
                <li>Contoh hasil: Jika Anda menambah field <code>tujuan</code> label "Tujuan Permohonan", maka masyarakat akan mengisi "Tujuan Permohonan" di form.</li>
            </ul>
        </div>
        <div class="mb-6">
            <label class="block font-semibold mb-2">Field Dinamis (Isian Pengajuan Surat)</label>
            <div id="fields-list"></div>
            <button type="button" onclick="addField()" class="mt-2 bg-blue-500 text-white px-3 py-1 rounded">+ Tambah Field</button>
            <input type="hidden" name="fields_json" id="fields_json">
        </div>
        <script>
        let fields = [];
        // Preload field lama dari backend
        @if(isset($fieldsForJs))
            fields = @json($fieldsForJs);
        @endif
        function renderFields() {
            let html = '';
            fields.forEach((f, i) => {
                html += `<div class='border rounded p-3 mb-2 bg-gray-50'>
                    <b>Field ${i+1}:</b> 
                    <input type='text' placeholder='Nama Field' value='${f.name}' onchange='fields[${i}].name=this.value;renderFields()' class='border px-2 py-1 rounded mr-2' style='width:120px;'>
                    <input type='text' placeholder='Label' value='${f.label}' onchange='fields[${i}].label=this.value;renderFields()' class='border px-2 py-1 rounded mr-2' style='width:160px;'>
                    <select onchange='fields[${i}].type=this.value;renderFields()' class='border px-2 py-1 rounded mr-2'>
                        <option value='text' ${f.type==='text'?'selected':''}>Text</option>
                        <option value='number' ${f.type==='number'?'selected':''}>Number</option>
                        <option value='date' ${f.type==='date'?'selected':''}>Date</option>
                        <option value='textarea' ${f.type==='textarea'?'selected':''}>Textarea</option>
                        <option value='select' ${f.type==='select'?'selected':''}>Select</option>
                        <option value='radio' ${f.type==='radio'?'selected':''}>Radio</option>
                        <option value='checkbox' ${f.type==='checkbox'?'selected':''}>Checkbox</option>
                    </select>
                    <label class='ml-2'><input type='checkbox' ${f.required?'checked':''} onchange='fields[${i}].required=this.checked;renderFields()'> ${f.required ? 'Wajib' : 'Tidak Wajib'}</label>
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
        <!-- Hapus tips layout gambar & teks -->
        <div class="flex justify-end mb-4">
            <button type="button" onclick="showPreview()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mr-2">Preview</button>
        </div>
        <!-- Modal Preview -->
        <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 relative">
                <button onclick="closePreview()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                <h2 class="text-lg font-bold mb-4">Preview Template Surat</h2>
                <div id="previewContent" class="border p-4 rounded bg-gray-50 max-h-[60vh] overflow-auto"></div>
            </div>
        </div>
        <script>
        function showPreview() {
            fetch("{{ route('admin-desa.letter-templates.preview', $template->id) }}")
                .then(res => res.text())
                .then(html => {
                    // Ambil hanya isi surat dari response (jika view preview full layout, parse bagian yang diinginkan)
                    let parser = new DOMParser();
                    let doc = parser.parseFromString(html, 'text/html');
                    let surat = doc.querySelector('.border.p-4.rounded.bg-gray-50') ? doc.querySelector('.border.p-4.rounded.bg-gray-50').innerHTML : html;
                    document.getElementById('previewContent').innerHTML = surat;
                    document.getElementById('previewModal').classList.remove('hidden');
                });
        }
        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
        }
        </script>
        <div class="flex justify-end">
            <a href="{{ route('admin-desa.letter-templates.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded mr-2">Batal</a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection 