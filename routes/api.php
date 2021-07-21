<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\PositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authorization;
use App\Http\Middleware\Cors;
use App\Models\Position;

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

// User Endpoint
Route::get('/users', [UserController::class, 'index']);
Route::post('/users/auth_check', [UserController::class, 'session']);
Route::post('/users', [UserController::class, 'create']);
Route::get('/users/{id}', [UserController::class, 'get'])->middleware(Authorization::class);
Route::delete('/users/{id}', [UserController::class, 'delete'])->middleware(Authorization::class);

//Person Endpoint
Route::get('/persons', [PersonController::class, 'getAll']);
Route::put('/persons/{person_id}', [PersonController::class, 'update']);
Route::get('/persons/sick', [PersonController::class, 'getSickPerson']);
Route::get('/persons/{id}/tracing/', [PersonController::class, 'personTracing']);
Route::get('/persons/{id}', [PersonController::class, 'get']);
Route::get('/search/{query?}', [PersonController::class, 'getPersonByName']);
Route::get('persons/{id}/detail', [PersonController::class, 'getPersonDetail']);
Route::post('/persons', [PersonController::class, 'create']);
Route::delete('/persons/{id}', [PersonController::class, 'delete']);

Route::get('/persons/{id}/positions', [PositionController::class, 'getByUserId']);
Route::post('/persons/{person_id}/positions', [PositionController::class, 'create']);
Route::delete('persons/{person_id}/positions/{position_id}', [PositionController::class, 'delete']);
Route::get('persons/{person_id}/positions/{position_id}', [PositionController::class, 'getById']);