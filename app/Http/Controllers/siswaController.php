<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswa;
use App\Models\guru;
use App\Models\admin;

class siswaController extends Controller
{
    public function home()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $siswa = siswa::all();
        $userRole = session('admin_role');
        $adminId = session('admin_id');
        $username = session('admin_username');
        
        $userData = null;
        
        if ($userRole === 'guru') {
            $userData = guru::where('id', $adminId)->first();
        } elseif ($userRole === 'siswa') {
            $userData = siswa::where('id', $adminId)->first();
        }
        
        return view('home', compact('siswa', 'userRole', 'username', 'userData'));
    }

    public function create()
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'tb' => 'required|numeric|min:0',
            'bb' => 'required|numeric|min:0',
        ]);
        
        siswa::create($request->only('nama', 'tb', 'bb'));
        return redirect()->route('home')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $siswa = siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'tb' => 'required|numeric|min:0',
            'bb' => 'required|numeric|min:0',
        ]);
        
        $siswa = siswa::findOrFail($id);
        $siswa->update($request->only('nama', 'tb', 'bb'));
        return redirect()->route('home')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!session()->has('admin_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        $siswa = siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('home')->with('success', 'Data siswa berhasil dihapus.');
    }
}
