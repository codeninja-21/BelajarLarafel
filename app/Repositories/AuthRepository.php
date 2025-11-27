<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    /**
     * Find admin by username
     */
    public function findByUsername(string $username)
    {
        return Admin::where('username', $username)->first();
    }

    /**
     * Create new admin with role-specific data
     */
    public function register(array $data)
    {
        // Create admin account
        $admin = Admin::create([
            'username' => $data['username'],
            'nama' => $data['nama'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);

        // Create corresponding guru or siswa record based on role
        if ($data['role'] === 'guru') {
            Guru::create([
                'id' => $admin->id,
                'nama' => $data['nama'],
                'mapel' => 'Belum ditentukan' // Default value
            ]);
        } elseif ($data['role'] === 'siswa') {
            Siswa::create([
                'id' => $admin->id,
                'nama' => $data['nama'],
                'tb' => $data['tb'] ?? 0,
                'bb' => $data['bb'] ?? 0
            ]);
        }

        return $admin;
    }

    /**
     * Verify password
     */
    public function verifyPassword(string $password, string $hashedPassword): bool
    {
        return Hash::check($password, $hashedPassword);
    }
}
