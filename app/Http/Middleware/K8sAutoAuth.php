<?php
namespace App\Http\Middleware;
use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class K8sAutoAuth
{
    /**
     * Trata a requisição interceptada pelo Kubernetes.
     */
    public function handle(Request $request, Closure $next)
    {

        $email = $request->header('X-Auth-Request-Email');
        $name = $request->header('X-Auth-Request-Preferred-Username') ?? 'Usuário';


        if (!$email) {
            abort(401, 'Acesso não autorizado. Por favor, faça login através do portal.');
        }

        // 2. Busca o usuário no PostgreSQL. Se não existir, cadastra na hora!
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                // Como o login é gerenciado pelo Kubernetes, salvamos uma senha segura aleatória no banco
                'password' => bcrypt(Str::random(24))
            ]
        );
        Auth::login($user);
        return $next($request);
    }
}
