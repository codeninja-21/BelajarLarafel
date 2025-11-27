<?php

namespace App\Repositories;

use App\Models\kbm;
use App\Models\guru;
use App\Models\siswa;

class KbmRepository
{
    /**
     * Get KBM data by user role
     */
    public function getByRole($userRole, $adminId)
    {
        if ($userRole === 'admin') {
            return kbm::with(['guru', 'walas'])->get();
        } elseif ($userRole === 'guru') {
            $guru = guru::with(['kbm.walas'])->where('id', $adminId)->first();
            return $guru ? $guru->kbm : collect();
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
            return $jadwals;
        }
        
        return collect();
    }

    /**
     * Search KBM with filters
     */
    public function search($userRole, $adminId, $keyword = null, $hari = null)
    {
        $query = kbm::with(['guru', 'walas']);
        
        // Apply role-based filtering
        if ($userRole === 'guru') {
            $query->where('idguru', $adminId);
        } elseif ($userRole === 'siswa') {
            $siswa = siswa::with(['kelas.walas'])->where('id', $adminId)->first();
            if ($siswa && $siswa->kelas) {
                $walasIds = $siswa->kelas->pluck('idwalas')->toArray();
                $query->whereIn('idwalas', $walasIds);
            } else {
                return collect();
            }
        }
        
        // Apply keyword search
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
        
        return $query->get();
    }

    /**
     * Get user data for KBM view
     */
    public function getUserData($userRole, $adminId)
    {
        if ($userRole === 'guru') {
            return guru::with(['kbm.walas'])->where('id', $adminId)->first();
        } elseif ($userRole === 'siswa') {
            return siswa::with(['kelas.walas.kbm.guru'])->where('id', $adminId)->first();
        }
        
        return null;
    }
}
