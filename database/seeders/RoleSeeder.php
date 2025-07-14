<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'super_admin',
                'display_name' => 'Super Admin',
                'description' => 'Administrator utama sistem'
            ],
            [
                'name' => 'admin_desa',
                'display_name' => 'Admin Desa',
                'description' => 'Administrator desa'
            ],
            [
                'name' => 'perangkat_desa',
                'display_name' => 'Perangkat Desa',
                'description' => 'Perangkat desa yang memvalidasi surat'
            ],
            [
                'name' => 'masyarakat',
                'display_name' => 'Masyarakat',
                'description' => 'Masyarakat yang mengajukan surat'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 