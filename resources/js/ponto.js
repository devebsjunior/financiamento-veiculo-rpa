document.addEventListener('DOMContentLoaded', () => {
  const token = localStorage.getItem('token');
  let registrosMesGlobal = [];
  let intervalAlerta = null;

  const inputFiltro = document.getElementById('filtroMesAno');
  if (inputFiltro) {
    const hoje = new Date();
    const ano = hoje.getFullYear();
    const mes = String(hoje.getMonth() + 1).padStart(2, '0');
    inputFiltro.value = `${ano}-${mes}`;
  }

  function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const clockEl = document.getElementById('clock');
    const dateEl = document.getElementById('currentDate');

    if (clockEl) {
      clockEl.innerHTML = `${hours}:${minutes}<span class="text-3xl text-slate-400 font-normal ml-2">${seconds}</span>`;
    }
    if (dateEl) {
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      dateEl.innerText = now.toLocaleDateString('pt-BR', options);
    }
  }
  setInterval(updateClock, 1000);
  updateClock();

  function obterNomeDoToken() {
    if (!token) return 'Usuário';
    try {
      const base64Url = token.split('.')[1];
      const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      const jsonPayload = decodeURIComponent(
        atob(base64)
          .split('')
          .map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2))
          .join('')
      );
      const payload = JSON.parse(jsonPayload);
      return payload.name || payload.email || 'Usuário';
    } catch (e) {
      return 'Usuário';
    }
  }

  function timeToMinutes(timeStr) {
    if (!timeStr) return null;
    const [h, m] = timeStr.split(':').map(Number);
    return h * 60 + m;
  }

  function minutesToFormatted(totalMin) {
    const signal = totalMin < 0 ? '-' : '+';
    const absMin = Math.abs(totalMin);
    const hrs = Math.floor(absMin / 60);
    const mins = absMin % 60;
    return `${signal}${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}h`;
  }

  function exibirToast(mensagem) {
    const msgEl = document.getElementById('msgToastAlerta');
    const toastEl = document.getElementById('toastAlerta5min');
    if (msgEl) msgEl.innerHTML = mensagem;
    if (toastEl) toastEl.classList.remove('hidden');
  }

  function fecharToast() {
    const toastEl = document.getElementById('toastAlerta5min');
    if (toastEl) toastEl.classList.add('hidden');
  }

  function fecharModal() {
    const modalEl = document.getElementById('modalAjustarDia');
    if (modalEl) modalEl.classList.add('hidden');
  }

  function calcularAlertaJornada(registros) {
    const hojeStr = new Date().toISOString().slice(0, 10);
    const registroHoje = registros.find(r => r.data === hojeStr);
    const card = document.getElementById('cardAlertaJornada');

    if (!card) return;

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

    const e1Min = timeToMinutes(e1);
    const s1Min = timeToMinutes(s1);
    const e2Min = timeToMinutes(e2);

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

      const detalheEl = document.getElementById('detalheCronometro');

      if (minRestantes <= 0) {
        if (detalheEl) {
          detalheEl.innerHTML = `<span class="text-emerald-700 font-bold"><i class="fa-solid fa-circle-check"></i> Você completou suas 8h diárias! Pode bater o ponto de saída.</span>`;
        }
      } else {
        const hRest = Math.floor(minRestantes / 60);
        const mRest = minRestantes % 60;
        if (detalheEl) {
          detalheEl.innerText = `Faltam ${hRest}h ${mRest}m para completar sua jornada de 8h.`;
        }
      }

      if (minRestantes > 0 && minRestantes <= 5) {
        exibirToast(`Faltam apenas <strong>${minRestantes} minuto(s)</strong> para você bater o ponto das 8h (${horaFormatada})!`);
      } else if (minRestantes <= 0 && !s2) {
        exibirToast(`Sua jornada de 8h foi atingida às <strong>${horaFormatada}</strong>. Lembre-se de registrar a saída!`);
      }
    };

    atualizarContagem();
    intervalAlerta = setInterval(atualizarContagem, 10000);
  }

  function renderTabelaDias(registros) {
    const container = document.getElementById('tabelaLinhasDias');
    if (!container) return;

    if (!registros || registros.length === 0) {
      container.innerHTML = `<div class="p-6 text-center text-slate-400 text-sm italic">Nenhum registro encontrado para o período selecionado.</div>`;
      return;
    }

    const registrosOrdenados = [...registros].sort((a, b) => b.data.localeCompare(a.data));

    container.innerHTML = registrosOrdenados.map(item => {
      const h = item.horarios || [];

      const e1 = h[0] || '--:--:--';
      const s1 = h[1] || '--:--:--';
      const e2 = h[2] || '--:--:--';
      const s2 = h[3] || '--:--:--';

      let totalMinutos = 0;
      if (h[0] && h[1]) totalMinutos += (timeToMinutes(h[1]) - timeToMinutes(h[0]));
      if (h[2] && h[3]) totalMinutos += (timeToMinutes(h[3]) - timeToMinutes(h[2]));

      const hrsTrab = Math.floor(totalMinutos / 60);
      const minsTrab = totalMinutos % 60;
      const strTrabalhadas = `${String(hrsTrab).padStart(2, '0')}:${String(minsTrab).padStart(2, '0')}h`;

      const saldoMinutos = totalMinutos - 480;
      const strBancoHoras = h.length >= 4 ? minutesToFormatted(saldoMinutos) : '--:--';
      const isPositivo = saldoMinutos >= 0;

      const isValidado = h.length >= 4;
      const statusBadge = isValidado
        ? `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Validado</span>`
        : `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">Em andamento</span>`;

      const [ano, mes, dia] = item.data.split('-');
      const dataFormatada = `${dia}/${mes}/${ano}`;

      return `
        <div class="px-4 py-3 grid grid-cols-12 gap-2 items-center text-center hover:bg-slate-50/80 transition-colors">
            <div class="col-span-2 text-left font-semibold text-slate-800 text-sm flex items-center gap-1.5">
                <i class="fa-regular fa-calendar text-slate-400 text-xs"></i>
                <span>${dataFormatada}</span>
            </div>

            <div class="col-span-1 font-mono text-xs px-1 py-1 rounded-md ${h[0] ? 'bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100' : 'text-slate-300'}">
                ${e1.slice(0, 5)}
            </div>
            <div class="col-span-1 font-mono text-xs px-1 py-1 rounded-md ${h[1] ? 'bg-amber-50 text-amber-700 font-semibold border border-amber-100' : 'text-slate-300'}">
                ${s1.slice(0, 5)}
            </div>
            <div class="col-span-1 font-mono text-xs px-1 py-1 rounded-md ${h[2] ? 'bg-emerald-50 text-emerald-700 font-semibold border border-emerald-100' : 'text-slate-300'}">
                ${e2.slice(0, 5)}
            </div>
            <div class="col-span-1 font-mono text-xs px-1 py-1 rounded-md ${h[3] ? 'bg-amber-50 text-amber-700 font-semibold border border-amber-100' : 'text-slate-300'}">
                ${s2.slice(0, 5)}
            </div>

            <div class="col-span-2 font-mono text-xs font-bold text-slate-700">
                ${strTrabalhadas}
            </div>

            <div class="col-span-2 font-mono text-xs font-extrabold ${!isValidado ? 'text-slate-400' : (isPositivo ? 'text-emerald-600' : 'text-rose-600')}">
                ${strBancoHoras}
            </div>

            <div class="col-span-1 flex justify-center">
                ${statusBadge}
            </div>

            <div class="col-span-1 text-right flex items-center justify-end gap-1">
                <button
                    data-action="editar"
                    data-id="${item.id}"
                    class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors cursor-pointer"
                    title="Editar horários do dia"
                >
                    <i class="fa-solid fa-pen-to-square text-sm pointer-events-none"></i>
                </button>
                <button
                    data-action="deletar"
                    data-id="${item.id}"
                    class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer"
                    title="Apagar este dia completamente"
                >
                    <i class="fa-solid fa-trash-can text-sm pointer-events-none"></i>
                </button>
            </div>
        </div>
      `;
    }).join('');
  }

  async function loadUserData(anoMes = null) {
    const userNameEl = document.getElementById('userName');
    if (userNameEl) userNameEl.innerText = obterNomeDoToken();

    // Sanitização e garantia do formato YYYY-MM
    let valorFiltro = typeof anoMes === 'string' ? anoMes : inputFiltro?.value;
    if (!valorFiltro) {
      valorFiltro = new Date().toISOString().slice(0, 7);
    }

    const [anoRaw, mesRaw] = valorFiltro.split('-');
    const parametroMes = (anoRaw && mesRaw) ? `${anoRaw}-${mesRaw.padStart(2, '0')}` : valorFiltro;

    try {
      const response = await fetch(`/api/ponto/espelho/${parametroMes}`, {
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

  function exportarParaExcel() {
    try {
      if (!registrosMesGlobal || registrosMesGlobal.length === 0) {
        alert('Nenhum dado disponível para exportar no período selecionado.');
        return;
      }
      const nomeProjeto = "Gestão Car - Financiamento Veículos RPA";
      let nome = typeof nomeFuncionario !== 'undefined' ? nomeFuncionario : null;
      if (!nome) {
        const userStorage = JSON.parse(localStorage.getItem('user') || '{}');
        nome = userStorage.nome || document.getElementById('nomeFuncionario')?.innerText || 'Edson Belém';
      }
      const mesAnoRaw = inputFiltro?.value || '2026-08';
      const [anoSel, mesSel] = mesAnoRaw.split('-');
      const mesFormatado = (mesSel && anoSel) ? `${mesSel.padStart(2, '0')}/${anoSel}` : mesAnoRaw;
      const cabeçalhoTabela = ['Data', 'Entrada 1', 'Saida 1', 'Entrada 2', 'Saida 2', 'Horas Trabalhadas', 'Banco de Horas', 'Status', 'Observacao'];
      const registrosOrdenados = [...registrosMesGlobal].sort((a, b) => a.data.localeCompare(b.data));
      const linhasCSV = registrosOrdenados.map(item => {
        const h = item.horarios || [];
        const [ano, mes, dia] = item.data.split('-');
        const dataFmt = `${dia}/${mes}/${ano}`;

        let totalMinutos = 0;
        if (h[0] && h[1]) totalMinutos += (timeToMinutes(h[1]) - timeToMinutes(h[0]));
        if (h[2] && h[3]) totalMinutos += (timeToMinutes(h[3]) - timeToMinutes(h[2]));

        const hrsTrab = Math.floor(totalMinutos / 60);
        const minsTrab = totalMinutos % 60;
        const strTrabalhadas = `${String(hrsTrab).padStart(2, '0')}:${String(minsTrab).padStart(2, '0')}`;

        const saldoMinutos = totalMinutos - 480;
        const strBancoHoras = h.length >= 4 ? minutesToFormatted(saldoMinutos) : '--:--';
        const status = h.length >= 4 ? 'Validado' : 'Em andamento';
        const obs = (item.observacao || '').replace(/;/g, ',');

        return [
          dataFmt,
          h[0] || '--:--',
          h[1] || '--:--',
          h[2] || '--:--',
          h[3] || '--:--',
          strTrabalhadas,
          strBancoHoras,
          status,
          `"${obs}"`
        ].join(';');
      });

      const topoRelatorio = [
        `"PROJETO:";"${nomeProjeto}"`,
        `"FUNCIONÁRIO:";"${nome}"`,
        `"MÊS CORRESPONDENTE:";"${mesFormatado}"`,
        ''
      ];
      const conteudoCSV = '\uFEFF' + [
        ...topoRelatorio,
        cabeçalhoTabela.join(';'),
        ...linhasCSV
      ].join('\n');
      const blob = new Blob([conteudoCSV], { type: 'text/csv;charset=utf-8;' });
      const url = URL.createObjectURL(blob);
      const link = document.createElement('a');

      const agora = new Date();
      const pad = (n) => String(n).padStart(2, '0');
      const dataHoraLocal = `${agora.getFullYear()}-${pad(agora.getMonth() + 1)}-${pad(agora.getDate())}_${pad(agora.getHours())}-${pad(agora.getMinutes())}-${pad(agora.getSeconds())}`;

      const nomeSanitizado = nome.trim().replace(/\s+/g, '-');

      link.href = url;
      link.setAttribute('download', `Espelho-Ponto_${nomeSanitizado}_${mesAnoRaw}_${dataHoraLocal}.csv`);

      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      URL.revokeObjectURL(url);

    } catch (error) {
      console.error('Erro ao exportar CSV:', error);
      alert('Erro ao gerar o arquivo de exportação.');
    }
  }

  async function registrarPonto() {
    const btn = document.getElementById('btnBaterPonto');
    const feedback = document.getElementById('feedback');
    if (btn) btn.disabled = true;

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
      if (feedback) feedback.classList.remove('hidden');
      if (btn) btn.disabled = false;
    }
  }

  function abrirModalAjuste(pontoId) {
    const item = registrosMesGlobal.find(r => r.id === Number(pontoId));
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

  const btnBaterPonto = document.getElementById('btnBaterPonto');
  if (btnBaterPonto) btnBaterPonto.addEventListener('click', () => registrarPonto());

  const btnFecharToast = document.getElementById('btnFecharToast');
  if (btnFecharToast) btnFecharToast.addEventListener('click', fecharToast);

  const btnFecharModal = document.getElementById('btnFecharModal');
  if (btnFecharModal) btnFecharModal.addEventListener('click', fecharModal);

  const formAjustarDia = document.getElementById('formAjustarDia');
  if (formAjustarDia) formAjustarDia.addEventListener('submit', salvarAjusteDia);

  const btnFiltrar = document.getElementById('btnFiltrarPonto');
  if (btnFiltrar) btnFiltrar.addEventListener('click', () => loadUserData(inputFiltro?.value));

  const btnExportar = document.getElementById('btnExportarExcel');
  if (btnExportar) btnExportar.addEventListener('click', exportarParaExcel);

  const tabelaContainer = document.getElementById('tabelaLinhasDias');
  if (tabelaContainer) {
    tabelaContainer.addEventListener('click', (e) => {
      const btn = e.target.closest('button');
      if (!btn) return;

      const action = btn.getAttribute('data-action');
      const id = btn.getAttribute('data-id');

      if (action === 'editar') {
        abrirModalAjuste(id);
      } else if (action === 'deletar') {
        apagarRegistroPonto(id);
      }
    });
  }

  loadUserData();
});
