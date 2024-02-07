<?php

use App\Http\Controllers\UserFrontController;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $users = User::query()->whereNot('email', 'admin@admin.com')->paginate(6);
    return view('index', compact('users'));
})->name('users');

Route::post('/create', [UserFrontController::class, 'createUser'])->name('store');

Route::get('/create', function () {
    $positions = Position::query()->pluck('position', 'id')->toArray();
    return view('create', compact('positions'));
})->name('create');

Route::get('/docs/api-specification-yaml', function () {
    return response()->file(base_path('/docs/api_specification.yaml'));
});

Route::get('/docs/api-specification-json', function () {
    return response()->file(base_path('/docs/api_specification.json'));
});
