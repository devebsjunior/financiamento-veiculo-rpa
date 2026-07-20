<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FinanciamentoController;
use App\Http\Controllers\ParcelaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

Route::post(
    'login',
    [AuthController::class, 'login']
);

Route::middleware('jwt.auth')->group(function () {

    Route::post(
        'logout',
        [AuthController::class, 'logout']
    );

    Route::apiResource(
        'users',
        UserController::class
    );

    Route::apiResource(
        'clientes',
        ClienteController::class
    );

    Route::apiResource(
        'veiculos',
        VeiculoController::class
    );

    Route::apiResource(
        'financiamentos',
        FinanciamentoController::class
    );

    Route::get(
        'parcelas',
        [ParcelaController::class, 'index']
    );

    Route::get(
        'parcelas/{id}',
        [ParcelaController::class, 'show']
    );

    Route::patch(
        'parcelas/{id}/pagar',
        [ParcelaController::class, 'pagar']
    );
});
