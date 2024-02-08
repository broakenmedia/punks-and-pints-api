<?php

use App\Http\Controllers\Api\GetBeerController;
use App\Http\Controllers\Api\GetBeersController;
use App\Http\Controllers\Api\GetRandomBeerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user.get');
    Route::get('/beers', GetBeersController::class)->name('beers.index');
    Route::get('/beers/random', GetRandomBeerController::class)->name('beers.random');
    Route::get('/beers/{beerId}', GetBeerController::class)->name('beers.show');
});
