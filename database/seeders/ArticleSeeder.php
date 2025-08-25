<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'title' => 'Selamat Datang di Website Kami',
            'content' => 'Ini adalah artikel pertama di website kami. Website ini dibuat menggunakan Laravel dan MySQL untuk mengelola data artikel dan pengguna. Anda dapat membaca artikel-artikel menarik di sini dan jika Anda adalah admin, Anda dapat menambahkan artikel baru.',
            'is_published' => true
        ]);

        Article::create([
            'title' => 'Tutorial Laravel untuk Pemula',
            'content' => 'Laravel adalah framework PHP yang sangat populer untuk pengembangan web. Framework ini menyediakan berbagai fitur yang memudahkan developer dalam membangun aplikasi web yang robust dan scalable. Dalam artikel ini, kita akan membahas dasar-dasar Laravel mulai dari instalasi hingga pembuatan aplikasi sederhana.',
            'is_published' => true
        ]);

        Article::create([
            'title' => 'Tips Menggunakan MySQL dengan Efektif',
            'content' => 'MySQL adalah salah satu database management system yang paling banyak digunakan. Untuk mengoptimalkan performa database, ada beberapa tips yang bisa diterapkan seperti penggunaan index yang tepat, optimasi query, dan normalisasi database. Artikel ini akan membahas berbagai strategi untuk menggunakan MySQL secara efektif.',
            'is_published' => true
        ]);

        Article::create([
            'title' => 'Keamanan Web: Best Practices',
            'content' => 'Keamanan web adalah aspek yang sangat penting dalam pengembangan aplikasi. Beberapa praktik terbaik yang harus diterapkan meliputi validasi input, penggunaan HTTPS, implementasi authentication dan authorization yang proper, serta perlindungan terhadap serangan seperti SQL injection dan XSS.',
            'is_published' => true
        ]);

        Article::create([
            'title' => 'Masa Depan Teknologi Web',
            'content' => 'Teknologi web terus berkembang dengan pesat. Tren terbaru seperti Progressive Web Apps (PWA), Single Page Applications (SPA), dan teknologi cloud computing mengubah cara kita membangun dan menggunakan aplikasi web. Artikel ini membahas tren teknologi web yang akan mendominasi masa depan.',
            'is_published' => true
        ]);
    }
}
