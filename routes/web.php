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


Route::get('/dashboard', function () {
    try {
        $totalClientes = \App\Models\Cliente::count();
    } catch (\Throwable $e) {
        $totalClientes = 0;
    }
    try {
        $totalUsuarios = \App\Models\User::count();
    } catch (\Throwable $e) {
        $totalUsuarios = 0;
    }
    return view('dashboard', compact('totalClientes', 'totalUsuarios'));
});

// Telas de Clientes (Apenas entregam as Views Blade)
Route::view('/clientes', 'clientes.index');
Route::view('/clientes/create', 'clientes.create');
Route::get('/clientes/{id}/edit', function ($id) {
    return view('clientes.edit');
});

// Telas de Usuários
Route::view('/usuarios', 'usuarios.index');
Route::view('/usuarios/create', 'usuarios.create');

// Telas de Veículos (Se já existirem as views, descomente abaixo)
// Route::view('/veiculos', 'veiculos.index');

// Telas de Financiamentos (Se já existirem as views, descomente abaixo)
// Route::view('/financiamentos', 'financiamentos.index');

Route::view('/ponto', 'ponto.index');
