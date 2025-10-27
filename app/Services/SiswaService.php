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
}
