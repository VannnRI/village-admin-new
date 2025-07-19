<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Citizen;
use App\Models\Role;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $login = $request->input('username');
        $password = $request->input('password');

        // Cek apakah login menggunakan NIK (16 digit angka)
        if (is_numeric($login) && strlen($login) === 16) {
            $citizen = Citizen::where('nik', $login)->first();

            // Jika penduduk ada
            if ($citizen) {
                // Cek apakah user sudah ada
                $user = $citizen->user;
                
                if (!$user) {
                    // Jika belum ada user, cek apakah password sesuai dengan tanggal lahir (Y-m-d)
                    if ($password === $citizen->birth_date->format('Y-m-d')) {
                        // Cek apakah email sudah digunakan
                        $email = $citizen->email ?? $citizen->nik . '@mail.com';
                        $counter = 1;
                        $originalEmail = $email;
                        
                        // Jika email sudah ada, tambahkan angka di belakang
                        while (User::where('email', $email)->exists()) {
                            $email = $originalEmail;
                            $emailParts = explode('@', $email);
                            $email = $emailParts[0] . $counter . '@' . $emailParts[1];
                            $counter++;
                        }
                        
                        $user = User::create([
                            'name' => $citizen->name,
                            'username' => $citizen->nik,
                            'email' => $email,
                            'password' => Hash::make($password),
                        ]);

                        // Hubungkan user dengan citizen
                        $citizen->user_id = $user->id;
                        $citizen->save();
                        
                        // Beri role masyarakat
                        $masyarakatRole = Role::where('name', 'masyarakat')->first();
                        if ($masyarakatRole) {
                            $user->roles()->attach($masyarakatRole->id, ['village_id' => $citizen->village_id]);
                        }
                        
                        // Login dengan user yang baru dibuat
                        if (Auth::loginUsingId($user->id)) {
                            return redirect()->route('masyarakat.dashboard');
                        }
                    }
                } else {
                    // Jika user sudah ada, coba login dengan password yang diinput
                    if (Auth::attempt(['username' => $user->username, 'password' => $password])) {
                        return redirect()->route('masyarakat.dashboard');
                    }
                }
            }
        }

        // Jika bukan NIK atau login NIK gagal, coba login sebagai admin/perangkat
        if (Auth::attempt(['username' => $login, 'password' => $password])) {
            $user = Auth::user();
            if ($user->isSuperAdmin()) {
                return redirect()->route('super-admin.dashboard');
            } elseif ($user->isAdminDesa()) {
                return redirect()->route('admin-desa.dashboard');
            } elseif ($user->isPerangkatDesa()) {
                return redirect()->route('perangkat-desa.dashboard');
            }
        }

        return back()->withErrors([
            'username' => 'Kredensial yang Anda masukkan salah.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}