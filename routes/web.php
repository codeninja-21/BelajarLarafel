<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController; // Tambahkan baris ini
use App\Http\Controllers\siswaController; // Tambahkan baris ini
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\kbmController;




// Public routes
Route::get('/', [AdminController::class, 'landing'])->name('landing');
Route::get('/login', [AdminController::class, 'formLogin'])->name('login');
Route::post('/login', [AdminController::class, 'prosesLogin'])->name('login.post');
Route::get('/register', [adminController::class, 'formregister'])->name('register');
Route::post('/register', [adminController::class, 'prosesRegister'])->name('register.post');

// Protected routes - require login
Route::middleware(['ceklogin'])->group(function () {
    // Home
    Route::get('/home', [siswaController::class, 'home'])->name('home');
    
    // Siswa routes
    Route::get('/siswa/create', [siswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa/store', [siswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}/edit', [siswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/siswa/{id}/update', [siswaController::class, 'update'])->name('siswa.update');
    Route::get('/siswa/{id}/delete', [siswaController::class, 'destroy'])->name('siswa.delete');
    
    // Logout
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    
    // Article routes
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    
    // KBM routes - role-based access
    Route::get('/kbm', [kbmController::class, 'index'])->name('kbm.index');
});
