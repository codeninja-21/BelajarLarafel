<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\siswa;
use App\Models\guru;
use App\Models\admin;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Services\SiswaService;

class siswaController extends Controller
{
    protected $service;

    /**
     * Constructor to inject SiswaService
     */
    public function __construct(SiswaService $service)
    {
        $this->service = $service;
    }
    public function home()
    {
        $userRole = session('admin_role');
        $adminId = session('admin_id');
        $username = session('admin_username');
        
        $userData = null;
        $isWalas = false;
        
        if ($userRole === 'guru') {
            $userData = guru::with('walas.kelas.siswa')->where('id', $adminId)->first();
            $isWalas = $userData && $userData->walas ? true : false;
        } elseif ($userRole === 'siswa') {
            $userData = siswa::with('kelas.walas.guru')->where('id', $adminId)->first();
        }
        
        return view('home', compact('userRole', 'username', 'userData', 'isWalas'));
    }
    
    public function getData()
    {
        $userRole = session('admin_role');
        $adminId = session('admin_id');
        
        if ($userRole === 'guru') {
            $guru = guru::with('walas.kelas.siswa')->where('id', $adminId)->first();
            
            if ($guru && $guru->walas) {
                // Only show students from this walas's class
                $siswa = siswa::whereHas('kelas', function($query) use ($guru) {
                    $query->where('idwalas', $guru->walas->idwalas);
                })->get();
                return response()->json($siswa);
            }
            return response()->json([]);
        } elseif ($userRole === 'admin') {
            $siswa = siswa::all();
            return response()->json($siswa);
        }
        
        return response()->json([]);
    }
    
    public function search(Request $request)
    {
        $keyword = strtolower($request->input('q'));
        $userRole = session('admin_role');
        $adminId = session('admin_id');
        
        $query = siswa::query();
        
        if ($userRole === 'guru') {
            $guru = guru::with('walas.kelas.siswa')->where('id', $adminId)->first();
            
            if ($guru && $guru->walas) {
                $query->whereHas('kelas', function($q) use ($guru) {
                    $q->where('idwalas', $guru->walas->idwalas);
                });
            } else {
                return response()->json([]);
            }
        }
        
        $siswa = $query->whereRaw('LOWER(nama) LIKE ?', ["%{$keyword}%"])
                      ->get();
                      
        return response()->json($siswa);
    }

    public function create()
    {
        // Only admin can create students
        
        
        return view('siswa.create');
    }

    public function store(StoreSiswaRequest $request)
    {
        // Only admin can store students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menambah siswa.');
        }
        
        $this->service->createSiswa($request->validated());
        return redirect()->route('home')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Only admin can edit students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk mengedit siswa.');
        }
        
        $siswa = $this->service->getSiswaById($id);
        return view('siswa.edit', compact('siswa'));
    }

    public function update(UpdateSiswaRequest $request, $id)
    {
        // Only admin can update students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk mengupdate siswa.');
        }
        
        $this->service->updateSiswa($id, $request->validated());
        return redirect()->route('home')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Only admin can delete students
        if (session('admin_role') !== 'admin') {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses untuk menghapus siswa.');
        }
        
        $this->service->deleteSiswa($id);
        return redirect()->route('home')->with('success', 'Data siswa berhasil dihapus.');
    }
}
