<?php

use App\Http\Controllers\Api\v1\PositionController;
use App\Http\Controllers\Api\v1\TokenController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/token', TokenController::class)->name('getToken');
    Route::get('/users/{id}', [UserController::class, 'getUser']);
    Route::get('/users', [UserController::class, 'getUsers']);
    Route::get('/positions', PositionController::class);
    Route::post('/create', [UserController::class, 'createUser']);
});
