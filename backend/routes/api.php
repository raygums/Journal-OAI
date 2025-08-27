<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Admin\JournalController as AdminJournalController; 

// RUTE PUBLIK HANYA UNTUK LOGIN
Route::post('/login', [AuthController::class, 'login']);

// RUTE YANG DILINDUNGI (MEMERLUKAN LOGIN/TOKEN)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) { return $request->user(); });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Semua rute untuk pengelolaan jurnal
    Route::get('/journals', [JournalController::class, 'index']);
    Route::post('/journals', [JournalController::class, 'store']);
    Route::get('/journals/{journal}', [JournalController::class, 'show']);
    Route::put('/journals/{journal}', [JournalController::class, 'update']);
    Route::patch('/journals/{journal}/submit', [JournalController::class, 'submitForApproval']);
    
    // Rute untuk Pengelola meminta izin edit pada jurnal yang sudah publish
    Route::patch('/journals/{journal}/request-edit', [JournalController::class, 'requestEditApproval']);

    // --- RUTE CRUD LENGKAP UNTUK ADMIN ---
    // `apiResource` akan membuat:
    // GET /admin/users -> index() (Mengambil semua pengguna)
    // POST /admin/users -> store() (Membuat pengguna baru)
    // GET /admin/users/{user} -> show() (Mengambil satu pengguna)
    // PUT/PATCH /admin/users/{user} -> update() (Memperbarui pengguna)
    // DELETE /admin/users/{user} -> destroy() (Menghapus pengguna)
    Route::apiResource('/admin/users', AdminUserController::class);

    // --- RUTE UNTUK MANAJEMEN JURNAL OLEH ADMIN ---
Route::prefix('admin')->group(function () {
    // Mengambil semua jurnal (untuk ditampilkan di dashboard admin)
    Route::get('/journals', [AdminJournalController::class, 'index']);
    // Memperbarui jurnal (untuk verifikasi, mengisi OAI, dll)
    Route::put('/journals/{journal}', [AdminJournalController::class, 'update']);
    // Menghapus jurnal
    Route::delete('/journals/{journal}', [AdminJournalController::class, 'destroy']);
    // Rute untuk Admin menyetujui permintaan edit
    Route::patch('/journals/{journal}/approve-edit', [AdminJournalController::class, 'approveEditRequest']);
    });
});