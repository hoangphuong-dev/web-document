<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/ping', function () {
    return 'pong';
});

Route::prefix('v1')
    ->group(function () {
        Route::prefix('document')->name('document.')->group(base_path('routes/v1/document.php'));
        Route::prefix('models')->group(base_path('routes/v1/models.php'));
    });
