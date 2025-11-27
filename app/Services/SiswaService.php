<?php

namespace App\Services;

use App\Repositories\SiswaRepository;

class SiswaService
{
    protected $repo;

    /**
     * Constructor to inject SiswaRepository
     */
    public function __construct(SiswaRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Create a new siswa
     */
    public function createSiswa(array $data)
    {
        return $this->repo->create($data);
    }

    /**
     * Update siswa data
     */
    public function updateSiswa($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    /**
     * Delete siswa
     */
    public function deleteSiswa($id)
    {
        return $this->repo->delete($id);
    }

    /**
     * Get siswa by ID
     */
    public function getSiswaById($id)
    {
        return $this->repo->findById($id);
    }
}
