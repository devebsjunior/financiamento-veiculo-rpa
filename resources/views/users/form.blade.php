@extends('layouts.app')

@section('title', isset($id) ? 'Editar Usuário' : 'Novo Usuário')

@section('content')
<div class="p-4 max-w-2xl mx-auto w-full">
    <div class="flex justify-between items-center pb-3 mb-6 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-800" id="formTitle">
                {{ isset($id) ? 'Editar Usuário' : 'Novo Usuário' }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">Preencha os campos abaixo para {{ isset($id) ? 'atualizar o' : 'cadastrar um novo' }} usuário.</p>
        </div>
        <a href="/users" class="bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-slate-200 transition shadow-sm">
            Voltar
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div id="alertMessage" class="hidden mb-4 p-3 rounded-lg text-xs font-medium"></div>

        <form id="userForm" onsubmit="salvarUsuario(event)" class="space-y-4">
            <input type="hidden" id="userId" value="{{ $id ?? '' }}">

            <div>
                <label for="nome" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Nome Completo <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nome" required
                    class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-800 placeholder-slate-400"
                    placeholder="Ex: Edson Belém">
            </div>

            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    E-mail <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" required
                    class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-800 placeholder-slate-400"
                    placeholder="Ex: edson@gmail.com">
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Senha <span id="passRequiredMark" class="text-red-500">*</span>
                </label>
                <input type="password" id="password" minlength="6"
                    class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-800 placeholder-slate-400"
                    placeholder="Mínimo de 6 caracteres">
                <p id="passHelpText" class="text-[11px] text-slate-400 mt-1 hidden">Deixe em branco caso não queira alterar a senha atual.</p>
            </div>

            <div class="pt-2">
                <label class="inline-flex items-center cursor-pointer gap-2">
                    <input type="checkbox" id="ativo" class="w-4 h-4 text-blue-600 border-slate-300 rounded focus:ring-blue-500" checked>
                    <span class="text-xs font-semibold text-slate-700">Usuário Ativo</span>
                </label>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <a href="/usuarios" class="bg-slate-100 text-slate-600 px-4 py-2 rounded-lg text-xs font-medium hover:bg-slate-200 transition">
                    Cancelar
                </a>
                <button type="submit" id="btnSubmit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-xs font-medium hover:bg-blue-700 transition shadow-sm flex items-center gap-1.5">
                    <span>Salvar</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const userId = document.getElementById('userId').value;
    const isEdit = !!userId;
    if (isEdit) {
        document.getElementById('passRequiredMark').classList.add('hidden');
        document.getElementById('passHelpText').classList.remove('hidden');
        document.getElementById('password').removeAttribute('required');
        carregarDadosUsuario();
    } else {
        document.getElementById('password').setAttribute('required', 'required');
    }
    async function carregarDadosUsuario() {
        const token = localStorage.getItem('token');
        try {
            const response = await fetch(`/api/users/${userId}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Não foi possível carregar os dados do usuário.');

            const user = await response.json();
            document.getElementById('nome').value = user.nome;
            document.getElementById('email').value = user.email;
            document.getElementById('ativo').checked = !!user.ativo;
        } catch (error) {
            exibirAlerta(error.message, 'error');
        }
    }
    async function salvarUsuario(event) {
        event.preventDefault();
        const token = localStorage.getItem('token');
        const btnSubmit = document.getElementById('btnSubmit');
        btnSubmit.disabled = true;
        const payload = {
            nome: document.getElementById('nome').value,
            email: document.getElementById('email').value,
            ativo: document.getElementById('ativo').checked
        };
        const password = document.getElementById('password').value;
        if (password) {
            payload.password = password;
        }
        const url = isEdit ? `/api/users/${userId}` : '/api/users';
        const method = isEdit ? 'PUT' : 'POST';
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await response.json();
            if (!response.ok) {
                if (data.errors) {
                    const primeiroErro = Object.values(data.errors)[0][0];
                    throw new Error(primeiroErro);
                }
                throw new Error(data.message || 'Erro ao processar requisição.');
            }
            exibirAlerta(data.message || 'Salvo com sucesso!', 'success');
            setTimeout(() => {
                window.location.href = '/users';
            }, 1500);
        } catch (error) {
            exibirAlerta(error.message, 'error');
            btnSubmit.disabled = false;
        }
    }

    function exibirAlerta(mensagem, tipo) {
        const alertBox = document.getElementById('alertMessage');
        alertBox.classList.remove('hidden', 'bg-red-50', 'text-red-700', 'border', 'border-red-200', 'bg-emerald-50', 'text-emerald-700', 'border-emerald-200');

        if (tipo === 'error') {
            alertBox.classList.add('bg-red-50', 'text-red-700', 'border', 'border-red-200');
        } else {
            alertBox.classList.add('bg-emerald-50', 'text-emerald-700', 'border', 'border-emerald-200');
        }

        alertBox.innerText = mensagem;
    }
</script>
@endsection
