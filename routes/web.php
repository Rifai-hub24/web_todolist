<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TugasController;

// Routes untuk autentikasi
Auth::routes();

// Routes untuk CRUD tugas, hanya dapat diakses oleh pengguna yang sudah login
Route::middleware('auth')->group(function () {
    // Arahkan halaman utama ke daftar tugas
    Route::get('/', [TugasController::class, 'index']);

    // CRUD tugas menggunakan resource controller
    Route::resource('tugas', TugasController::class)->parameters([
        'tugas' => 'tugas'
    ]);
    Route::patch('/tugas/{id}/update-status', [TugasController::class, 'updateStatus']);
});
