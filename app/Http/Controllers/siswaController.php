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
        $userRole = session('admin_role');
        $adminId = session('admin_id');
        $username = session('admin_username');
        
        $userData = null;
        $siswa = collect(); // Initialize as empty collection
        $isWalas = false;
        
        if ($userRole === 'guru') {
            $userData = guru::with('walas.kelas.siswa')->where('id', $adminId)->first();
            
            // Check if this teacher is a walas
            if ($userData && $userData->walas) {
                $isWalas = true;
                // Only show students from this walas's class
                $siswa = siswa::whereHas('kelas', function($query) use ($userData) {
                    $query->where('idwalas', $userData->walas->idwalas);
                })->get();
            }
            // If not walas, siswa remains empty collection
        } elseif ($userRole === 'siswa') {
            $userData = siswa::where('id', $adminId)->first();
        } elseif ($userRole === 'admin') {
            // Admin can see all students
            $siswa = siswa::all();
        }
        
        return view('home', compact('siswa', 'userRole', 'username', 'userData', 'isWalas'));
    }

    public function create()
    {
        // Only admin can create students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menambah siswa.');
        }
        
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        // Only admin can store students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menambah siswa.');
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
        // Only admin can edit students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk mengedit siswa.');
        }
        
        $siswa = siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        // Only admin can update students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk mengupdate siswa.');
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
        // Only admin can delete students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menghapus siswa.');
        }
        
        $siswa = siswa::findOrFail($id);
        $siswa->delete();
        return redirect()->route('home')->with('success', 'Data siswa berhasil dihapus.');
    }
}
