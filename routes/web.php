<?php

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Rota do Dashboard com captura de exceção para não dar tela em branco/500 genérico
Route::get('/dashboard', function () {
    try {
        $totalClientes = Cliente::count();
        $totalUsuarios = User::count();
        return view('dashboard', compact('totalClientes', 'totalUsuarios'));
    } catch (\Throwable $e) {
        // Se houver qualquer falha no banco ou renderização, exibe o motivo na tela em vez do 500 genérico
        return response()->json([
            'status' => 'ERRO NO DASHBOARD',
            'mensagem' => $e->getMessage(),
            'arquivo' => $e->getFile(),
            'linha' => $e->getLine()
        ], 500);
    }
});

// Views Blade dos módulos
Route::view('/clientes', 'clientes.index');
Route::view('/clientes/create', 'clientes.create');
Route::get('/clientes/{id}/edit', function ($id) {
    return view('clientes.edit');
});

Route::view('/usuarios', 'usuarios.index');
Route::view('/usuarios/create', 'usuarios.create');
Route::view('/ponto', 'ponto.index');
