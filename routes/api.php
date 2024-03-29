<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
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

//Users
Route::POST('users', [UserController::class, 'store']);
Route::get('users', [UserController::class, 'index']);
Route::post('users/{id}', [UserController::class, 'destroy']);

//Posts

Route::post('posts', [PostController::class, 'store']);
Route::get('posts/{id}', [PostController::class, 'destroy']);
Route::post('posts/{id}', [PostController::class, 'update']);
Route::get('posts', [PostController::class, 'traer']);
