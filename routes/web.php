<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\K8sAutoAuth;

// Rota pública de boas-vindas
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([K8sAutoAuth::class])->group(function () {

    Route::get('/dashboard', function () {
        $user = Auth::user();
        return response("Olá, {$user->name}! Você foi autenticado pelo Kubernetes e logado/cadastrado no PostgreSQL de forma automática. Seu e-mail é: {$user->email}", 200);
    });

});
