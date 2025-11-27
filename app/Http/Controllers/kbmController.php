<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KbmService;

class kbmController extends Controller
{
    protected $service;

    public function __construct(KbmService $service)
    {
        $this->service = $service;
    }

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
            $userData = $this->service->getUserDataForKbm($userRole, $adminId);
            
            if (!$userData) {
                return redirect()->route('home')->with('error', 'Data guru tidak ditemukan.');
            }
            
            $viewData['guru'] = $userData;
            return view('kbm.guru', $viewData);
            
        } elseif ($userRole === 'siswa') {
            $userData = $this->service->getUserDataForKbm($userRole, $adminId);
            
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
        
        $jadwals = $this->service->getKbmByRole($userRole, $adminId);
        return response()->json($jadwals);
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
        
        $jadwals = $this->service->searchKbm($userRole, $adminId, $keyword, $hari);
        return response()->json($jadwals);
    }
}
