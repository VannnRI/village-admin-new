<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Create super admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        // Get super admin role
        $superAdminRole = Role::where('name', 'super_admin')->first();

        // Attach role to user (without village for super admin)
        if ($superAdminRole) {
            $superAdmin->roles()->attach($superAdminRole->id, [
                'village_id' => null,
                'is_active' => true
            ]);
        }
    }
} 