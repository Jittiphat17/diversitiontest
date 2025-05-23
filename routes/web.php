<?php

use App\Http\Controllers\LottoController;
use Illuminate\Support\Facades\Route;

Route::get('/lotto', [LottoController::class, 'index'])->name('lotto.index');
Route::post('/lotto/draw', [LottoController::class, 'draw'])->name('lotto.draw');
Route::post('/lotto/check', [LottoController::class, 'check'])->name('lotto.check');