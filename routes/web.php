<?php

use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;

// 診断トップ
Route::get('/', [DiagnosisController::class, 'index'])->name('diagnosis.index');

// スコア計算API
Route::post('/api/diagnosis/calculate', [DiagnosisController::class, 'calculate'])->name('diagnosis.calculate');

// 更新履歴
Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
