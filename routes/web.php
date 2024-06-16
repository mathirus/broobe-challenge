<?php

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MetricHistoryRunController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MetricHistoryRunController::class, 'index'])->name('current-metrics');
Route::get('/history', [MetricHistoryRunController::class, 'history'])->name('history');

Route::prefix('metrics')->group(function () {
    Route::get('/fetch', [MetricHistoryRunController::class, 'fetchMetrics'])->name('metrics.fetch');
    Route::post('/save', [MetricHistoryRunController::class, 'saveMetrics'])->name('metrics.save');
    Route::get('/history/data', [MetricHistoryRunController::class, 'getMetricsHistory'])->name('metrics.history.data');
});

Route::get('/language/{locale}', [LanguageController::class, 'changeLanguage'])->name('language.change');
