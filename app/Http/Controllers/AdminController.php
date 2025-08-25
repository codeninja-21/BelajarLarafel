<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\admin; // Tambahkan baris ini untuk mengimpor Model Admin
use Exception;

class AdminController extends Controller
{
    public function landing()
    {
        $articles = \App\Models\Article::where('is_published', true)
                                     ->orderBy('created_at', 'desc')
                                     ->take(5)
                                     ->get();
        return view('landing', compact('articles'));
    }

    public function formLogin()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        $admin = admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // simpan ke session
            session(['admin_id' => $admin->id, 'admin_username' => $admin->username, 'admin_role' => $admin->role]);
            return redirect()->route('home')->with('success', 'Login berhasil!');
        }
        return back()->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        //hapus session
        session()->forget(['admin_id', 'admin_username', 'admin_role']);
        return redirect()->route('landing')->with('success', 'Logout berhasil!');
    }

    public function formRegister()
    {
        return view('register');
    }

    public function prosesRegister(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:50|unique:dataadmin,username',
                'nama' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'role' => 'required|string|in:admin,guru,siswa',
            ]);
            
            $admin = admin::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
            
            // Create corresponding guru or siswa record based on role
            if ($request->role === 'guru') {
                \App\Models\guru::create([
                    'id' => $admin->id,
                    'nama' => $request->nama,
                    'mapel' => 'Belum ditentukan' // Default value
                ]);
            } elseif ($request->role === 'siswa') {
                \App\Models\siswa::create([
                    'id' => $admin->id,
                    'nama' => $request->nama,
                    'tb' => $request->tb ?? 0,
                    'bb' => $request->bb ?? 0
                ]);
            }
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }
}
