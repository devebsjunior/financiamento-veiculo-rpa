@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
    <div class="space-y-4 p-4 max-w-6xl mx-auto w-full">
        <!-- Cabeçalho Alinhado -->
        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Usuários</h1>
            </div>
            <div class="flex gap-2">
                <!-- Botão Exportar Excel -->
                <button
                    onclick="exportarExcel()"
                    class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-emerald-700 transition flex items-center gap-1.5 shadow-sm"
                >
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        ></path>
                    </svg>
                    Exportar XLS
                </button>
                <a
                    href="/users/create"
                    class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-blue-700 transition shadow-sm"
                >
                    Novo Usuário
                </a>
            </div>
        </div>

        <!-- Tabela Corporativa Limpa -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden w-full">
            <table class="w-full border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left p-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nome</th>
                        <th class="text-left p-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">E-mail</th>
                        <th class="text-center p-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status
                        </th>
                        <th class="text-center p-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody
                    id="usersTable"
                    class="divide-y divide-slate-100"
                >
                    <tr>
                        <td
                            colspan="4"
                            class="p-8 text-center text-slate-400 text-xs"
                        >
                            Carregando usuários...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        async function carregarUsuarios() {
            const token = localStorage.getItem('token');
            const tbody = document.getElementById('usersTable');

            try {
                const response = await fetch('/api/users', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Falha na autenticação.');

                const usuarios = await response.json();
                tbody.innerHTML = '';

                usuarios.forEach(user => {
                    const statusBadge = user.ativo ?
                        `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Ativo</span>` :
                        `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-50 text-slate-600 border border-slate-200">Inativo</span>`;

                    tbody.innerHTML += `
                    <tr class="text-slate-700 hover:bg-slate-50 transition duration-150">
                        <td class="p-3 text-xs font-medium text-slate-900">${user.nome}</td>
                        <td class="p-3 text-xs text-slate-600">${user.email}</td>
                        <td class="p-3 text-xs text-center">${statusBadge}</td>
                        <td class="p-3 text-xs text-center">
                            <a href="/users/${user.id}/edit" class="text-blue-600 hover:text-blue-800 font-semibold hover:underline">
                                Editar
                            </a>
                        </td>
                    </tr>
                `;
                });
            } catch (error) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="p-6 text-center text-red-500 text-xs font-medium">
                        Erro ao carregar usuários. Faça login novamente.
                    </td>
                </tr>
            `;
            }
        }

        async function exportarExcel() {
            const token = localStorage.getItem('token');

            try {
                const response = await fetch('/api/users/export', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!response.ok) throw new Error('Erro ao gerar planilha.');

                const blob = await response.blob();
                const url = window.URL.createObjectURL(blob);
                const agora = new Date();
                const pad = (n) => String(n).padStart(2, '0');
                const dataHoraLocal =
                    `${agora.getFullYear()}-${pad(agora.getMonth() + 1)}-${pad(agora.getDate())}_${pad(agora.getHours())}-${pad(agora.getMinutes())}-${pad(agora.getSeconds())}`;

                const nomeArquivo = `Lista-de-usuarios-Financiamento-Veiculo-RPA-_${dataHoraLocal}.xlsx`;

                const a = document.createElement('a');
                a.href = url;
                a.download = nomeArquivo; // Define o nome limpo e com a hora correta no browser
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);

            } catch (error) {
                alert('Falha ao exportar arquivo XLS: ' + error.message);
            }
        }
        carregarUsuarios();
    </script>
@endsection
