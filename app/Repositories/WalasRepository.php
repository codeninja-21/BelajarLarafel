<?php

namespace App\Repositories;

use App\Models\Walas;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class WalasRepository
{
    /**
     * Get all walas with relationships
     */
    public function getAll()
    {
        return Walas::with(['guru', 'siswa'])->get();
    }

    /**
     * Get available gurus (not yet walas)
     */
    public function getAvailableGurus()
    {
        return Guru::whereNotIn('idguru', function($query) {
            $query->select('idguru')->from('datawalas');
        })->get();
    }

    /**
     * Get available siswa (not in any class)
     */
    public function getAvailableSiswa()
    {
        return Siswa::whereNotIn('idsiswa', function($query) {
            $query->select('idsiswa')->from('datakelas');
        })->get();
    }

    /**
     * Create new walas
     */
    public function create(array $data)
    {
        return Walas::create($data);
    }

    /**
     * Update walas
     */
    public function update(Walas $walas, array $data)
    {
        $walas->update($data);
        return $walas;
    }

    /**
     * Delete walas with transaction
     */
    public function delete(Walas $walas)
    {
        DB::beginTransaction();
        
        try {
            // First, delete related kelas records
            $walas->kelas()->delete();
            
            // Then delete the walas
            $walas->delete();
            
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
