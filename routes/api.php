<?php

use App\Http\Controllers\Api\{ AuthController, UserController, AlumniController, JobVacancyController, NewsController, QuestionnaireController };
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\QuestionnaireManagementController;
use App\Http\Controllers\Api\QuestionOptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);
Route::get('/jobs', [JobVacancyController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- ALUMNI ROUTES ---
    Route::prefix('alumni')->group(function () {
        // Profil
        Route::get('/me', [AlumniController::class, 'me']);
        Route::post('/update', [AlumniController::class, 'update']);
        Route::get('/', [AlumniController::class, 'index']);

        // Kuesioner (Tracer Study)
        Route::get('/questionnaires', [QuestionnaireController::class, 'index']);
        Route::post('/questionnaires/submit', [QuestionnaireController::class, 'storeAnswers']);
        Route::get('/questionnaires/{id}/my-answers', [QuestionnaireController::class, 'myAnswers']);
    });

    // --- ADMIN ROUTES ---
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        // Statistik
        Route::get('/tracer-statistics', [QuestionnaireController::class, 'getStatistics']);

        /**
         * Master User (Menggunakan API Resource)
         * Baris tunggal ini otomatis menghasilkan 5 rute CRUD sekaligus untuk tabel users:
         * 1. GET    /api/admin/users          -> menampilkan semua user (index)
         * 2. POST   /api/admin/users          -> membuat user baru (store)
         * 3. GET    /api/admin/users/{id}     -> detail satu user (show)
         * 4. PUT    /api/admin/users/{id}     -> mengubah data user (update)
         * 5. DELETE /api/admin/users/{id}     -> menghapus user (destroy)
         */
        Route::apiResource('users', UserController::class);

        // Berita
        Route::post('/news', [NewsController::class, 'store']);
        Route::post('/news/{id}', [NewsController::class, 'update']);
        Route::delete('/news/{id}', [NewsController::class, 'destroy']);

        // Lowongan Kerja
        Route::post('/jobs', [JobVacancyController::class, 'store']);
        Route::post('/jobs/{id}', [JobVacancyController::class, 'update']);
        Route::delete('/jobs/{id}', [JobVacancyController::class, 'destroy']);

        // Paket Kuesioner Utama
        Route::get('/questionnaires', [QuestionnaireManagementController::class, 'index']);
        Route::post('/questionnaires', [QuestionnaireManagementController::class, 'store']);
        Route::get('/questionnaires/{id}', [QuestionnaireManagementController::class, 'show']);
        Route::put('/questionnaires/{id}', [QuestionnaireManagementController::class, 'update']);
        Route::delete('/questionnaires/{id}', [QuestionnaireManagementController::class, 'destroy']);
            
        // Butir Pertanyaan
        Route::get('/questions/{id}', [QuestionController::class, 'show']);
        Route::post('/questions', [QuestionController::class, 'store']);
        Route::put('/questions/{id}', [QuestionController::class, 'update']);
        Route::delete('/questions/{id}', [QuestionController::class, 'destroy']);
        Route::put('/questions/order', [QuestionController::class, 'updateOrder']);

        // Opsi Jawaban
        Route::post('/question-options', [QuestionOptionController::class, 'store']);
        Route::put('/question-options/{id}', [QuestionOptionController::class, 'update']);
        Route::delete('/question-options/{id}', [QuestionOptionController::class, 'destroy']);

        // Pengingat Kuesioner
        Route::post('/send-reminders', [NotificationController::class, 'broadcastReminder']);

        // Ekpor Hasil Jawaban ke Excel (Admin Only)
        Route::get('/questionnaires/{id}/export', [QuestionnaireManagementController::class, 'exportToExcel']);
    });
});