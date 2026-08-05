<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\CryptoServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private CryptoServiceInterface $cryptoService,
        private TokenServiceInterface $tokenService
    ) {}

    #[OA\Post(
        path: '/api/login',
        operationId: 'login',
        tags: ['Autenticação'],
        summary: 'Autenticar utilizador'
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['email', 'password'],
            properties: [
                new OA\Property(
                    property: 'email',
                    type: 'string',
                    example: 'usuario@email.com'
                ),
                new OA\Property(
                    property: 'password',
                    type: 'string',
                    example: '123456'
                )
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Login efetuado com sucesso'
    )]
    #[OA\Response(
        response: 401,
        description: 'E-mail ou palavra-passe inválidos'
    )]
    #[OA\Response(
        response: 403,
        description: 'Conta desativada'
    )]
    public function login(Request $request): JsonResponse
    {
        Log::info('[AUTH DEBUG] Tentativa de login iniciada', ['email' => $request->input('email')]);

        try {
            // 1. Validar dados da requisição
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $credentials = $request->only('email', 'password');

            Log::info('[AUTH DEBUG] A tentar autenticação via guard api (JWT)...');

            // 2. Tentar autenticar o utilizador com o Guard de API/JWT
            if (! $token = Auth::guard('api')->attempt($credentials)) {
                Log::warning('[AUTH DEBUG] Falha de autenticação: credenciais inválidas', ['email' => $request->input('email')]);
                return response()->json(['error' => 'E-mail ou palavra-passe inválidos'], 401);
            }

            Log::info('[AUTH DEBUG] Login efetuado com sucesso!', ['email' => $request->input('email')]);

            // Anotação PHPDoc para o Intelephense reconhecer os métodos do JWTGuard
            /** @var \Tymon\JWTAuth\JWTGuard $guard */
            $guard = Auth::guard('api');

            // 3. Retornar resposta com Token e dados do Utilizador
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $guard->factory()->getTTL() * 60,
                'user' => $guard->user()
            ]);

        } catch (Throwable $e) {
            // Regista o erro completo no log do Laravel
            Log::error('[AUTH ERROR 500] Exceção apanhada durante o login: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Retorna a exceção detalhada no corpo da resposta 500 para visualização imediata no F12
            return response()->json([
                'error' => 'Erro interno no servidor (500)',
                'exception_message' => $e->getMessage(),
                'exception_file' => $e->getFile(),
                'exception_line' => $e->getLine(),
            ], 500);
        }
    }

    /**
     * Encerrar a sessão do utilizador e revogar o Token.
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'message' => 'Logout efetuado com sucesso. Token revogado.'
            ], 200);
        } catch (Throwable $e) {
            Log::error('[AUTH ERROR] Erro no logout: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao encerrar a sessão'], 500);
        }
    }
}
