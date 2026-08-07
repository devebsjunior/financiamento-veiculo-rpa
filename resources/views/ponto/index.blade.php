@extends('layouts.app')

@section('title', 'Controle de Ponto - Gestão Car')

@section('content')
<!-- NOTIFICAÇÃO TOAST (Fixo no canto superior direito) -->
<div id="toastAlerta5min" class="hidden fixed top-5 right-5 z-50 max-w-xs bg-amber-50 border-l-4 border-amber-500 text-amber-900 p-4 rounded-xl shadow-xl flex items-start gap-3 transition-all transform duration-300">
    <div class="text-amber-500 text-xl mt-0.5">
        <i class="fa-solid fa-triangle-exclamation"></i>
    </div>
    <div class="flex-1">
        <h4 class="font-bold text-sm text-amber-900">Atenção ao Ponto!</h4>
        <p class="text-xs text-amber-800 mt-1" id="msgToastAlerta">Faltam menos de 5 minutos para encerrar suas 8h diárias.</p>
    </div>
    <button id="btnFecharToast" class="text-amber-500 hover:text-amber-700 text-sm font-bold cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>

<div class="max-w-7xl mx-auto space-y-6">

    <!-- Cabeçalho -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Marcação de Ponto</h1>
            <p class="text-slate-500 mt-1">Registre seus horários de entrada e saída no sistema</p>
        </div>
    </div>

    <!-- Card Principal com Relógio -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 relative">

        <div class="text-center">
            <p class="text-slate-600 text-lg mb-2">
                Olá, <span id="userName" class="font-bold text-slate-800">Carregando...</span>, registre seu ponto:
            </p>

            <div class="my-6">
                <div class="text-6xl sm:text-7xl font-black text-slate-900 tracking-tight font-mono" id="clock">
                    00:00<span class="text-3xl text-slate-400 font-normal ml-2" id="seconds">00</span>
                </div>
                <div class="text-slate-500 text-base font-medium mt-3 capitalize" id="currentDate">
                    --
                </div>
            </div>

            <!-- CARD DE ALERTA DE PREVISÃO DE SAÍDA (JORNADA DE 8H) -->
            <div id="cardAlertaJornada" class="hidden max-w-lg mx-auto mb-6 p-4 rounded-xl border bg-indigo-50/80 border-indigo-100 text-indigo-900 text-left transition-all">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-indigo-600 text-white rounded-lg">
                        <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                    </div>
                    <div class="flex-1">
                        <div class="text-xs font-bold text-indigo-500 uppercase tracking-wider">Previsão para 8h Diárias</div>
                        <div class="text-base font-bold text-slate-800" id="textoHorarioSaida">
                            Saída prevista para às&nbsp; <span class="font-mono text-indigo-700 font-extrabold text-lg" id="horaSaidaEstimada">--:--</span>
                        </div>
                        <p class="text-xs text-indigo-600 mt-0.5" id="detalheCronometro">
                            Calculando tempo restante...
                        </p>
                    </div>
                </div>
            </div>

            <!-- Botão de Marcação Rápida -->
            <div class="mt-4 flex justify-center">
                <button
                    id="btnBaterPonto"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 rounded-xl text-lg shadow-md transition-all flex items-center gap-3 active:scale-95 cursor-pointer disabled:opacity-50"
                >
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Registrar Ponto</span>
                </button>
            </div>

            <div id="feedback" class="hidden mt-6 p-4 rounded-xl text-sm max-w-md mx-auto font-medium transition-all"></div>
        </div>

        <hr class="my-8 border-slate-100">

        <!-- Tabela por Dia / Espelho de Ponto -->
        <div>
            <!-- FILTRO DE MÊS E BOTÃO DE EXPORTAÇÃO -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                    Histórico de Marcações do Mês
                </h3>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <!-- Input de Mês/Ano -->
                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg p-1.5">
                        <i class="fa-regular fa-calendar-days text-slate-400 text-sm ml-1.5"></i>
                        <input
                            type="month"
                            id="filtroMesAno"
                            class="bg-transparent text-xs font-semibold text-slate-700 focus:outline-none cursor-pointer"
                        >
                    </div>

                    <!-- Botão de Filtrar -->
                    <button
                        id="btnFiltrarPonto"
                        class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white font-semibold rounded-lg text-xs transition-colors flex items-center gap-1.5 shadow-xs cursor-pointer"
                    >
                        <i class="fa-solid fa-filter text-xs"></i>
                        <span>Filtrar</span>
                    </button>

                    <!-- Botão Exportar Excel -->
                    <button
                        id="btnExportarExcel"
                        class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg text-xs transition-colors flex items-center gap-1.5 shadow-xs cursor-pointer"
                    >
                        <i class="fa-solid fa-file-excel text-xs"></i>
                        <span>Exportar XLS</span>
                    </button>
                </div>
            </div>

            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white shadow-2xs overflow-x-auto">
                <div class="bg-slate-50 border-b border-slate-200/80 px-4 py-3 grid grid-cols-12 gap-2 text-xs font-bold text-slate-500 uppercase tracking-wider text-center min-w-[768px]">
                    <div class="col-span-2 text-left">Data</div>
                    <div class="col-span-1">E1</div>
                    <div class="col-span-1">S1</div>
                    <div class="col-span-1">E2</div>
                    <div class="col-span-1">S2</div>
                    <div class="col-span-2">Trabalhadas</div>
                    <div class="col-span-2">Banco Horas</div>
                    <div class="col-span-1">Status</div>
                    <div class="col-span-1 text-right">Ações</div>
                </div>

                <div id="tabelaLinhasDias" class="divide-y divide-slate-100 min-w-[768px]">
                    <div class="p-6 text-center text-slate-400 text-sm italic">
                        Carregando registros...
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal para Editar/Ajustar os Horários do Dia Completo -->
<div id="modalAjustarDia" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-slate-800 mb-1">Ajustar Ponto do Dia</h3>
        <p id="subtituloDataModal" class="text-xs font-medium text-slate-500 mb-6">Data: --</p>

        <form id="formAjustarDia">
            <input type="hidden" id="pontoIdModal">

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Entrada 1</label>
                    <input type="time" step="1" id="e1Modal" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-mono text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Saída 1</label>
                    <input type="time" step="1" id="s1Modal" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-mono text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Entrada 2</label>
                    <input type="time" step="1" id="e2Modal" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-mono text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Saída 2</label>
                    <input type="time" step="1" id="s2Modal" class="w-full border border-slate-300 rounded-lg px-3 py-2 font-mono text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Observação RH</label>
                <input type="text" id="obsModal" placeholder="Ex: Ajuste de horário esquecido" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm text-slate-800 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <button type="button" id="btnFecharModal" class="px-4 py-2 text-slate-600 hover:bg-slate-100 font-medium rounded-lg text-sm transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm shadow-sm transition-colors cursor-pointer">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    @vite('resources/js/ponto.js')
@endpush
