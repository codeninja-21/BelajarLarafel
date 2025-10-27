<?php

namespace App\Http\Controllers;

use App\Models\kbm;
use App\Models\guru;
use App\Models\Walas;
use App\Models\siswa;
use Illuminate\Http\Request;

class kbmController extends Controller
{
    /**
     * Display KBM schedules based on user role.
     */
    public function index()
    {
        $userRole = session('admin_role');
        $adminId = session('admin_id');
        $username = session('admin_username');
        
        $viewData = compact('userRole', 'username');

        if ($userRole === 'admin') {
            return view('kbm.admin', $viewData);
            
        } elseif ($userRole === 'guru') {
            // Guru only sees their own teaching schedule
            $userData = guru::with(['kbm.walas'])->where('id', $adminId)->first();
            
            if (!$userData) {
                return redirect()->route('home')->with('error', 'Data guru tidak ditemukan.');
            }
            
            $viewData['guru'] = $userData;
            return view('kbm.guru', $viewData);
            
        } elseif ($userRole === 'siswa') {
            // Siswa sees their class schedule
            $userData = siswa::with(['kelas.walas.kbm.guru'])->where('id', $adminId)->first();
            
            if (!$userData) {
                return redirect()->route('home')->with('error', 'Data siswa tidak ditemukan.');
            }
            
            $viewData['siswa'] = $userData;
            return view('kbm.siswa', $viewData);
        }

        return redirect()->route('home')->with('error', 'Role tidak dikenali.');
    }
    
    /**
     * Get KBM data via AJAX
     */
    public function getData()
    {
        $userRole = session('admin_role');
        $adminId = session('admin_id');
        
        if ($userRole === 'admin') {
            $jadwals = kbm::with(['guru', 'walas'])->get();
            return response()->json($jadwals);
            
        } elseif ($userRole === 'guru') {
            $guru = guru::with(['kbm.walas'])->where('id', $adminId)->first();
            if ($guru) {
                return response()->json($guru->kbm);
            }
            return response()->json([]);
            
        } elseif ($userRole === 'siswa') {
            $siswa = siswa::with(['kelas.walas.kbm.guru'])->where('id', $adminId)->first();
            $jadwals = collect();
            
            if ($siswa && $siswa->kelas) {
                foreach ($siswa->kelas as $kelas) {
                    if ($kelas->walas && $kelas->walas->kbm) {
                        $jadwals = $jadwals->merge($kelas->walas->kbm);
                    }
                }
            }
            return response()->json($jadwals);
        }
        
        return response()->json([]);
    }
    
    /**
     * Search and filter KBM data
     */
    public function search(Request $request)
    {
        $userRole = session('admin_role');
        $adminId = session('admin_id');
        $keyword = strtolower($request->input('q'));
        $hari = $request->input('hari');
        
        $query = kbm::with(['guru', 'walas']);
        
        if ($userRole === 'guru') {
            $query->where('idguru', $adminId);
        } elseif ($userRole === 'siswa') {
            $siswa = siswa::with(['kelas.walas'])->where('id', $adminId)->first();
            if ($siswa && $siswa->kelas) {
                $walasIds = $siswa->kelas->pluck('idwalas')->toArray();
                $query->whereIn('idwalas', $walasIds);
            } else {
                return response()->json([]);
            }
        }
        
        // Apply search filter
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->whereHas('guru', function($guruQuery) use ($keyword) {
                    $guruQuery->whereRaw('LOWER(nama) LIKE ?', ["%{$keyword}%"])
                              ->orWhereRaw('LOWER(mapel) LIKE ?', ["%{$keyword}%"]);
                })
                ->orWhereRaw('LOWER(hari) LIKE ?', ["%{$keyword}%"]);
            });
        }
        
        // Apply day filter
        if ($hari && $hari !== 'all') {
            $query->where('hari', $hari);
        }
        
        $jadwals = $query->get();
        return response()->json($jadwals);
    }
}
