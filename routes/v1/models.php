<?php

use App\Http\Controllers\Api\ModelFilteredController;
use Illuminate\Support\Facades\Route;

Route::get('filtered', [ModelFilteredController::class, 'filtered']);
