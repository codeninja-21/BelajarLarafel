<?php

namespace App\Services;

use App\Repositories\KelasRepository;

class KelasService
{
    protected $repo;

    public function __construct(KelasRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get available students (not in any class)
     */
    public function getAvailableSiswa()
    {
        return $this->repo->getAvailableSiswa();
    }

    /**
     * Create a new kelas entry
     */
    public function createKelas(array $data)
    {
        // Check if student is already in a class
        if ($this->repo->isStudentInClass($data['idsiswa'])) {
            throw new \Exception('Siswa sudah terdaftar di kelas lain');
        }

        return $this->repo->create($data);
    }

    /**
     * Delete a kelas entry
     */
    public function deleteKelas($id)
    {
        return $this->repo->delete($id);
    }

    /**
     * Get walas by ID
     */
    public function getWalasById($idwalas)
    {
        return $this->repo->getWalasById($idwalas);
    }
}
