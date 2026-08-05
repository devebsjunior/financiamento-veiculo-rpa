<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FinanciamentoController;
use App\Http\Controllers\ParcelaController;
use App\Http\Controllers\PontoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);


Route::middleware('jwt.auth')->group(function () {

    // Autenticação
    Route::post('logout', [AuthController::class, 'logout']);

    // Recursos da API (Users, Clientes, Veículos e Financiamentos)
    Route::apiResource('users', UserController::class);
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('veiculos', VeiculoController::class);
    Route::apiResource('financiamentos', FinanciamentoController::class);

    // Sub-rotas de Parcelas
    Route::get('parcelas', [ParcelaController::class, 'index']);
    Route::get('parcelas/{id}', [ParcelaController::class, 'show']);
    Route::patch('parcelas/{id}/pagar', [ParcelaController::class, 'pagar']);

    Route::post('/ponto/marcar', [PontoController::class, 'baterPonto']);
    Route::get('/ponto/espelho/{anoMes}', [PontoController::class, 'espelhoMes']);
    Route::get('/ponto/admin/listar', [PontoController::class, 'index']);
    Route::put('/ponto/admin/{id}', [PontoController::class, 'update']);
    Route::delete('/ponto/admin/{id}', [PontoController::class, 'destroy']);
    Route::delete('/ponto/admin/{id}/horario/{index}', [PontoController::class, 'destroyHorario']);
});
