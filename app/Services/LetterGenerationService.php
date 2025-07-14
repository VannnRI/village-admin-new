<?php

namespace App\Services;

use App\Models\LetterRequest;
use App\Models\Citizen;
use App\Models\Village;
use App\Models\VillageOfficial;
use Carbon\Carbon;

class LetterGenerationService
{
    public function generateLetterContent(LetterRequest $request, Citizen $citizen, Village $village)
    {
        $letterType = $request->letterType;
        $templateHtml = $letterType->template_html;
        
        if (empty($templateHtml)) {
            return $this->generateDefaultLetter($request, $citizen, $village);
        }
        
        // Prepare data for template
        $data = $this->prepareTemplateData($request, $citizen, $village);
        
        // Replace placeholders in template
        $content = $this->replacePlaceholders($templateHtml, $data);
        
        return $content;
    }
    
    private function prepareTemplateData(LetterRequest $request, Citizen $citizen, Village $village)
    {
        $requestData = json_decode($request->data, true) ?? [];
        $now = Carbon::now();

        // Format nomor urut tiga digit
        $nomorUrut = str_pad($request->nomor_urut ?? $request->id, 3, '0', STR_PAD_LEFT);

        // Nomor surat hanya nomor urut saja, tidak pakai format custom
        $nomorSurat = $nomorUrut;

        // Ambil semua perangkat desa untuk desa ini
        $officials = VillageOfficial::where('village_id', $village->id)->get();
        $officialVars = [];
        foreach ($officials as $official) {
            $key = strtolower(str_replace([' ', '.'], '_', $official->position));
            $officialVars[$key . '_nama'] = $official->name;
            $officialVars[$key . '_nip'] = $official->nip;
        }

        return array_merge([
            // Citizen data (Indonesia)
            'nama' => $citizen->name ?? '',
            'nik' => $citizen->nik ?? '',
            'alamat' => $citizen->address ?? '',
            'tempat_lahir' => $citizen->birth_place ?? '',
            'tgl_lahir' => $citizen->birth_date ? Carbon::parse($citizen->birth_date)->format('d-m-Y') : '',
            'agama' => $citizen->religion ?? '',
            'pekerjaan' => $citizen->job ?? '',
            'jenis_kelamin' => $citizen->gender == 'L' ? 'Laki-laki' : ($citizen->gender == 'P' ? 'Perempuan' : ''),
            'kewarganegaraan' => $citizen->nationality ?? 'Indonesia',
            // Citizen data (English/alias)
            'name' => $citizen->name ?? '',
            'address' => $citizen->address ?? '',
            'birth_place' => $citizen->birth_place ?? '',
            'birth_date' => $citizen->birth_date ? Carbon::parse($citizen->birth_date)->format('d-m-Y') : '',
            'religion' => $citizen->religion ?? '',
            'job' => $citizen->job ?? '',
            'gender' => $citizen->gender == 'L' ? 'Laki-laki' : ($citizen->gender == 'P' ? 'Perempuan' : ''),
            'nationality' => $citizen->nationality ?? 'Indonesia',
            
            // Village data
            'nama_desa' => $village->name ?? '',
            'alamat_desa' => $village->address ?? '',
            'telepon_desa' => $village->phone ?? '',
            'email_desa' => $village->email ?? '',
            'kode_desa' => $village->village_code ?? '',
            'kode_pos' => $village->postal_code ?? '',
            'kecamatan' => $village->district ?? '',
            'kabupaten' => $village->regency ?? '',
            
            // Letter data
            'jenis_surat' => $request->letter_name ?? '',
            'nomor_surat' => $nomorSurat,
            'tanggal_surat' => $now->format('d-m-Y'),
            'bulan' => $now->format('F'),
            'bulan_romawi' => $this->numberToRoman($now->month),
            'tahun' => $now->format('Y'),
            'nomor_urut' => $nomorUrut,
            
            // Dynamic fields from request
            'keterangan' => $requestData['keterangan'] ?? '',
            'tujuan' => $request->purpose ?? '',
            'domisili' => $requestData['domicile_address'] ?? '',
            'umur' => $requestData['umur'] ?? '',
            'tanggal_meninggal' => $requestData['tanggal_meninggal'] ?? '',
            'hari_meninggal' => $requestData['hari_meninggal'] ?? '',
            'tempat_meninggal' => $requestData['tempat_meninggal'] ?? '',
            'sebab_meninggal' => $requestData['sebab_meninggal'] ?? '',
            
            // Village head
            'kepala_desa' => $village->head_name ?? 'Kepala Desa',
            
            // Additional dynamic fields
            ...$officialVars,
            ...$requestData
        ]);
    }
    
    private function replacePlaceholders($template, $data)
    {
        foreach ($data as $key => $value) {
            $placeholder = '{{ ' . $key . ' }}';
            $template = str_replace($placeholder, $value, $template);
        }
        
        return $template;
    }
    
