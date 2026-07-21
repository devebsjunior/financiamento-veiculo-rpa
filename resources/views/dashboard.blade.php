@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-bold text-slate-800 mb-8">
        Dashboard
    </h1>

    <!-- Grid de 5 colunas -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

        <!-- Card de Clientes -->
        <div class="relative overflow-hidden bg-white rounded-xl shadow p-6 border border-slate-100">
            <div class="relative z-10">
                <p class="text-slate-500 font-medium text-sm">Clientes</p>
                <h2 class="text-4xl font-bold mt-2 text-slate-800">{{ $totalClientes }}</h2>
            </div>
            <!-- Ícone de Fundo -->
            <i class="fa-solid fa-users absolute right-4 bottom-2 text-6xl text-slate-200/60 pointer-events-none"></i>
        </div>

        <!-- Card de Usuários -->
        <div class="relative overflow-hidden bg-white rounded-xl shadow p-6 border border-slate-100">
            <div class="relative z-10">
                <p class="text-slate-500 font-medium text-sm">Usuários</p>
                <h2 class="text-4xl font-bold mt-2 text-slate-800">{{ $totalUsuarios }}</h2>
            </div>
            <!-- Ícone de Fundo -->
            <i class="fa-solid fa-user-shield absolute right-4 bottom-2 text-6xl text-slate-200/60 pointer-events-none"></i>
        </div>

        <!-- Card de Veículos -->
        <div class="relative overflow-hidden bg-white rounded-xl shadow p-6 border border-slate-100">
            <div class="relative z-10">
                <p class="text-slate-500 font-medium text-sm">Veículos</p>
                <h2 class="text-4xl font-bold mt-2 text-slate-800">0</h2>
            </div>
            <!-- Ícone de Fundo -->
            <i class="fa-solid fa-car absolute right-4 bottom-2 text-6xl text-slate-200/60 pointer-events-none"></i>
        </div>

        <!-- Card de Financiamentos -->
        <div class="relative overflow-hidden bg-white rounded-xl shadow p-6 border border-slate-100">
            <div class="relative z-10">
                <p class="text-slate-500 font-medium text-sm">Financiamentos</p>
                <h2 class="text-4xl font-bold mt-2 text-slate-800">0</h2>
            </div>
            <!-- Ícone de Fundo -->
            <i
                class="fa-solid fa-file-invoice-dollar absolute right-4 bottom-2 text-6xl text-slate-200/60 pointer-events-none"></i>
        </div>

        <!-- Card de Parcelas -->
        <div class="relative overflow-hidden bg-white rounded-xl shadow p-6 border border-slate-100">
            <div class="relative z-10">
                <p class="text-slate-500 font-medium text-sm">Parcelas</p>
                <h2 class="text-4xl font-bold mt-2 text-slate-800">0</h2>
            </div>
            <!-- Ícone de Fundo -->
            <i
                class="fa-solid fa-calendar-days absolute right-4 bottom-2 text-6xl text-slate-200/60 pointer-events-none"></i>
        </div>

    </div>
@endsection
