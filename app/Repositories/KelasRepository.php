<?php

namespace App\Repositories;

use App\Models\Kelas;
use App\Models\Walas;
use App\Models\Siswa;

class KelasRepository
{
    /**
     * Get students not in any class
     */
    public function getAvailableSiswa()
    {
        return Siswa::whereNotIn('idsiswa', function($query) {
            $query->select('idsiswa')->from('datakelas');
        })->get();
    }

    /**
     * Check if student is already in a class
     */
    public function isStudentInClass($idsiswa)
    {
        return Kelas::where('idsiswa', $idsiswa)->exists();
    }

    /**
     * Create a new kelas entry
     */
    public function create(array $data)
    {
        return Kelas::create($data);
    }

    /**
     * Delete a kelas entry
     */
    public function delete($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();
        return $kelas->idwalas;
    }

    /**
     * Get walas by ID
     */
    public function getWalasById($idwalas)
    {
        return Walas::findOrFail($idwalas);
    }
}
