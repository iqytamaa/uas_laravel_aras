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

/*
|--------------------------------------------------------------------------
| Root & Auth Routes
|--------------------------------------------------------------------------
*/

// Root → langsung ke halaman publik /user
Route::get('/', fn() => redirect()->route('user.home'));

// Registrasi
Route::get('/register', [AuthController::class, 'showRegistrationForm'])
     ->name('register');
Route::post('/register', [AuthController::class, 'register'])
     ->name('register.submit');

// Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])
     ->name('login');
Route::post('/login', [AuthController::class, 'login'])
     ->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])
     ->name('logout');


/*
|--------------------------------------------------------------------------
| Public Routes (User tanpa login)
|--------------------------------------------------------------------------
| URL prefix: /user
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->group(function () {
    // Landing page publik
    Route::view('/', 'public.welcome')->name('home');

    // Daftar Kriteria
    Route::get('criteria', [PublicCriteriaController::class, 'index'])
         ->name('criteria.index');

    // Daftar Alternatif
    Route::get('alternatives', [PublicAlternativeController::class, 'index'])
         ->name('alternatives.index');

    // Form input evaluasi oleh user
    Route::get('evaluation', [PublicEvaluationController::class, 'showForm'])
         ->name('evaluation.index');
    Route::post('evaluation', [PublicEvaluationController::class, 'submit'])
         ->name('evaluation.submit');

    // Lihat hasil perhitungan oleh user
    Route::get('results', [PublicResultController::class, 'index'])
         ->name('results.index');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (harus login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard / Home Admin
    Route::get('/home', function () {
        $criterias = \App\Models\AraCriteria::all();
        return view('admin.home', compact('criterias'));
    })->name('home');

    // CRUD Kriteria (admin)
    Route::resource('criteria', AraCriteriaController::class);

    // CRUD Alternatif (admin)
    Route::resource('alternatives', AraAlternativeController::class);

    // Evaluasi: index, update, delete (admin)
    Route::get('evaluation', [AraEvaluationController::class, 'index'])
         ->name('evaluation.index');
    Route::put('evaluation', [AraEvaluationController::class, 'update'])
         ->name('evaluation.update');
    Route::delete('evaluation/{id}', [AraEvaluationController::class, 'destroy'])
         ->name('evaluation.destroy');

    // Hasil perhitungan DSS (admin)
    Route::get('calculate', [DssController::class, 'calculate'])
         ->name('calculate');
});
    