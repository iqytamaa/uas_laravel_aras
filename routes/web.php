<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AraCriteriaController;
use App\Http\Controllers\AraAlternativeController;
use App\Http\Controllers\AraEvaluationController;
use App\Http\Controllers\DssController;
use App\Http\Controllers\PublicCriteriaController;
use App\Http\Controllers\PublicAlternativeController;
use App\Http\Controllers\PublicEvaluationController;
use App\Http\Controllers\PublicResultController;
use App\Http\Controllers\CaptchaController;


/*
|--------------------------------------------------------------------------
| Root & Auth Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman user publik
Route::get('/', fn() => redirect()->route('user.home'));

// Register
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Login & Logout
Route::get('/auth/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Public Routes (User tanpa login)
|--------------------------------------------------------------------------
*/

Route::prefix('user')->name('user.')->group(function () {
    Route::view('/', 'public.welcome')->name('home');

    Route::get('criteria', [PublicCriteriaController::class, 'index'])->name('criteria.index');
    Route::get('alternatives', [PublicAlternativeController::class, 'index'])->name('alternatives.index');
    Route::get('evaluation', [PublicEvaluationController::class, 'showForm'])->name('evaluation.index');
    Route::post('evaluation', [PublicEvaluationController::class, 'submit'])->name('evaluation.submit');
    Route::get('results', [PublicResultController::class, 'index'])->name('results.index');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Hanya bisa diakses setelah login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Halaman utama setelah login
    Route::get('/home', function () {
        return view('admin.home', [
            'criterias' => \App\Models\AraCriteria::all()
        ]);
    })->name('home');

    // CRUD Kriteria
    Route::resource('criteria', AraCriteriaController::class);

    // CRUD Alternatif
    Route::resource('alternatives', AraAlternativeController::class);

    // Evaluasi Alternatif
    Route::get('evaluation', [AraEvaluationController::class, 'index'])->name('evaluation.index');
    Route::put('evaluation', [AraEvaluationController::class, 'update'])->name('evaluation.update');
    Route::delete('evaluation/{id}', [AraEvaluationController::class, 'destroy'])->name('evaluation.destroy');

    // Hasil perhitungan SPK metode ARAS
    Route::get('calculate', [DssController::class, 'calculate'])->name('calculate');
});

