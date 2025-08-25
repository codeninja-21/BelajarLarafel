<?php

namespace Database\Seeders;

// Tambahkan baris ini untuk mengimpor model Admin dan siswa
use App\Models\admin;
use App\Models\siswa;
use App\Models\guru;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil factory dengan nama model yang benar
        // Admin::factory()->create();
        admin::factory()->dataadmin1()->create();
        admin::factory()->dataadmin2()->create();
        siswa::factory()->count(5)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        siswa::factory()->count(15)->create();
        guru::factory()->count(5)->create();
    }
}
