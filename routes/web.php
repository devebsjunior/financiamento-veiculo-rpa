<?php

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Models\Ponto;
use Carbon\Carbon;

Route::get('/', function () {
  return view('auth.login');
});


Route::get('/login', function () {
  return view('auth.login');
})->name('login');


Route::get('/dashboard', function () {
  try {
    $totalClientes = Cliente::count();
    $totalUsuarios = User::count();
    return view('dashboard', compact('totalClientes', 'totalUsuarios'));
  } catch (\Throwable $e) {
    return response()->json([
      'status' => 'ERRO NO DASHBOARD',
      'mensagem' => $e->getMessage(),
      'arquivo' => $e->getFile(),
      'linha' => $e->getLine()
    ], 500);
  }
});


Route::view('/clientes', 'clientes.index');
Route::view('/clientes/create', 'clientes.create');
Route::get('/clientes/{id}/edit', function ($id) {
  return view('clientes.edit');
});


Route::view('/users', 'users.index');
Route::get('/users/create', function () {
    return view('users.form');
});
Route::get('/users/{id}/edit', function ($id) {
    return view('users.form', compact('id'));
});


Route::view('/ponto', 'ponto.index');

Route::get('/prometheus', function () {
    $phpVersion = PHP_VERSION_ID;
    $totalUsuarios = \App\Models\User::count();
    $pontosPorDia = Ponto::all()->groupBy('data');

    $output = "# HELP php_version php_version\n";
    $output .= "# TYPE php_version gauge\n";
    $output .= "php_version {$phpVersion}\n\n";
    $output .= "# HELP total_de_usuarios total_de_usuarios\n";
    $output .= "# TYPE total_de_usuarios gauge\n";
    $output .= "total_de_usuarios {$totalUsuarios}\n\n";
    $output .= "# HELP horas_trabalhadas_por_dia Total de horas trabalhadas por dia\n";
    $output .= "# TYPE horas_trabalhadas_por_dia gauge\n";

    foreach ($pontosPorDia as $data => $registros) {
        $totalHoras = $registros->sum(fn ($p) => abs((float) $p->total_horas));
        $totalHoras = round($totalHoras, 2);
        $diaFormatado = Carbon::parse($data)->format('j/n');
        $output .= "horas_trabalhadas_por_dia{dia=\"{$diaFormatado}\"} {$totalHoras}\n";
    }

    return response($output, 200)
        ->header('Content-Type', 'text/plain; version=0.0.4');
});
