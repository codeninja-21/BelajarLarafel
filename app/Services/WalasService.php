<?php

namespace App\Services;

use App\Repositories\WalasRepository;
use App\Models\Walas;

class WalasService
{
    protected $repo;

    public function __construct(WalasRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get all walas
     */
    public function getAllWalas()
    {
        return $this->repo->getAll();
    }

    /**
     * Get available gurus
     */
    public function getAvailableGurus()
    {
        return $this->repo->getAvailableGurus();
    }

    /**
     * Get available siswa
     */
    public function getAvailableSiswa()
    {
        return $this->repo->getAvailableSiswa();
    }

    /**
     * Create new walas
     */
    public function createWalas(array $data)
    {
        return $this->repo->create($data);
    }

    /**
     * Update walas
     */
    public function updateWalas(Walas $walas, array $data)
    {
        return $this->repo->update($walas, $data);
    }

    /**
     * Delete walas
     */
    public function deleteWalas(Walas $walas)
    {
        return $this->repo->delete($walas);
    }
}
