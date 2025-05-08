<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AraAlternativeController;
use App\Http\Controllers\AraCriteriaController;
use App\Http\Controllers\AraEvaluationController;
use App\Http\Controllers\DssController;
use Illuminate\Support\Facades\Route;

// Root diarahkan ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Registrasi (bisa diakses tanpa login)
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Login dan logout (bisa diakses tanpa login)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Semua route berikut hanya bisa diakses jika sudah login
Route::middleware('auth')->group(function () {

    // Halaman home, bisa kamu sesuaikan isinya
    Route::get('/home', function () {
        $criteria = \App\Models\AraCriteria::all();
        return view('home', ['criterias' => $criteria]);
    })->name('home');

    // Resource route untuk criteria (kriteria)
    Route::resource('criteria', AraCriteriaController::class);

    // Resource route untuk alternatives (alternatif)
    Route::resource('alternatives', AraAlternativeController::class);

    // Halaman alternatif (bisa juga pakai controller)
    Route::get('/alternative', function () {
        $alternative = \App\Models\AraAlternative::all();
        return view('alternative', ['alternatives' => $alternative]);
    })->name('alternative.index');

    // Halaman evaluasi
    Route::get('/evaluation', function () {
        $evaluation = \App\Models\AraEvaluation::all();
        $criteria = \App\Models\AraCriteria::all();
        $alternative = \App\Models\AraAlternative::all();
        return view('evaluation', [
            'evaluations' => $evaluation,
            'criterias' => $criteria,
            'alternatives' => $alternative
        ]);
    })->name('evaluation.index');

    // Update evaluasi
    Route::put('/evaluations', [AraEvaluationController::class, 'update'])->name('evaluations.update');

    // Hasil perhitungan
    Route::get('/calculate', [DssController::class, 'calculate'])->name('dss.calculate');
});
