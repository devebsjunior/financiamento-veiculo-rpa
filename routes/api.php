<?php
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\FinanciamentoController;
use App\Http\Controllers\ParcelaController;

Route::apiResource('clientes', ClienteController::class);

Route::apiResource('veiculos', VeiculoController::class);

Route::apiResource('financiamentos', FinanciamentoController::class);

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