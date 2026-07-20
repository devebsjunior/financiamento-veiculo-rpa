<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>Login - Financiamento de Veículos</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-100">

    <div class="min-h-screen flex items-center justify-center">

        <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">

            <div class="text-center mb-8">

                <h1 class="text-3xl font-bold text-slate-800">
                    Financiamento
                </h1>

                <p class="text-slate-500 mt-2">
                    Sistema de Gestão de Veículos
                </p>

            </div>

            <form
                id="loginForm"
                class="space-y-4"
            >

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="usuario@email.com"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Senha
                    </label>

                    <input
                        type="password"
                        id="password"
                        class="w-full border border-slate-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="********"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition"
                >
                    Entrar
                </button>

            </form>

            <div
                id="erro"
                class="hidden mt-4 bg-red-100 text-red-700 p-3 rounded"
            ></div>

        </div>

    </div>

    <script>
        document
            .getElementById('loginForm')
            .addEventListener('submit', async function(e) {
                e.preventDefault();
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        email: document.getElementById('email').value,
                        password: document.getElementById('password').value
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    localStorage.setItem(
                        'token',
                        data.token
                    );
                    window.location.href = '/dashboard';
                } else {
                    document
                        .getElementById('erro')
                        .classList
                        .remove('hidden');
                    document
                        .getElementById('erro')
                        .innerHTML = data.message;
                }
            });
    </script>
</body>

</html>