    private function generateDefaultLetter(LetterRequest $request, Citizen $citizen, Village $village)
    {
        $now = Carbon::now();
        
        return '
        <div style="font-family: Times New Roman, serif; font-size: 12pt; line-height: 1.5; margin: 20px;">
            <div style="text-align: center; margin-bottom: 20px;">
                <h3 style="margin: 0; font-size: 16pt; font-weight: bold;">PEMERINTAH KABUPATEN LAMONGAN</h3>
                <h3 style="margin: 0; font-size: 16pt; font-weight: bold;">KECAMATAN ' . strtoupper($village->district ?? 'KECAMATAN') . '</h3>
                <h3 style="margin: 0; font-size: 16pt; font-weight: bold;">DESA ' . strtoupper($village->name ?? 'DESA') . '</h3>
                <p style="margin: 2px 0; font-size: 12pt;">Alamat: ' . ($village->address ?? 'Jl. Desa No. 1') . ' | Telp: ' . ($village->phone ?? '-') . ' | Email: ' . ($village->email ?? '-') . '</p>
                <div style="border-bottom: 3px solid #000; width: 200px; margin: 10px auto;"></div>
            </div>
            
            <div style="text-align: center; margin: 20px 0; font-weight: bold;">
                <p>NOMOR: ' . ($request->request_number ?? '001') . '/' . $now->format('m') . '/' . $now->format('Y') . '</p>
                <p style="margin-top: 5px;">Tentang</p>
                <p style="margin-top: 5px; font-size: 14pt;">' . strtoupper($request->letter_name ?? 'SURAT KETERANGAN') . '</p>
            </div>
            
            <div style="text-align: justify; margin: 20px 0;">
                <p>Yang bertanda tangan di bawah ini, Kepala Desa ' . ($village->name ?? 'Desa') . ', menerangkan dengan sebenarnya bahwa:</p>
                <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                    <tr><td style="width: 120px; padding: 3px 10px; vertical-align: top;">Nama</td><td style="padding: 3px 10px; vertical-align: top;">: ' . ($citizen->name ?? '-') . '</td></tr>
                    <tr><td style="padding: 3px 10px; vertical-align: top;">NIK</td><td style="padding: 3px 10px; vertical-align: top;">: ' . ($citizen->nik ?? '-') . '</td></tr>
                    <tr><td style="padding: 3px 10px; vertical-align: top;">Tempat/Tgl.Lahir</td><td style="padding: 3px 10px; vertical-align: top;">: ' . ($citizen->birth_place ?? '-') . ', ' . ($citizen->birth_date ? Carbon::parse($citizen->birth_date)->format('d-m-Y') : '-') . '</td></tr>
                    <tr><td style="padding: 3px 10px; vertical-align: top;">Jenis Kelamin</td><td style="padding: 3px 10px; vertical-align: top;">: ' . ($citizen->gender == 'L' ? 'Laki-laki' : ($citizen->gender == 'P' ? 'Perempuan' : '-')) . '</td></tr>
                    <tr><td style="padding: 3px 10px; vertical-align: top;">Agama</td><td style="padding: 3px 10px; vertical-align: top;">: ' . ($citizen->religion ?? '-') . '</td></tr>
                    <tr><td style="padding: 3px 10px; vertical-align: top;">Pekerjaan</td><td style="padding: 3px 10px; vertical-align: top;">: ' . ($citizen->job ?? '-') . '</td></tr>
                    <tr><td style="padding: 3px 10px; vertical-align: top;">Alamat</td><td style="padding: 3px 10px; vertical-align: top;">: ' . ($citizen->address ?? '-') . '</td></tr>
                </table>
                
                <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
            </div>
            
            <div style="margin-top: 40px; text-align: right;">
                <p style="margin: 5px 0;">' . ($village->name ?? 'Desa') . ', ' . $now->format('d-m-Y') . '</p>
                <p style="margin: 5px 0;">Kepala Desa ' . ($village->name ?? 'Desa') . '</p>
                <br><br><br>
                <p style="margin: 5px 0;"><strong>' . ($village->head_name ?? 'Kepala Desa') . '</strong></p>
            </div>
        </div>';
    }
    
    private function numberToRoman($number)
    {
        $romans = [
            1000 => 'M',
            900 => 'CM',
            500 => 'D',
            400 => 'CD',
            100 => 'C',
            90 => 'XC',
            50 => 'L',
            40 => 'XL',
            10 => 'X',
            9 => 'IX',
            5 => 'V',
            4 => 'IV',
            1 => 'I'
        ];
        
        $result = '';
        foreach ($romans as $value => $roman) {
            while ($number >= $value) {
                $result .= $roman;
                $number -= $value;
            }
        }
        
        return $result;
    }
} 