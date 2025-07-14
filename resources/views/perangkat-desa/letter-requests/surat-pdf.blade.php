<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin: 0 30px; }
        .ttd { margin-top: 40px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>PEMERINTAH DESA {{ strtoupper($village->name) }}</h2>
        <p>{{ $village->address }}</p>
        <hr>
        <h3>SURAT KETERANGAN</h3>
    </div>
    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala Desa {{ $village->name }}, menerangkan bahwa:</p>
        <table style="margin-left: 20px;">
            <tr><td>Nama</td><td>:</td><td>{{ $request->citizen->name }}</td></tr>
            <tr><td>NIK</td><td>:</td><td>{{ $request->citizen->nik }}</td></tr>
            <tr><td>No KK</td><td>:</td><td>{{ $request->citizen->kk_number }}</td></tr>
            <tr><td>Alamat</td><td>:</td><td>{{ $request->citizen->address }}</td></tr>
            <tr><td>Jenis Surat</td><td>:</td><td>{{ $request->letterType->name ?? '-' }}</td></tr>
            <tr><td>Tujuan Permohonan</td><td>:</td><td>{{ $request->purpose ?? '-' }}</td></tr>
        </table>
        <p style="margin-top: 20px;">Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    </div>
    <div class="ttd">
        <p>{{ $village->name }}, {{ date('d-m-Y') }}</p>
        <p>Kepala Desa</p>
        <br><br><br>
        <p>__________________________</p>
    </div>
</body>
</html> 