@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
    <div class="space-y-6 p-6">
        <!-- Cabeçalho: Título e Botão lado a lado -->
        <div class="flex justify-between items-center pb-4 border-b border-slate-200">
            <h1 class="text-3xl font-bold text-slate-800">Clientes</h1>
            <a
                href="/clientes/create"
                class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-sm text-sm font-medium group"
            >
                <i class="fa-solid fa-plus text-xs text-blue-200 group-hover:text-white transition-colors"></i>
                Novo Cliente
            </a>
        </div>

        <!-- Container da Tabela com cantos arredondados e sombra -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="text-left p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16">ID</th>
                        <th class="text-left p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nome</th>
                        <th class="text-left p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">CPF</th>
                        <th class="text-left p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Telefone</th>
                        <th class="text-left p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">E-mail</th>
                        <th class="text-center p-4 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24">Ações</th>
                    </tr>
                </thead>
                <tbody
                    id="clientesTable"
                    class="divide-y divide-slate-100"
                >
                    <tr>
                        <td
                            colspan="6"
                            class="p-8 text-center text-slate-400 text-sm"
                        >
                            <span class="inline-flex items-center gap-2.5">
                                <!-- Spinner animado nativo do FontAwesome -->
                                <i class="fa-solid fa-circle-notch animate-spin text-blue-500 text-base"></i>
                                Carregando clientes...
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        async function carregarClientes() {
            const token = localStorage.getItem('token');
            const tbody = document.getElementById('clientesTable');

            try {
                const response = await fetch('/api/clientes', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Falha ao buscar dados.');
                }

                const clientes = await response.json();
                tbody.innerHTML = '';

                if (clientes.length === 0) {
                    tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400 text-sm">
                            <div class="flex flex-col items-center gap-2 py-4">
                                <i class="fa-solid fa-folder-open text-3xl text-slate-300"></i>
                                <span>Nenhum cliente cadastrado.</span>
                            </div>
                        </td>
                    </tr>
                `;
                    return;
                }

                clientes.forEach(cliente => {
                    tbody.innerHTML += `
                    <tr class="text-slate-700 hover:bg-slate-50/80 transition duration-150">
                        <td class="p-4 text-sm font-semibold text-slate-400">${cliente.id}</td>
                        <td class="p-4 text-sm font-medium text-slate-900">${cliente.nome ?? ''}</td>
                        <td class="p-4 text-sm text-slate-600 font-mono">${cliente.cpf ?? ''}</td>
                        <td class="p-4 text-sm text-slate-600">${cliente.telefone ?? ''}</td>
                        <td class="p-4 text-sm text-slate-600">${cliente.email ?? ''}</td>
                        <td class="p-4 text-center">
                            <!-- Botão de Editar estilizado de verdade -->
                            <a
                                href="/clientes/${cliente.id}/edit"
                                class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 px-2.5 py-1.5 rounded-md hover:bg-blue-50 hover:text-blue-600 text-xs font-semibold transition-all border border-slate-200 hover:border-blue-200"
                            >
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                Editar
                            </a>
                        </td>
                    </tr>
                `;
                });

            } catch (error) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="p-8 text-center text-red-500 text-sm font-medium">
                        <div class="flex flex-col items-center gap-2 py-2">
                            <i class="fa-solid fa-circle-exclamation text-2xl text-red-400"></i>
                            <span>Erro ao carregar os dados. Verifique sua autenticação.</span>
                        </div>
                    </td>
                </tr>
            `;
            }
        }

        carregarClientes();
    </script>
@endsection
