<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService
{
    protected $repo;

    public function __construct(AuthRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Attempt to login user
     */
    public function login(array $credentials)
    {
        $admin = $this->repo->findByUsername($credentials['username']);

        if ($admin && $this->repo->verifyPassword($credentials['password'], $admin->password)) {
            // Create session
            session([
                'admin_id' => $admin->id,
                'admin_username' => $admin->username,
                'admin_role' => $admin->role
            ]);
            return ['success' => true, 'admin' => $admin];
        }

        return ['success' => false, 'message' => 'Username atau password salah.'];
    }

    /**
     * Register new user
     */
    public function register(array $data)
    {
        return $this->repo->register($data);
    }

    /**
     * Logout user
     */
    public function logout()
    {
        session()->forget(['admin_id', 'admin_username', 'admin_role']);
    }
}
