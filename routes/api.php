<?php

use App\Http\Controllers\Api\v1\PositionController;
use App\Http\Controllers\Api\v1\TokenController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/token', TokenController::class)->name('getToken');
    Route::get('/users/{id}', [UserController::class, 'getUser']);
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::get('/positions', PositionController::class);
    Route::post('/create', [UserController::class, 'createUser']);
});
