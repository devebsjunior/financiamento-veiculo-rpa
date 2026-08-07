<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>@yield('title')</title>

    <!-- FontAwesome Font Icon -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

    @vite(['resources/css/app.css', 'resources/js/auth-guard.js'])
</head>

<body class="bg-slate-100">

    <div class="flex h-screen overflow-hidden">

        <!-- ASIDE: BARRA LATERAL RECOLHÍVEL -->
        <aside
            id="sidebar"
            class="w-64 bg-slate-900 text-white flex flex-col justify-between shadow-xl transition-all duration-300 ease-in-out relative z-30 flex-shrink-0 h-full"
        >
            <div>
                <!-- CABEÇALHO DA SIDEBAR COM BOTÃO TOGGLE -->
                <div
                    class="p-4 h-16 border-b border-slate-800 flex items-center justify-between text-indigo-400 overflow-hidden">
                    <div class="flex items-center gap-3 min-w-max">
                        <i class="fa-solid fa-chart-pie text-2xl"></i>
                        <span class="text-white tracking-wide font-bold text-xl sidebar-text">Gestão Car</span>
                    </div>

                    <button
                        id="btnToggleSidebar"
                        title="Recolher/Expandir Menu"
                        class="text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-slate-800 transition-colors cursor-pointer"
                    >
                        <i
                            id="iconToggleSidebar"
                            class="fa-solid fa-chevron-left text-sm transition-transform duration-300"
                        ></i>
                    </button>
                </div>

                <!-- MENU DE NAVEGAÇÃO -->
                <nav class="p-3 space-y-1.5 overflow-y-auto">

                    <a
                        href="/dashboard"
                        class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                        title="Dashboard"
                    >
                        <i
                            class="fa-solid fa-gauge-high text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                        <span class="font-medium text-sm sidebar-text whitespace-nowrap">Dashboard</span>
                    </a>

                    <a
                        href="/clientes"
                        class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                        title="Clientes"
                    >
                        <i
                            class="fa-solid fa-users text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                        <span class="font-medium text-sm sidebar-text whitespace-nowrap">Clientes</span>
                    </a>

                    <a
                        href="/veiculos"
                        class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                        title="Veículos"
                    >
                        <i
                            class="fa-solid fa-car text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                        <span class="font-medium text-sm sidebar-text whitespace-nowrap">Veículos</span>
                    </a>

                    <a
                        href="/financiamentos"
                        class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                        title="Financiamentos"
                    >
                        <i
                            class="fa-solid fa-file-invoice-dollar text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                        <span class="font-medium text-sm sidebar-text whitespace-nowrap">Financiamentos</span>
                    </a>

                    <a
                        href="/users"
                        class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                        title="Usuários"
                    >
                        <i
                            class="fa-solid fa-user-shield text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                        <span class="font-medium text-sm sidebar-text whitespace-nowrap">Usuários</span>
                    </a>

                    <a
                        href="/ponto"
                        class="flex items-center gap-3 p-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors group"
                        title="Controle de Ponto"
                    >
                        <i
                            class="fa-solid fa-clock text-slate-400 group-hover:text-indigo-400 w-5 text-center transition-colors"></i>
                        <span class="font-medium text-sm sidebar-text whitespace-nowrap">Controle de Ponto</span>
                    </a>

                </nav>
            </div>

            <!-- RODAPÉ DA SIDEBAR: BOTÃO SAIR (SEMPRE FIXO NA BASE) -->
            <div class="p-3 border-t border-slate-800 bg-slate-950/40 mt-auto">
                <button
                    onclick="executarLogout()"
                    class="w-full flex items-center gap-3 p-3 rounded-lg text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-colors group text-left font-medium text-sm overflow-hidden"
                    title="Sair do Sistema"
                >
                    <i
                        class="fa-solid fa-right-from-bracket text-rose-400/80 group-hover:text-rose-400 w-5 text-center transition-colors shrink-0"></i>
                    <span class="sidebar-text whitespace-nowrap">Sair do Sistema</span>
                </button>
            </div>

        </aside>

        <!-- ÁREA PRINCIPAL DE CONTEÚDO COM ROLAGEM INDEPENDENTE -->
        <main class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>

    </div>

    <!-- SCRIPT DE MANIPULAÇÃO DA SIDEBAR E LOGOUT -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const btnToggle = document.getElementById('btnToggleSidebar');
            const iconToggle = document.getElementById('iconToggleSidebar');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
            if (isCollapsed) {
                aplicarModoEncolhido(true);
            }
            btnToggle.addEventListener('click', () => {
                const recolher = !sidebar.classList.contains('w-20');
                aplicarModoEncolhido(recolher);
                localStorage.setItem('sidebar_collapsed', recolher);
            });
            function aplicarModoEncolhido(recolher) {
                if (recolher) {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    iconToggle.classList.add('rotate-180');
                    sidebarTexts.forEach(el => el.classList.add('hidden'));
                } else {
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    iconToggle.classList.remove('rotate-180');
                    sidebarTexts.forEach(el => el.classList.remove('hidden'));
                }
            }
        });

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

    @stack('scripts')
</body>

</html>
