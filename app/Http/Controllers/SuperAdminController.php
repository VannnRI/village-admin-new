<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Village;
use App\Models\Role;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalVillages = Village::count();
        $totalAdminDesa = User::whereHas('roles', function($query) {
            $query->where('name', 'admin_desa');
        })->count();
        $totalPerangkatDesa = User::whereHas('roles', function($query) {
            $query->where('name', 'perangkat_desa');
        })->count();

        return view('super-admin.dashboard', compact('totalVillages', 'totalAdminDesa', 'totalPerangkatDesa'));
    }

    public function villages(Request $request)
    {
        $query = Village::query();
        if ($request->q) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('address', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%")
                    ->orWhere('phone', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('district', 'like', "%$q%")
                    ->orWhere('regency', 'like', "%$q%") ;
            });
        }
        $villages = $query->get();
        return view('super-admin.villages.index', compact('villages'));
    }

    public function createVillage()
    {
        return view('super-admin.villages.create');
    }

    public function storeVillage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'district' => 'nullable|string|max:100',
            'regency' => 'nullable|string|max:100',
        ]);

        // Generate unique code for village
        $code = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $request->name), 0, 3));
        $baseCode = $code;
        $counter = 1;
        
        // Make sure code is unique
        while (Village::where('code', $code)->exists()) {
            $code = $baseCode . $counter;
            $counter++;
        }

        Village::create(array_merge($request->all(), ['code' => $code]));

        return redirect()->route('super-admin.villages')->with('success', 'Desa berhasil ditambahkan');
    }

    public function editVillage($id)
    {
        $village = Village::findOrFail($id);
        return view('super-admin.villages.edit', compact('village'));
    }

    public function updateVillage(Request $request, $id)
    {
        $village = Village::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'district' => 'nullable|string|max:100',
            'regency' => 'nullable|string|max:100',
        ]);

        $village->update($request->all());

        return redirect()->route('super-admin.villages')->with('success', 'Desa berhasil diperbarui');
    }

    public function deleteVillage($id)
    {
        $village = Village::findOrFail($id);
        
        // Check if village has users
        if ($village->users()->count() > 0) {
            return redirect()->route('super-admin.villages')->with('error', 'Tidak dapat menghapus desa yang memiliki user.');
        }
        
        // Check if village has citizens
        if ($village->citizens()->count() > 0) {
            return redirect()->route('super-admin.villages')->with('error', 'Tidak dapat menghapus desa yang memiliki data warga.');
        }
        
        $village->delete();

        return redirect()->route('super-admin.villages')->with('success', 'Desa berhasil dihapus');
    }

    public function users(Request $request)
    {
        $query = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['admin_desa', 'perangkat_desa']);
        })->with(['roles', 'villages']);
        if ($request->q) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('username', 'like', "%$q%")
                    ->orWhereHas('villages', function($q2) use ($q) {
                        $q2->where('name', 'like', "%$q%") ;
                    })
                    ->orWhereHas('roles', function($q2) use ($q) {
                        $q2->where('name', 'like', "%$q%") ;
                    });
            });
        }
        $users = $query->get();
        return view('super-admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $villages = Village::all();
        $roles = Role::whereIn('name', ['admin_desa', 'perangkat_desa'])->get();
        
        return view('super-admin.users.create', compact('villages', 'roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'village_id' => 'required|exists:villages,id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password)
        ]);

        // Check if this is super admin role
        $role = Role::find($request->role_id);
        if ($role && $role->name === 'super_admin') {
            // Super admin doesn't need village_id
            $user->roles()->attach($request->role_id, [
                'village_id' => null,
                'is_active' => true
            ]);
        } else {
            // Other roles need village_id
            $user->roles()->attach($request->role_id, [
                'village_id' => $request->village_id,
                'is_active' => true
            ]);
        }

        return redirect()->route('super-admin.users')->with('success', 'User berhasil ditambahkan');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $villages = Village::all();
        $roles = Role::whereIn('name', ['admin_desa', 'perangkat_desa'])->get();
        
        return view('super-admin.users.edit', compact('user', 'villages', 'roles'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required|string',
            'village_id' => 'required|exists:villages,id',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // Update role and village
        $user->roles()->detach();
        
        // Check if this is super admin role
        $role = Role::find($request->role_id);
        if ($role && $role->name === 'super_admin') {
            // Super admin doesn't need village_id
            $user->roles()->attach($request->role_id, [
                'village_id' => null,
                'is_active' => true
            ]);
        } else {
            // Other roles need village_id
            $user->roles()->attach($request->role_id, [
                'village_id' => $request->village_id,
                'is_active' => true
            ]);
        }

        return redirect()->route('super-admin.users')->with('success', 'User berhasil diperbarui');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('super-admin.users')->with('success', 'User berhasil dihapus');
    }

    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        
        // Check if user has admin_desa or perangkat_desa role
        $hasValidRole = $user->roles()->whereIn('name', ['admin_desa', 'perangkat_desa'])->exists();
        
        if (!$hasValidRole) {
            return redirect()->route('super-admin.users')->with('error', 'Hanya admin desa dan perangkat desa yang dapat direset password.');
        }

        // Reset password to default
        $user->update(['password' => Hash::make('password123')]);

        return redirect()->route('super-admin.users')->with('success', 'Password berhasil direset menjadi "password123"');
    }
} 