<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Citizen;
use App\Models\Village;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class MasyarakatSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil role masyarakat
        $masyarakatRole = Role::where('name', 'masyarakat')->first();
        if (!$masyarakatRole) {
            $this->command->error('Role masyarakat tidak ditemukan!');
            return;
        }

        // Ambil desa pertama
        $village = Village::first();
        if (!$village) {
            $this->command->error('Tidak ada desa yang tersedia!');
            return;
        }

        // Hapus user & citizen jika sudah ada
        User::where('nik', '1234567890123456')->orWhere('email', 'john.doe@example.com')->delete();
        Citizen::where('nik', '1234567890123456')->delete();

        // Buat user masyarakat
        $user = User::create([
            'name' => 'John Doe',
            'username' => '1234567890123456', // NIK sebagai username
            'email' => 'john.doe@example.com',
            'nik' => '1234567890123456',
            'password' => Hash::make('1990-01-01'), // Tanggal lahir sebagai password
        ]);

        // Buat citizen
        $citizen = Citizen::create([
            'village_id' => $village->id,
            'name' => 'John Doe',
            'nik' => '1234567890123456',
            'kk_number' => '1234567890123456',
            'birth_place' => 'Jakarta',
            'birth_date' => '1990-01-01',
            'address' => 'Jl. Contoh No. 123',
            'phone' => '081234567890',
            'gender' => 'L',
            'religion' => 'Islam',
            'marital_status' => 'Belum Menikah',
            'education' => 'SMA',
            'job' => 'Wiraswasta',
        ]);

        // Attach role masyarakat ke user
        $user->villages()->attach($village->id, [
            'role_id' => $masyarakatRole->id,
            'is_active' => true
        ]);

        $this->command->info('User masyarakat berhasil dibuat!');
        $this->command->info('Username (NIK): 1234567890123456');
        $this->command->info('Password (Tanggal Lahir): 1990-01-01');
    }
} 