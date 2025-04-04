<?php

use App\Http\Controllers\Sepay\SePayController;
use Illuminate\Support\Facades\Route;

Route::prefix('sepay')
    ->name('sepay.')
    ->group(function () {
        // response trả về từ sepay
        Route::any('/response', [SePayController::class, 'processResponse'])->name('response');
    });
