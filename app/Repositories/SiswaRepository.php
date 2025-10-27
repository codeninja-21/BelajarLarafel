<?php

namespace App\Repositories;

use App\Models\Siswa;
use App\Models\Admin;

class SiswaRepository
{
    /**
     * Create a new siswa with admin account
     */
    public function create(array $data)
    {
        // Create admin account for siswa
        $admin = Admin::create([
            'username' => $data['nama'],
            'password' => bcrypt($data['nama']),
            'role' => 'siswa',
        ]);

        // Create siswa record
        $siswa = Siswa::create([
            'id' => $admin->id,
            'nama' => $data['nama'],
            'tb' => $data['tb'],
            'bb' => $data['bb'],
        ]);

        return $siswa;
    }
}
