<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//ROTAS DO USUÁRIO
Route::group(['prefix' => 'user'], function () {
    // ROTAS DE AUTENTICAÇÃO DO USUÁRIO
    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [UserController::class, 'register']);
        Route::post('login', [AuthUserController::class, 'login']);
    });
    // ROTAS PROTEGIDAS DO USUÁRIO
    Route::group(['middleware' => 'jwt.auth'], function() {
        Route::post('logout', [AuthUserController::class, 'logout']);
        Route::post('refresh', [AuthUserController::class, 'refresh']);
        Route::post('me', [AuthUserController::class, 'me']);

        Route::post('update', [UserController::class, 'update']);
    });
});

// ROTAS ADMINISTRADOR
Route::group(['prefix' => 'admin'], function(){
    // ROTAS DE AUTENTICAÇÃO DO ADMINISTRADOR
    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [AdminController::class, 'register']);
        Route::post('login', [AuthAdminController::class, 'login']);
    });
    // ROTAS PROTEGIDAS DO ADMINISTRADOR
    Route::group(['middleware' => 'jwt.auth'], function() {
        Route::post('logout', [AuthAdminController::class, 'logout']);
        Route::post('refresh', [AuthAdminController::class, 'refresh']);
        Route::post('me', [AuthAdminController::class, 'me']);

        Route::post('update', [AdminController::class, 'update']);
    });
});