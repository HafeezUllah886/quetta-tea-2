<?php

use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\StockController;
use App\Http\Middleware\adminCheck;
use App\Http\Middleware\AdminStorekeeperCheck;
use App\Http\Middleware\confirmPassword;
use Illuminate\Support\Facades\Route;

Route::middleware('auth', AdminStorekeeperCheck::class)->group(function () {

    Route::get('material/stock/{id}/{unit}/{from}/{to}', [StockController::class, 'show'])->name('stockDetails');
    Route::resource('stock', StockController::class);

    Route::resource('stockAdjustments', StockAdjustmentController::class);
    Route::get('stockAdjustment/delete/{ref}', [StockAdjustmentController::class, 'destroy'])->name('stockAdjustment.delete')->middleware(confirmPassword::class);

});

