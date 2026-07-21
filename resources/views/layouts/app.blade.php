<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>@yield('title')</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-slate-900 text-white flex flex-col shadow-xl">

            <div class="p-6 text-xl font-bold border-b border-slate-800 flex items-center gap-3 text-indigo-400">
                <i class="fa-solid fa-chart-pie text-2xl"></i>
                <span class="text-white tracking-wide">Gestão Car</span>
            </div>

            <nav class="p-4 space-y-1.5 flex-1">

                <a
                    href="/dashboard"
                    class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                >
                    <i
                        class="fa-solid fa-gauge-high text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <a
                    href="/clientes"
                    class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                >
                    <i
                        class="fa-solid fa-users text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                    <span class="font-medium text-sm">Clientes</span>
                </a>

                <a
                    href="/veiculos"
                    class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                >
                    <i
                        class="fa-solid fa-car text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                    <span class="font-medium text-sm">Veículos</span>
                </a>

                <a
                    href="/financiamentos"
                    class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                >
                    <i
                        class="fa-solid fa-file-invoice-dollar text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                    <span class="font-medium text-sm">Financiamentos</span>
                </a>

                <a
                    href="/usuarios"
                    class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                >
                    <i
                        class="fa-solid fa-user-shield text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                    <span class="font-medium text-sm">Usuários</span>
                </a>

            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-950/40">
                <button
                    onclick="executarLogout()"
                    class="w-full flex items-center gap-3 p-3 rounded-lg text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-colors group text-left font-medium text-sm"
                >
                    <i
                        class="fa-solid fa-right-from-bracket text-rose-400/80 group-hover:text-rose-400 w-5 text-center transition-colors"></i>
                    Sair do Sistema
                </button>
            </div>

        </aside>

        <main class="flex-1 p-8">

            @yield('content')

        </main>

    </div>

    <script>
        async function executarLogout() {
            if (window.alertService) {
                const confirmou = await window.alertService.confirm(
                    'Deseja realmente sair?',
                    'Você precisará autenticar novamente para acessar o sistema.'
                );
                if (!confirmou) return;
            }
            const token = localStorage.getItem('token');
            try {
                await fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });
            } catch (error) {
                console.error('Erro ao revogar token no servidor:', error);
            } finally {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.href = '/login';
            }
        }
    </script>

</body>

</html>
