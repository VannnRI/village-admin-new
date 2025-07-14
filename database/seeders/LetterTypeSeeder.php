<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetterType;

class LetterTypeSeeder extends Seeder
{
    public function run()
    {
        $villageId = 1; // Ganti sesuai kebutuhan jika multi desa
        // Pastikan village dengan ID 1 ada, jika tidak gunakan ID yang ada
        if (!\App\Models\Village::find($villageId)) {
            $village = \App\Models\Village::first();
            if ($village) {
                $villageId = $village->id;
            }
        }

        // Daftar field yang sudah ada di tabel citizen
        $citizenFields = [
            'nik', 'kk_number', 'name', 'birth_place', 'birth_date', 'address', 'phone', 'email',
            'gender', 'religion', 'marital_status', 'education', 'job', 'nationality', 'is_active'
        ];

        // 1. Surat Keterangan Tidak Mampu
        $type1 = \App\Models\LetterType::where('name', 'Surat Keterangan Tidak Mampu')->where('village_id', $villageId)->first();
        if (!$type1) {
            $type1 = \App\Models\LetterType::create([
                'village_id' => $villageId,
                'name' => 'Surat Keterangan Tidak Mampu',
                'processing_days' => 2,
                'template_html' => '<div style="text-align:center;font-weight:bold;">PEMERINTAH KABUPATEN LAMONGAN<br>KECAMATAN KEDUNGPRING<br>DESA WARUNGERING</div><div style="text-align:center;">Alamat: Jl. Raya Warungering-Kedungpring No. 031 - KodePos. 62272</div><hr><div style="text-align:center;font-weight:bold;text-decoration:underline;">SURAT KETERANGAN TIDAK MAMPU</div><div style="text-align:center;">No. {{ nomor_surat }}/{{ kode_desa }}/{{ tahun }}</div><br><div>Yang bertanda tangan di bawah ini, Kepala Desa {{ nama_desa }}, Kecamatan {{ kecamatan }} Kabupaten {{ kabupaten }}, menerangkan dengan sebenarnya bahwa :</div><table style="margin-left:40px;"> <tr><td>Nama</td><td>:</td><td>{{ name }}</td></tr> <tr><td>Tempat/Tgl.Lahir</td><td>:</td><td>{{ birth_place }}, {{ birth_date }}</td></tr> <tr><td>NIK</td><td>:</td><td>{{ nik }}</td></tr> <tr><td>Jenis Kelamin</td><td>:</td><td>{{ gender }}</td></tr> <tr><td>Agama</td><td>:</td><td>{{ religion }}</td></tr> <tr><td>Kewarganegaraan</td><td>:</td><td>{{ nationality }}</td></tr> <tr><td>Alamat</td><td>:</td><td>{{ address }}</td></tr> <tr><td>Keterangan</td><td>:</td><td>{{ keterangan }}</td></tr></table><br>Surat Keterangan ini dibuat untuk :<br><b>{{ tujuan }}</b><br><br>Demikian Surat Keterangan ini diberikan untuk dapat dipergunakan sebagaimana mestinya, dan menjadi maklum adanya.<br><br><div style="text-align:right;">{{ nama_desa }}, {{ tanggal_surat }}<br>Kepala Desa {{ nama_desa }}<br><br><br><b>{{ kepala_desa }}</b></div>',
                'is_active' => 1,
            ]);
            $fields1 = [
                ['field_name'=>'keterangan','field_label'=>'Keterangan','field_type'=>'textarea','is_required'=>0],
                ['field_name'=>'tujuan','field_label'=>'Tujuan','field_type'=>'textarea','is_required'=>1],
            ];
            foreach ($fields1 as $i => $f) {
                $type1->fields()->create(array_merge($f, ['order'=>$i+1, 'village_id'=>$villageId]));
            }
        }

        // 2. Surat Keterangan Domisili
        $type2 = \App\Models\LetterType::where('name', 'Surat Keterangan Domisili')->where('village_id', $villageId)->first();
        if (!$type2) {
            $type2 = \App\Models\LetterType::create([
                'village_id' => $villageId,
                'name' => 'Surat Keterangan Domisili',
                'processing_days' => 2,
                'template_html' => '<div style="text-align:center;font-weight:bold;">PEMERINTAH KABUPATEN LAMONGAN<br>KECAMATAN KEDUNGPRING<br>DESA WARUNGERING</div><div style="text-align:center;">Alamat: Jl. Raya Warungering-Kedungpring No. 031 - KodePos. 62272</div><hr><div style="text-align:center;font-weight:bold;text-decoration:underline;">SURAT KETERANGAN DOMISILI</div><div style="text-align:center;">No. {{ nomor_surat }}/{{ kode_desa }}/{{ tahun }}</div><br><div>Yang bertanda tangan di bawah ini, Kepala Desa {{ nama_desa }}, Kecamatan {{ kecamatan }} Kabupaten {{ kabupaten }}, menerangkan dengan sebenarnya bahwa :</div><table style="margin-left:40px;"> <tr><td>Nama</td><td>:</td><td>{{ name }}</td></tr> <tr><td>Tempat/Tgl.Lahir</td><td>:</td><td>{{ birth_place }}, {{ birth_date }}</td></tr> <tr><td>NIK</td><td>:</td><td>{{ nik }}</td></tr> <tr><td>Jenis Kelamin</td><td>:</td><td>{{ gender }}</td></tr> <tr><td>Agama</td><td>:</td><td>{{ religion }}</td></tr> <tr><td>Kewarganegaraan</td><td>:</td><td>{{ nationality }}</td></tr> <tr><td>Pekerjaan</td><td>:</td><td>{{ job }}</td></tr> <tr><td>Alamat</td><td>:</td><td>{{ address }}</td></tr></table><br>Alamat Tinggal / Domisili: <b>{{ domisili }}</b><br><br>Demikian Surat Keterangan ini diberikan untuk dapat dipergunakan sebagaimana mestinya, dan menjadi maklum adanya.<br><br><div style="text-align:right;">{{ nama_desa }}, {{ tanggal_surat }}<br>Kepala Desa {{ nama_desa }}<br><br><br><b>{{ kepala_desa }}</b></div>',
                'is_active' => 1,
            ]);
            $fields2 = [
                ['field_name'=>'domisili','field_label'=>'Alamat Domisili','field_type'=>'textarea','is_required'=>1],
            ];
            foreach ($fields2 as $i => $f) {
                $type2->fields()->create(array_merge($f, ['order'=>$i+1, 'village_id'=>$villageId]));
            }
        }

        // 3. Surat Keterangan Kematian
        $type3 = \App\Models\LetterType::where('name', 'Surat Keterangan Kematian')->where('village_id', $villageId)->first();
        if (!$type3) {
            $type3 = \App\Models\LetterType::create([
                'village_id' => $villageId,
                'name' => 'Surat Keterangan Kematian',
                'processing_days' => 2,
                'template_html' => '<div style="text-align:center;font-weight:bold;">PEMERINTAH KABUPATEN LAMONGAN<br>KECAMATAN KEDUNGPRING<br>DESA WARUNGERING</div><div style="text-align:center;">Alamat: Jl. Raya Warungering-Kedungpring No. 031 - KodePos. 62272</div><hr><div style="text-align:center;font-weight:bold;text-decoration:underline;">SURAT KETERANGAN KEMATIAN</div><div style="text-align:center;">No. {{ nomor_surat }}/{{ kode_desa }}/{{ tahun }}</div><br><div>Yang bertanda tangan di bawah ini, Kepala Desa {{ nama_desa }}, Kecamatan {{ kecamatan }} Kabupaten {{ kabupaten }}, menerangkan dengan sebenarnya bahwa :</div><table style="margin-left:40px;"> <tr><td>Nama (Alm)</td><td>:</td><td>{{ nama_alm }}</td></tr> <tr><td>Umur</td><td>:</td><td>{{ umur }}</td></tr> <tr><td>NIK</td><td>:</td><td>{{ nik_alm }}</td></tr> <tr><td>Jenis Kelamin</td><td>:</td><td>{{ jenis_kelamin_alm }}</td></tr> <tr><td>Alamat</td><td>:</td><td>{{ alamat_alm }}</td></tr></table><br>Telah Meninggal Dunia pada :<br><table style="margin-left:40px;"> <tr><td>Hari</td><td>:</td><td>{{ hari_meninggal }}</td></tr> <tr><td>Tanggal</td><td>:</td><td>{{ tanggal_meninggal }}</td></tr> <tr><td>Tempat Meninggal</td><td>:</td><td>{{ tempat_meninggal }}</td></tr> <tr><td>Disebabkan karena</td><td>:</td><td>{{ sebab_meninggal }}</td></tr></table><br>Demikian Surat Keterangan ini diberikan untuk dapat dipergunakan sebagaimana mestinya, dan menjadi maklum adanya.<br><br><div style="text-align:right;">{{ nama_desa }}, {{ tanggal_surat }}<br>Kepala Desa {{ nama_desa }}<br><br><br><b>{{ kepala_desa }}</b></div>',
                'is_active' => 1,
            ]);
            $fields3 = [
                ['field_name'=>'nama_alm','field_label'=>'Nama (Alm)','field_type'=>'text','is_required'=>1],
                ['field_name'=>'umur','field_label'=>'Umur','field_type'=>'text','is_required'=>1],
                ['field_name'=>'nik_alm','field_label'=>'NIK (Alm)','field_type'=>'text','is_required'=>1],
                ['field_name'=>'jenis_kelamin_alm','field_label'=>'Jenis Kelamin','field_type'=>'text','is_required'=>1],
                ['field_name'=>'alamat_alm','field_label'=>'Alamat','field_type'=>'text','is_required'=>1],
                ['field_name'=>'hari_meninggal','field_label'=>'Hari Meninggal','field_type'=>'text','is_required'=>1],
                ['field_name'=>'tanggal_meninggal','field_label'=>'Tanggal Meninggal','field_type'=>'date','is_required'=>1],
                ['field_name'=>'tempat_meninggal','field_label'=>'Tempat Meninggal','field_type'=>'text','is_required'=>1],
                ['field_name'=>'sebab_meninggal','field_label'=>'Sebab Meninggal','field_type'=>'text','is_required'=>1],
            ];
            foreach ($fields3 as $i => $f) {
                $type3->fields()->create(array_merge($f, ['order'=>$i+1, 'village_id'=>$villageId]));
            }
        }

        // 4. Surat Catatan Kepolisian
        $type4 = \App\Models\LetterType::where('name', 'Surat Catatan Kepolisian')->where('village_id', $villageId)->first();
        if (!$type4) {
            $type4 = \App\Models\LetterType::create([
                'village_id' => $villageId,
                'name' => 'Surat Catatan Kepolisian',
                'processing_days' => 2,
                'template_html' => '<div style="text-align:center;font-weight:bold;">PEMERINTAH KABUPATEN LAMONGAN<br>KECAMATAN KEDUNGPRING<br>DESA WARUNGERING</div><div style="text-align:center;">Alamat: Jl. Raya Warungering-Kedungpring No. 031 - KodePos. 62272</div><hr><div style="text-align:center;font-weight:bold;text-decoration:underline;">SURAT KETERANGAN CATATAN KEPOLISIAN</div><div style="text-align:center;">No. {{ nomor_surat }}/{{ kode_desa }}/{{ tahun }}</div><br><div>Yang bertanda tangan di bawah ini, Kepala Desa {{ nama_desa }}, Kecamatan {{ kecamatan }} Kabupaten {{ kabupaten }}, menerangkan dengan sebenarnya bahwa :</div><table style="margin-left:40px;"> <tr><td>Nama</td><td>:</td><td>{{ name }}</td></tr> <tr><td>Tempat/Tgl.Lahir</td><td>:</td><td>{{ birth_place }}, {{ birth_date }}</td></tr> <tr><td>NIK</td><td>:</td><td>{{ nik }}</td></tr> <tr><td>Jenis Kelamin</td><td>:</td><td>{{ gender }}</td></tr> <tr><td>Agama</td><td>:</td><td>{{ religion }}</td></tr> <tr><td>Kewarganegaraan</td><td>:</td><td>{{ nationality }}</td></tr> <tr><td>Pekerjaan</td><td>:</td><td>{{ job }}</td></tr> <tr><td>Alamat</td><td>:</td><td>{{ address }}</td></tr></table><br><div>Sepanjang penelitian Kami, langsung maupun tidak langsung Orang tersebut diatas maka yang bersangkutan :</div><ol><li>BERKELAKUAN BAIK DAN BELUM PERNAH TERSANGKUT URUSAN / PERKARA POLISI, SERTA BELUM PERNAH DIHUKUM .</li><li>TIDAK PERNAH TERSANGKUT DALAM DAFTAR PELAKU/ANGGOTA ORGANISASI TERLARANG .</li></ol>Surat Keterangan ini dipergunakan untuk Persyaratan Administrasi :<br><b>{{ keperluan }}</b><br><br>Demikian Surat Keterangan ini diberikan untuk dapat dipergunakan sebagaimana mestinya, dan menjadi maklum adanya.<br><br><div style="text-align:right;">{{ nama_desa }}, {{ tanggal_surat }}<br>Kepala Desa {{ nama_desa }}<br><br><br><b>{{ kepala_desa }}</b></div>',
                'is_active' => 1,
            ]);
            $fields4 = [
                ['field_name'=>'keperluan','field_label'=>'Keperluan','field_type'=>'textarea','is_required'=>1],
            ];
            foreach ($fields4 as $i => $f) {
                $type4->fields()->create(array_merge($f, ['order'=>$i+1, 'village_id'=>$villageId]));
            }
        }
    }
} 