<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Village;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Village::create([
            'name' => 'Warungering',
            'district' => 'Kedungpring',
            'regency' => 'Lamongan',
            'code' => 'WAR001',
            'description' => 'Desa Warungering adalah desa yang terletak di Kecamatan Kedungpring, Kabupaten Lamongan, Provinsi Jawa Timur.',
            'address' => 'Jl. Raya Warungering-Kedungpring No. 031',
            'phone' => '0322-123456',
            'email' => 'warungering@desa.id',
            'website' => 'https://warungering.desa.id',
            'postal_code' => '62272',
            'village_code' => '3524152001',
            'is_active' => true,
        ]);
    }
}
