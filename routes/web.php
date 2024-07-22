<?php

use App\Http\Controllers\AraAlternativeController;
use App\Http\Controllers\AraCriteriaController;
use App\Http\Controllers\AraEvaluationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DssController;
use App\Models\AraAlternative;
use App\Models\AraCriteria;
use App\Models\AraEvaluation;

Route::get('/', function () {
    $criteria = AraCriteria::all();
    return view('criteria', ['criterias' => $criteria]);
});

Route::get('/alternative', function () {
    $alternative = AraAlternative::all();
    return view('alternative', ['alternatives' => $alternative]);
});

Route::get('/evaluation', function () {
    $evaluation = AraEvaluation::all();
    $criteria = AraCriteria::all();
    $alternative = AraAlternative::all();
    return view('evaluation', ['evaluations' => $evaluation, 'criterias' => $criteria, 'alternatives' => $alternative]);
});

Route::put('/evaluations', [AraEvaluationController::class, 'update'])->name('evaluations.update');

Route::resource('criterias', AraCriteriaController::class);

Route::resource('alternatives', AraAlternativeController::class);

Route::get('/calculate', [DssController::class, 'calculate'])->name('dss.calculate');
