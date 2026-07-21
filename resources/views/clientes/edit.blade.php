@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
    <div class="p-6 max-w-5xl mx-auto w-full">
        <!-- Cabeçalho Principal -->
        <div class="flex justify-between items-center pb-4 mb-6 border-b border-slate-200">
            <h1 class="text-3xl font-bold text-slate-800">Editar Cliente</h1>
            <a
                href="/clientes"
                class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 border border-slate-300 px-4 py-2 rounded-lg text-sm font-medium bg-white shadow-sm transition hover:bg-slate-50"
            >
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Voltar
            </a>
        </div>

        <!-- Container do Formulário -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden w-full">
            <form
                id="editClienteForm"
                onsubmit="atualizarCliente(event)"
                class="p-6 space-y-6"
            >

                <!-- Alerta de Erro Dinâmico -->
                <div
                    id="errorAlert"
                    class="hidden bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg text-sm font-medium flex items-center gap-2"
                >
                    <i class="fa-solid fa-circle-exclamation text-base"></i>
                    <span id="errorAlertText">Preencha todos os campos obrigatórios.</span>
                </div>

                <!-- GRID PRINCIPAL -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 w-full">

                    <!-- COLUNA DA ESQUERDA: Dados Pessoais & Contato -->
                    <div class="space-y-6">
                        <div>
                            <h2
                                class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-blue-600"></span> Dados Pessoais
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nome Completo <span
                                            class="text-red-500"
                                        >*</span></label>
                                    <input
                                        type="text"
                                        name="nome"
                                        required
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                        placeholder="Ex: Edson Belém"
                                    >
                                </div>

                                <div class="flex gap-4">
                                    <div class="w-1/2">
                                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">CPF <span
                                                class="text-red-500"
                                            >*</span></label>
                                        <input
                                            type="text"
                                            name="cpf"
                                            required
                                            maxlength="14"
                                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                            placeholder="000.000.000-00"
                                        >
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nascimento <span
                                                class="text-red-500"
                                            >*</span></label>
                                        <input
                                            type="date"
                                            name="data_nascimento"
                                            required
                                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <h2
                                class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-1.5">
                                <span class="h-2 w-2 rounded-full bg-blue-600"></span> Contato
                            </h2>
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Telefone <span
                                            class="text-red-500"
                                        >*</span></label>
                                    <input
                                        type="text"
                                        name="telefone"
                                        required
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                        placeholder="(24) 99999-9999"
                                    >
                                </div>
                                <div class="w-1/2">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">E-mail <span
                                            class="text-red-500"
                                        >*</span></label>
                                    <input
                                        type="email"
                                        name="email"
                                        required
                                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                        placeholder="exemplo@gmail.com"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- COLUNA DA DIREITA: Endereço -->
                    <div class="space-y-4 md:border-l md:border-slate-100 md:pl-8">
                        <h2
                            class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-1.5">
                            <span class="h-2 w-2 rounded-full bg-blue-600"></span> Endereço
                        </h2>

                        <div class="flex gap-4">
                            <div class="w-1/3">
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">CEP <span
                                        class="text-red-500"
                                    >*</span></label>
                                <input
                                    type="text"
                                    name="cep"
                                    required
                                    maxlength="8"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                    placeholder="27510000"
                                >
                            </div>
                            <div class="w-2/3">
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Bairro <span
                                        class="text-red-500"
                                    >*</span></label>
                                <input
                                    type="text"
                                    name="bairro"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                    placeholder="Centro"
                                >
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-3/4">
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Logradouro (Rua) <span
                                        class="text-red-500"
                                    >*</span></label>
                                <input
                                    type="text"
                                    name="logradouro"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                    placeholder="Rua das Flores"
                                >
                            </div>
                            <div class="w-1/4">
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Número <span
                                        class="text-red-500"
                                    >*</span></label>
                                <input
                                    type="text"
                                    name="numero"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                    placeholder="123"
                                >
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-3/4">
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cidade <span
                                        class="text-red-500"
                                    >*</span></label>
                                <input
                                    type="text"
                                    name="cidade"
                                    required
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                    placeholder="Resende"
                                >
                            </div>
                            <div class="w-1/4">
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">UF <span
                                        class="text-red-500"
                                    >*</span></label>
                                <input
                                    type="text"
                                    name="uf"
                                    required
                                    maxlength="2"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition shadow-sm"
                                    placeholder="RJ"
                                >
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Rodapé Uniforme -->
                <div
                    class="flex justify-end items-center gap-3 pt-4 border-t border-slate-100 bg-slate-50 -mx-6 -mb-6 p-4">
                    <a
                        href="/clientes"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200 rounded-lg transition"
                    >
                        <i class="fa-solid fa-xmark text-xs text-slate-400"></i>
                        Cancelar
                    </a>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium shadow-sm transition"
                    >
                        <i class="fa-solid fa-floppy-disk text-xs text-blue-200"></i>
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const urlParts = window.location.pathname.split('/');
        const clienteId = urlParts[urlParts.length - 2];
        const token = localStorage.getItem('token');

        document.addEventListener('DOMContentLoaded', () => {
            const cepInput = document.querySelector('input[name="cep"]');
            if (cepInput) {
                cepInput.addEventListener('blur', async (event) => {
                    const valorCep = event.target.value.replace(/\D/g, '');
                    if (valorCep.length === 8) {
                        try {
                            const response = await fetch(`https://viacep.com.br/ws/${valorCep}/json/`);
                            const data = await response.json();
                            if (!data.erro) {
                                document.querySelector('input[name="logradouro"]').value = data
                                    .logradouro;
                                document.querySelector('input[name="bairro"]').value = data.bairro;
                                document.querySelector('input[name="cidade"]').value = data.localidade;
                                document.querySelector('input[name="uf"]').value = data.uf;
                            }
                        } catch (e) {
                            console.error("Erro na busca do CEP:", e);
                        }
                    }
                });
            }
            buscarDadosDoCliente();
        });

        async function buscarDadosDoCliente() {
            try {
                const response = await fetch(`/api/clientes/${clienteId}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();
                if (!response.ok) throw new Error(result.message || 'Erro ao carregar dados.');

                const cliente = result.data || result;
                document.querySelector('input[name="nome"]').value = cliente.nome ?? '';
                document.querySelector('input[name="cpf"]').value = cliente.cpf ?? '';
                document.querySelector('input[name="data_nascimento"]').value = cliente.data_nascimento ?? '';
                document.querySelector('input[name="telefone"]').value = cliente.telefone ?? '';
                document.querySelector('input[name="email"]').value = cliente.email ?? '';
                document.querySelector('input[name="cep"]').value = cliente.cep ?? '';
                document.querySelector('input[name="bairro"]').value = cliente.bairro ?? '';
                document.querySelector('input[name="logradouro"]').value = cliente.logradouro ?? '';
                document.querySelector('input[name="numero"]').value = cliente.numero ?? '';
                document.querySelector('input[name="cidade"]').value = cliente.cidade ?? '';
                document.querySelector('input[name="uf"]').value = cliente.uf ?? '';

            } catch (error) {
                if (window.alertService) {
                    window.alertService.error('Erro!', 'Não foi possível recuperar os dados do cliente.');
                }
            }
        }

        async function atualizarCliente(event) {
            event.preventDefault();
            const form = event.target;
            const errorAlert = document.getElementById('errorAlert');
            const errorAlertText = document.getElementById('errorAlertText');
            errorAlert.classList.add('hidden');

            const inputs = form.querySelectorAll('input[required]');
            let formularioValido = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    formularioValido = false;
                    input.classList.add('border-red-400', 'focus:ring-red-500', 'focus:border-red-500');
                } else {
                    input.classList.remove('border-red-400', 'focus:ring-red-500', 'focus:border-red-500');
                }
            });

            if (!formularioValido) {
                errorAlertText.textContent =
                    'Por favor, preencha todos os campos obrigatórios marcados com asterisco (*).';
                errorAlert.classList.remove('hidden');
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                return;
            }

            const formData = new FormData(form);
            const dados = Object.fromEntries(formData.entries());

            try {
                const response = await fetch(`/api/clientes/${clienteId}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(dados)
                });

                const result = await response.json();
                if (!response.ok) throw new Error(result.message || 'Erro ao atualizar dados.');

                // ========================================================
                // IMPEDINDO O HELPER COMPLEXO DE QUEBRAR O FLUXO
                // ========================================================
                if (window.Swal) {
                    // Abre o modal estilizado usando a instância global injetada pelo Vite
                    await window.Swal.fire({
                        title: 'Sucesso!',
                        text: 'Os dados do cliente foram alterados com sucesso.',
                        icon: 'success',
                        confirmButtonColor: '#2563eb', // Azul premium do painel
                        confirmButtonText: 'ok',
                        allowOutsideClick: false
                    });
                } else if (window.alertService && typeof window.alertService.success === 'function') {
                    await window.alertService.success('Sucesso!', 'Os dados do cliente foram alterados com sucesso.');
                } else {
                    alert('Os dados do cliente foram alterados com sucesso.');
                }

                // O redirecionamento aguarda a confirmação do modal acima
                window.location.href = '/clientes';

            } catch (error) {
                // Se houver algum erro real na API, exibe no banner vermelho
                errorAlertText.textContent = error.message;
                errorAlert.classList.remove('hidden');
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }
    </script>


@endsection
