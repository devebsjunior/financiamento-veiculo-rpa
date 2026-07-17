<?php

namespace App\Http\Middleware;

use App\Services\Contracts\TokenServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // <-- Mudamos para o objeto de resposta JSON nativo do Laravel
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class JwtInterceptorMiddleware
{
    public function __construct(
        private TokenServiceInterface $tokenService
    ) {}

    /**
     * Alteramos a assinatura do retorno para JsonResponse ou o fechamento do pipeline ($next).
     * Isso resolve 100% o erro do "response".
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        // 1. Extrai o token do cabeçalho Authorization: Bearer XXXXX
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'Token de acesso não fornecido.'
            ], 401);
        }

        // 2. Valida o token usando o nosso serviço isolado (igual JwtTokenUtil)
        if (!$this->tokenService->validateToken($token)) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'Token inválido ou expirado.'
            ], 401);
        }

        try {
            // 3. Autentica o usuário no contexto de segurança do Laravel
            $user = JWTAuth::setToken($token)->authenticate();

            // Evita o erro no $user: Garante para a IDE que encontramos um modelo de usuário válido antes de injetar
            if (!$user instanceof \Illuminate\Contracts\Auth\Authenticatable) {
                throw new Exception("Usuário inválido no token.");
            }

            // Injeta o usuário autenticado explicitamente no guard da API
            Auth::guard('api')->setUser($user);

        } catch (Exception $e) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'Falha ao processar credenciais de segurança.'
            ], 401);
        }

        return $next($request);
    }
}


