<?php

namespace App\Services;

use App\Repositories\KbmRepository;

class KbmService
{
    protected $repo;

    public function __construct(KbmRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Get KBM data based on user role
     */
    public function getKbmByRole($userRole, $adminId)
    {
        return $this->repo->getByRole($userRole, $adminId);
    }

    /**
     * Search KBM with filters
     */
    public function searchKbm($userRole, $adminId, $keyword = null, $hari = null)
    {
        return $this->repo->search($userRole, $adminId, $keyword, $hari);
    }

    /**
     * Get user data for KBM view
     */
    public function getUserDataForKbm($userRole, $adminId)
    {
        return $this->repo->getUserData($userRole, $adminId);
    }
}
