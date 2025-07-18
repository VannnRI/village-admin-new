<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class CitizensTemplateExport implements FromArray, WithHeadings, WithStyles, WithEvents
{
    public function array(): array
    {
        return [
            // Baris 2: Keterangan
            [
                'Wajib - 16 digit',
                'Wajib',
                'Wajib - 16 digit',
                'Wajib',
                'Wajib - dd/mm/yyyy',
                'Wajib',
                'Opsional',
                'Opsional',
                'Wajib - L/P',
                'Wajib',
                'Wajib',
                'Wajib',
                'Wajib',
                'Wajib',
            ],
            // Baris 3: Contoh data
            [
                '1234567890123456',
                'Contoh Nama',
                '1234567890123456',
                'Jakarta',
                '01/01/1990',
                'Jl. Contoh No. 123',
                '081234567890',
                'contoh@email.com',
                'L',
                'Islam',
                'Menikah',
                'SMA',
                'Wiraswasta',
                'Indonesia',
            ],
        ];
    }

    public function headings(): array
    {
        // Baris 1: Nama field (untuk import)
        return [
            'nik',
            'nama',
            'no_kk',
            'tempat_lahir',
            'tanggal_lahir',
            'alamat',
            'no_telepon',
            'email',
            'jenis_kelamin',
            'agama',
            'status_perkawinan',
            'pendidikan',
            'pekerjaan',
            'kewarganegaraan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Baris 1 (header) bold
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E5E7EB']
                ]
            ],
            2 => [
                'font' => ['italic' => true],
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Pewarnaan kolom wajib (A, B, C, D, E, F, I, J, K, L, M, N, O)
                $wajibColumns = ['A','B','C','D','E','F','I','J','K','L','M','N','O'];
                foreach ($wajibColumns as $col) {
                    // Baris 2 (keterangan) diberi warna kuning
                    $event->sheet->getDelegate()->getStyle("{$col}2")->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setRGB('FFFACD'); // LemonChiffon
                }
            }
        ];
    }
}
