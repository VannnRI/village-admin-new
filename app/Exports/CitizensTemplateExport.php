<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CitizensTemplateExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Return example data for template
        return collect([
            [
                'nik' => '1234567890123456',
                'nama' => 'Contoh Nama',
                'no_kk' => '1234567890123456',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '01/01/1990',
                'alamat' => 'Jl. Contoh No. 123',
                'no_telepon' => '081234567890',
                'email' => 'contoh@email.com',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'status_perkawinan' => 'Menikah',
                'pendidikan' => 'SMA',
                'pekerjaan' => 'Wiraswasta',
                'kewarganegaraan' => 'Indonesia'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'NIK (Wajib - 16 digit)',
            'Nama (Wajib)',
            'No KK (Wajib - 16 digit)',
            'Tempat Lahir (Wajib)',
            'Tanggal Lahir (Wajib - dd/mm/yyyy)',
            'Alamat (Wajib)',
            'No Telepon (Opsional)',
            'Email (Opsional)',
            'Jenis Kelamin (Wajib - L/P)',
            'Agama (Wajib)',
            'Status Perkawinan (Wajib)',
            'Pendidikan (Wajib)',
            'Pekerjaan (Wajib)',
            'Kewarganegaraan (Wajib)'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E5E7EB']
                ]
            ]
        ];
    }
}
