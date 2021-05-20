<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authorization;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/', [UserController::class, 'index']);
Route::post('/users/auth_check', [UserController::class, 'session']);
Route::post('/users/', [UserController::class, 'create']);
Route::get('/users/{id}', [UserController::class, 'get'])->middleware(Authorization::class);

Route::get('/persons')


