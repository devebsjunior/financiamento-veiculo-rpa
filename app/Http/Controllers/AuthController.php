<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\CryptoServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use OpenApi\Attributes as OA;

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
        summary: 'Autenticar usuário'
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
        description: 'E-mail ou senha inválidos'
    )]
    #[OA\Response(
        response: 403,
        description: 'Conta desativada'
    )]
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);


        $user = $this->userRepository->buscarPorEmail($request->email);

        if (!$user || !$this->cryptoService->verify($request->password, $user->password)) {
            return response()->json([
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'E-mail ou senha incorretos.'
            ], 401);
        }


        if (!$user->ativo) {
            return response()->json([
                'status' => 403,
                'error' => 'Forbidden',
                'message' => 'Esta conta está desativada.'
            ], 403);
        }


        $token = $this->tokenService->generateToken($user);

        return response()->json([
            'message' => 'Login efetuado com sucesso',
            'user' => $user,
            'token' => $token
        ], 200);
    }


    public function logout(): JsonResponse
    {

        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Logout efetuado com sucesso. Token revogado.'
        ], 200);
    }
}
