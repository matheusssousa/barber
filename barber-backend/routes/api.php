<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AgendamentoController as AdminAgendamentoController;
use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\CorteController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\HorarioAgendamentoController;
use App\Http\Controllers\Admin\PacoteController;
use App\Http\Controllers\Admin\ResetPasswordController;
use App\Http\Controllers\Admin\ServicoController;
use App\Http\Controllers\User\AgendamentoController;
use App\Http\Controllers\User\AuthUserController;
use App\Http\Controllers\User\CorteController as UserCorteController;
use App\Http\Controllers\User\HorarioAgendamentoController as UserHorarioAgendamentoController;
use App\Http\Controllers\User\PacoteController as UserPacoteController;
use App\Http\Controllers\User\ServicoController as UserServicoController;
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

// ROTAS DO USUÁRIO
Route::group(['prefix' => 'user'], function () {
    Route::get('corte', [UserCorteController::class, 'index']);
    Route::get('servico', [UserServicoController::class, 'index']);
    Route::get('pacote', [UserPacoteController::class, 'index']);
    // ROTAS DE AUTENTICAÇÃO DO USUÁRIO
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [UserController::class, 'register']);
        Route::post('login', [AuthUserController::class, 'login']);
    });
    // ROTAS PROTEGIDAS DO USUÁRIO
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('logout', [AuthUserController::class, 'logout']);
        Route::post('refresh', [AuthUserController::class, 'refresh']);
        Route::post('me', [AuthUserController::class, 'me']);

        Route::post('update', [UserController::class, 'update']);

        Route::get('horario/{data}', [UserHorarioAgendamentoController::class, 'index']);
        Route::apiResource('agendamento', AgendamentoController::class);
    });
});

// ROTAS ADMINISTRADOR
Route::group(['prefix' => 'admin'], function () {
    // ROTAS DE ESQUECEU SENHA DO ADMINISTRADOR
    Route::group(['prefix' => 'reset'], function () {
        Route::post('/forgotpassword', [ForgotPasswordController::class, 'forgotPassword']);
        Route::post('/resetpassword/{token}', [ResetPasswordController::class, 'reset']);
    });
    // ROTAS DE AUTENTICAÇÃO DO ADMINISTRADOR
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AdminController::class, 'register']);
        Route::post('login', [AuthAdminController::class, 'login']);
    });
    // ROTAS PROTEGIDAS DO ADMINISTRADOR
    Route::group(['middleware' => 'jwt.admin'], function () {
        Route::post('logout', [AuthAdminController::class, 'logout']);
        Route::post('refresh', [AuthAdminController::class, 'refresh']);
        Route::post('me', [AuthAdminController::class, 'me']);

        Route::post('update', [AdminController::class, 'update']);
        Route::post('update/password/{id}', [AdminController::class, 'updatePasssword']);

        Route::post('corte/restore/{id}', [CorteController::class, 'restore']);
        Route::post('corte/forcedelete/{id}', [CorteController::class, 'forceDelete']);
        Route::apiResource('corte', CorteController::class);

        Route::post('servico/restore/{id}', [ServicoController::class, 'restore']);
        Route::post('servico/forcedelete/{id}', [ServicoController::class, 'forceDelete']);
        Route::apiResource('servico', ServicoController::class);

        Route::post('pacote/restore/{id}', [PacoteController::class, 'restore']);
        Route::post('pacote/forcedelete/{id}', [PacoteController::class, 'forceDelete']);
        Route::apiResource('pacote', PacoteController::class);

        Route::post('horario/restore/{id}', [HorarioAgendamentoController::class, 'restore']);
        Route::post('horario/forcedelete/{id}', [HorarioAgendamentoController::class, 'forceDelete']);
        Route::apiResource('horario', HorarioAgendamentoController::class);

        Route::post('agendamento/restore/{id}', [AdminAgendamentoController::class, 'restore']);
        Route::apiResource('agendamento', AdminAgendamentoController::class);
    });
});
