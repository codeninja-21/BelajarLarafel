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
        if (!session()->has('admin_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = session('admin_role');
        $adminId = session('admin_id');
        $username = session('admin_username');
        
        $jadwals = collect();
        $viewData = compact('userRole', 'username');

        if ($userRole === 'admin') {
            // Admin can see all schedules
            $jadwals = kbm::with(['guru', 'walas'])->get();
            $viewData['jadwals'] = $jadwals;
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
            
            // Get all schedules from student's classes
            $jadwals = collect();
            if ($userData->kelas) {
                foreach ($userData->kelas as $kelas) {
                    if ($kelas->walas && $kelas->walas->kbm) {
                        $jadwals = $jadwals->merge($kelas->walas->kbm);
                    }
                }
            }
            
            $viewData['siswa'] = $userData;
            $viewData['jadwals'] = $jadwals;
            return view('kbm.siswa', $viewData);
        }

        return redirect()->route('home')->with('error', 'Role tidak dikenali.');
    }
}
