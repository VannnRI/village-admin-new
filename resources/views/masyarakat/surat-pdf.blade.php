<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat {{ $request->letter_name }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 12pt;
        }
        .header .alamat {
            font-size: 11pt;
        }
        .nomor-surat {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }
        .content {
            text-align: justify;
            margin: 20px 0;
        }
        .data-table {
            margin: 20px 0;
        }
        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table td {
            padding: 3px 10px;
            vertical-align: top;
        }
        .data-table td:first-child {
            width: 120px;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .footer p {
            margin: 5px 0;
        }
        .ttd {
            margin-top: 60px;
        }
        .garis {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 5px;
        }
        .stempel {
            position: absolute;
            right: 100px;
            top: 400px;
            width: 80px;
            height: 80px;
            border: 2px solid #000;
            border-radius: 50%;
            text-align: center;
            line-height: 80px;
            font-size: 8pt;
            font-weight: bold;
        }
        .additional-data {
            margin: 15px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #007cba;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>PEMERINTAH KABUPATEN LAMONGAN</h3>
        <h3>KECAMATAN {{ strtoupper($village->district ?? 'KECAMATAN') }}</h3>
        <h3>DESA {{ strtoupper($village->name ?? 'DESA') }}</h3>
        <p class="alamat">Alamat: {{ $village->address ?? 'Jl. Desa No. 1' }} | Telp: {{ $village->phone ?? '-' }} | Email: {{ $village->email ?? '-' }}</p>
        <div style="border-bottom: 3px solid #000; width: 200px; margin: 10px auto;"></div>
    </div>

    <div class="nomor-surat">
        <p>NOMOR: {{ $request->request_number ?? '001' }}/{{ date('m') }}/{{ date('Y') }}</p>
        <p style="margin-top: 5px;">Tentang</p>
        <p style="margin-top: 5px; font-size: 14pt;">{{ strtoupper($request->letter_name) }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini:</p>
        
        <div class="data-table">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>: Kepala Desa {{ $village->name ?? 'Desa' }}</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>: -</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $village->address ?? 'Jl. Desa No. 1' }}</td>
                </tr>
            </table>
        </div>

        <p>Dengan ini menerangkan bahwa:</p>

        <div class="data-table">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>: {{ $citizen->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tempat/Tgl Lahir</td>
                    <td>: {{ $citizen->birth_place ?? '-' }}, {{ $citizen->birth_date ?? '-' }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>: {{ $citizen->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td>No. KK</td>
                    <td>: {{ $citizen->no_kk ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $citizen->address ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>: {{ $citizen->religion ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status Perkawinan</td>
                    <td>: {{ $citizen->marital_status ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>: {{ $citizen->job ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Kewarganegaraan</td>
                    <td>: WNI</td>
                </tr>
            </table>
        </div>

        @if($request->notes)
        <div class="additional-data">
            <strong>Data Tambahan:</strong><br>
            {!! nl2br(e($request->notes)) !!}
        </div>
        @endif

        <p>Adalah benar warga Desa {{ $village->name ?? 'Desa' }}, Kecamatan {{ $village->district ?? 'Kecamatan' }}, Kabupaten {{ $village->regency ?? 'Lamongan' }}.</p>

        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <p>{{ $village->name ?? 'Desa' }}, {{ date('d F Y') }}</p>
        <p>Kepala Desa {{ $village->name ?? 'Desa' }}</p>
        <div class="ttd">
            <p style="margin-bottom: 60px;">{{ $village->head_name ?? 'Kepala Desa' }}</p>
            <div class="garis"></div>
        </div>
    </div>

    <div class="stempel">
        STEMPEL<br>DESA
    </div>
</body>
</html> 