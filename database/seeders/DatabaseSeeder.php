<?php

namespace Database\Seeders;

// Tambahkan baris ini untuk mengimpor model Admin dan siswa
use App\Models\admin;
use App\Models\siswa;
use App\Models\guru;
use App\Models\kbm;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        admin::factory()->dataadmin1()->create();
        admin::factory()->dataadmin2()->create();

        // Guru dan Siswa
        $gurus = guru::factory(5)->create();
        $siswas = siswa::factory(25)->create();

        // Pilih 3 guru random untuk jadi walas
        $guruRandom = $gurus->random(3);
        foreach ($guruRandom as $guru) {
            \App\Models\Walas::factory()->create([
                'idguru' => $guru->idguru
            ]);
        }

        // Ambil semua walas
        $waliKelasIds = \App\Models\Walas::pluck('idwalas')->toArray();

        // Acak siswa
        $randomSiswas = $siswas->shuffle();

        // Bagi siswa ke kelompok sesuai jumlah walas
        $chunks = $randomSiswas->chunk(ceil($randomSiswas->count() / count($waliKelasIds)));
        foreach ($waliKelasIds as $index => $idwalas) {
            if (isset($chunks[$index])) {
                foreach ($chunks[$index] as $siswa) {
                    \App\Models\Kelas::create([
                        'idwalas' => $idwalas,
                        'idsiswa' => $siswa->idsiswa
                    ]);
                }
            }
        }

        // KBM
        kbm::factory(5)->create();
    }
}
