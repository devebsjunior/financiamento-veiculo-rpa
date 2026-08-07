<?php

namespace App\Http\Middleware;

use App\Services\TokenServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'Token de acesso não fornecido.'
            ], 401);
        }

        if (!$this->tokenService->validateToken($token)) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'Token inválido ou expirado.'
            ], 401);
        }
        try {
            $user = JWTAuth::setToken($token)->authenticate();
            if (!$user instanceof \Illuminate\Contracts\Auth\Authenticatable) {
                throw new Exception("Usuário inválido no token.");
            }
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


