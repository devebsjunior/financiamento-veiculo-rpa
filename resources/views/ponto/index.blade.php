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
    <button onclick="fecharToast()" class="text-amber-500 hover:text-amber-700 text-sm font-bold cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>

<div class="max-w-5xl mx-auto space-y-6">

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
                            Saída prevista para as <span class="font-mono text-indigo-700 font-extrabold text-lg" id="horaSaidaEstimada">--:--</span>
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
                    onclick="registrarPonto()"
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
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">
                    Histórico de Marcações do Mês
                </h3>
            </div>

            <div class="border border-slate-200/80 rounded-xl overflow-hidden bg-white shadow-2xs">
                <div class="bg-slate-50 border-b border-slate-200/80 px-4 py-3 grid grid-cols-12 gap-2 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">
                    <div class="col-span-2 text-left">Data</div>
                    <div class="col-span-2">Entrada </div>
                    <div class="col-span-2">Saída </div>
                    <div class="col-span-2">Entrada </div>
                    <div class="col-span-2">Saída </div>
                    <div class="col-span-2 text-right">Ações</div>
                </div>

                <div id="tabelaLinhasDias" class="divide-y divide-slate-100">
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

        <form id="formAjustarDia" onsubmit="salvarAjusteDia(event)">
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
                <button type="button" onclick="fecharModal()" class="px-4 py-2 text-slate-600 hover:bg-slate-100 font-medium rounded-lg text-sm transition-colors cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm shadow-sm transition-colors cursor-pointer">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const token = localStorage.getItem('token');
    let registrosMesGlobal = [];
    let intervalAlerta = null;
    let toastNotificado = false;

    // Relógio Digital
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        document.getElementById('clock').innerHTML = `${hours}:${minutes}<span class="text-3xl text-slate-400 font-normal ml-2">${seconds}</span>`;

        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('currentDate').innerText = now.toLocaleDateString('pt-BR', options);
    }
    setInterval(updateClock, 1000);
    updateClock();

    function obterNomeDoToken() {
        if (!token) return 'Usuário';
        try {
            const base64Url = token.split('.')[1];
            const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            const jsonPayload = decodeURIComponent(atob(base64).split('').map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)).join(''));
            const payload = JSON.parse(jsonPayload);
            return payload.name || payload.email || 'Usuário';
        } catch (e) {
            return 'Usuário';
        }
    }

    // Carregar registros
    async function loadUserData() {
        document.getElementById('userName').innerText = obterNomeDoToken();

        try {
            const anoMesHoje = new Date().toISOString().slice(0, 7);
            const response = await fetch(`/api/ponto/espelho/${anoMesHoje}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                const data = await response.json();
                registrosMesGlobal = Array.isArray(data.registros) ? data.registros : [];
                renderTabelaDias(registrosMesGlobal);
                calcularAlertaJornada(registrosMesGlobal);
            } else {
                renderTabelaDias([]);
            }
        } catch (e) {
            renderTabelaDias([]);
        }
    }

    // Calcular Alerta e Toast de 5 min
    function calcularAlertaJornada(registros) {
        const hojeStr = new Date().toISOString().slice(0, 10);
        const registroHoje = registros.find(r => r.data === hojeStr);
        const card = document.getElementById('cardAlertaJornada');

        if (!registroHoje || !registroHoje.horarios || registroHoje.horarios.length === 0) {
            card.classList.add('hidden');
            fecharToast();
            return;
        }

        const h = registroHoje.horarios;
        const e1 = h[0];
        const s1 = h[1];
        const e2 = h[2];
        const s2 = h[3];

        if (s2) {
            card.classList.remove('hidden');
            document.getElementById('horaSaidaEstimada').innerText = s2;
            document.getElementById('detalheCronometro').innerText = 'Jornada do dia finalizada!';
            fecharToast();
            return;
        }

        const toMin = (timeStr) => {
            if (!timeStr) return null;
            const [hrs, mins] = timeStr.split(':').map(Number);
            return hrs * 60 + mins;
        };

        const e1Min = toMin(e1);
        const s1Min = toMin(s1);
        const e2Min = toMin(e2);

        let tempoAlmoco = 60;
        if (s1Min && e2Min) {
            tempoAlmoco = e2Min - s1Min;
        }

        const minutosSaidaEstimada = e1Min + 480 + tempoAlmoco;

        const hrsSaida = Math.floor(minutosSaidaEstimada / 60) % 24;
        const minsSaida = minutosSaidaEstimada % 60;
        const horaFormatada = `${String(hrsSaida).padStart(2, '0')}:${String(minsSaida).padStart(2, '0')}`;

        card.classList.remove('hidden');
        document.getElementById('horaSaidaEstimada').innerText = horaFormatada;

        if (intervalAlerta) clearInterval(intervalAlerta);

        const atualizarContagem = () => {
            const agora = new Date();
            const agoraMin = agora.getHours() * 60 + agora.getMinutes();
            const minRestantes = minutosSaidaEstimada - agoraMin;

            if (minRestantes <= 0) {
                document.getElementById('detalheCronometro').innerHTML = `<span class="text-emerald-700 font-bold"><i class="fa-solid fa-circle-check"></i> Você completou suas 8h diárias! Pode bater o ponto de saída.</span>`;
            } else {
                const hRest = Math.floor(minRestantes / 60);
                const mRest = minRestantes % 60;
                document.getElementById('detalheCronometro').innerText = `Faltam ${hRest}h ${mRest}m para completar sua jornada de 8h.`;
            }

            // REGRA DO TOAST: Dispara se faltar 5 minutos ou menos para a saída
            if (minRestantes > 0 && minRestantes <= 5) {
                exibirToast(`Faltam apenas <strong>${minRestantes} minuto(s)</strong> para você bater o ponto das 8h (${horaFormatada})!`);
            } else if (minRestantes <= 0 && !s2) {
                exibirToast(`Sua jornada de 8h foi atingida às <strong>${horaFormatada}</strong>. Lembre-se de registrar a saída!`);
            }
        };

        atualizarContagem();
        intervalAlerta = setInterval(atualizarContagem, 10000); // Checa a cada 10 seg
    }

    function exibirToast(mensagem) {
        document.getElementById('msgToastAlerta').innerHTML = mensagem;
        const toast = document.getElementById('toastAlerta5min');
        toast.classList.remove('hidden');
    }

    function fecharToast() {
        document.getElementById('toastAlerta5min').classList.add('hidden');
    }

    // Renderizar Tabela
    function renderTabelaDias(registros) {
        const container = document.getElementById('tabelaLinhasDias');

        if (!registros || registros.length === 0) {
            container.innerHTML = `<div class="p-6 text-center text-slate-400 text-sm italic">Nenhum registro encontrado neste mês.</div>`;
            return;
        }

        container.innerHTML = registros.map(item => {
            const h = item.horarios || [];

            const e1 = h[0] || '--:--:--';
            const s1 = h[1] || '--:--:--';
            const e2 = h[2] || '--:--:--';
            const s2 = h[3] || '--:--:--';

            const [ano, mes, dia] = item.data.split('-');
            const dataFormatada = `${dia}/${mes}/${ano}`;

            return `
                <div class="px-4 py-3 grid grid-cols-12 gap-2 items-center text-center hover:bg-slate-50/80 transition-colors">

                    <div class="col-span-2 text-left font-semibold text-slate-800 text-sm flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar text-slate-400 text-xs"></i>
                        <span>${dataFormatada}</span>
                    </div>

                    <div class="col-span-2 font-mono text-xs px-2 py-1 rounded-md ${h[0] ? 'bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100' : 'text-slate-300'}">
                        ${e1}
                    </div>
                    <div class="col-span-2 font-mono text-xs px-2 py-1 rounded-md ${h[1] ? 'bg-amber-50 text-amber-700 font-semibold border border-amber-100' : 'text-slate-300'}">
                        ${s1}
                    </div>
                    <div class="col-span-2 font-mono text-xs px-2 py-1 rounded-md ${h[2] ? 'bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100' : 'text-slate-300'}">
                        ${e2}
                    </div>
                    <div class="col-span-2 font-mono text-xs px-2 py-1 rounded-md ${h[3] ? 'bg-amber-50 text-amber-700 font-semibold border border-amber-100' : 'text-slate-300'}">
                        ${s2}
                    </div>

                    <div class="col-span-2 text-right flex items-center justify-end gap-1">
                        <button
                            onclick="abrirModalAjuste(${item.id})"
                            class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                            title="Editar horários do dia"
                        >
                            <i class="fa-solid fa-pen-to-square text-sm"></i>
                        </button>
                        <button
                            onclick="apagarRegistroPonto(${item.id})"
                            class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                            title="Apagar este dia completamente"
                        >
                            <i class="fa-solid fa-trash-can text-sm"></i>
                        </button>
                    </div>

                </div>
            `;
        }).join('');
    }

    // Modal de Edição
    function abrirModalAjuste(pontoId) {
        const item = registrosMesGlobal.find(r => r.id === pontoId);
        if (!item) return;

        const h = item.horarios || [];
        const [ano, mes, dia] = item.data.split('-');

        document.getElementById('pontoIdModal').value = item.id;
        document.getElementById('subtituloDataModal').innerText = `Data: ${dia}/${mes}/${ano}`;

        document.getElementById('e1Modal').value = h[0] || '';
        document.getElementById('s1Modal').value = h[1] || '';
        document.getElementById('e2Modal').value = h[2] || '';
        document.getElementById('s2Modal').value = h[3] || '';
        document.getElementById('obsModal').value = item.observacao || '';

        document.getElementById('modalAjustarDia').classList.remove('hidden');
    }

    function fecharModal() {
        document.getElementById('modalAjustarDia').classList.add('hidden');
    }

    async function salvarAjusteDia(e) {
        e.preventDefault();
        const pontoId = document.getElementById('pontoIdModal').value;

        const e1 = document.getElementById('e1Modal').value;
        const s1 = document.getElementById('s1Modal').value;
        const e2 = document.getElementById('e2Modal').value;
        const s2 = document.getElementById('s2Modal').value;
        const obs = document.getElementById('obsModal').value;

        const novosHorarios = [e1, s1, e2, s2].filter(h => h.trim() !== '');

        const response = await fetch(`/api/ponto/admin/${pontoId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                horarios: novosHorarios,
                observacao: obs
            })
        });

        if (response.ok) {
            fecharModal();
            loadUserData();
        } else {
            alert('Erro ao atualizar o registro de ponto.');
        }
    }

    async function apagarRegistroPonto(pontoId) {
        if (!confirm('Deseja remover todos os horários deste dia?')) return;

        const response = await fetch(`/api/ponto/admin/${pontoId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (response.ok) {
            loadUserData();
        }
    }

    async function registrarPonto() {
        const btn = document.getElementById('btnBaterPonto');
        const feedback = document.getElementById('feedback');
        btn.disabled = true;

        try {
            const response = await fetch('/api/ponto/marcar', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                feedback.className = "mt-6 p-4 rounded-xl text-sm max-w-md mx-auto font-medium bg-emerald-50 text-emerald-700 border border-emerald-200";
                feedback.innerHTML = `Ponto registrado com sucesso às <strong>${result.hora}</strong>!`;
                loadUserData();
            } else {
                feedback.className = "mt-6 p-4 rounded-xl text-sm max-w-md mx-auto font-medium bg-red-50 text-red-700 border border-red-200";
                feedback.innerText = result.message || "Não foi possível registrar o ponto.";
            }
        } catch (err) {
            feedback.className = "mt-6 p-4 rounded-xl text-sm max-w-md mx-auto font-medium bg-red-50 text-red-700 border border-red-200";
            feedback.innerText = "Erro ao conectar com o servidor.";
        } finally {
            feedback.classList.remove('hidden');
            btn.disabled = false;
        }
    }

    loadUserData();
</script>
@endsection
