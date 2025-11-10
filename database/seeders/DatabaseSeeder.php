<?php

namespace Database\Seeders;

// Tambahkan baris ini untuk mengimpor model Admin dan siswa
use App\Models\admin;
use App\Models\siswa;
use App\Models\guru;
use App\Models\kbm;
use App\Models\konten;
use App\Models\Article;
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
        $gurus = guru::factory(25)->create();
        $siswas = siswa::factory(25)->create();

        konten::factory(5)->create();

        // Articles
        Article::create([
            'title' => 'Pengenalan Laravel Framework',
            'content' => 'Laravel adalah framework PHP yang populer untuk pengembangan web. Framework ini menyediakan berbagai fitur seperti routing, middleware, eloquent ORM, dan banyak lagi yang memudahkan developer dalam membangun aplikasi web modern.',
            'slug' => 'pengenalan-laravel-framework',
            'is_published' => true
        ]);

        Article::create([
            'title' => 'Belajar Database Migration',
            'content' => 'Migration adalah fitur Laravel yang memungkinkan kita untuk mengelola struktur database dengan mudah. Dengan migration, kita dapat membuat, mengubah, atau menghapus tabel database menggunakan kode PHP.',
            'slug' => 'belajar-database-migration',
            'is_published' => true
        ]);

        Article::create([
            'title' => 'Eloquent ORM untuk Pemula',
            'content' => 'Eloquent adalah ORM (Object-Relational Mapping) bawaan Laravel yang memudahkan interaksi dengan database. Dengan Eloquent, kita dapat melakukan operasi database menggunakan sintaks yang lebih intuitif dan object-oriented.',
            'slug' => 'eloquent-orm-untuk-pemula',
            'is_published' => true
        ]);

        Article::create([
            'title' => 'Membuat API dengan Laravel',
            'content' => 'Laravel menyediakan tools yang powerful untuk membuat RESTful API. Dengan fitur seperti API Resources, Route Model Binding, dan authentication menggunakan Sanctum atau Passport, membuat API menjadi lebih mudah.',
            'slug' => 'membuat-api-dengan-laravel',
            'is_published' => true
        ]);

        Article::create([
            'title' => 'Tips Optimasi Performa Laravel',
            'content' => 'Untuk meningkatkan performa aplikasi Laravel, ada beberapa teknik yang bisa diterapkan seperti caching, eager loading, query optimization, menggunakan queue untuk task yang berat, dan konfigurasi server yang tepat.',
            'slug' => 'tips-optimasi-performa-laravel',
            'is_published' => true
        ]);

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
        kbm::factory(25)->create();
    }
}
