<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;
use Throwable;

class AuthController extends Controller
{
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
        new OA\Property(property: 'email', type: 'string', example: 'devebsjunior@gmail.com'),
        new OA\Property(property: 'password', type: 'string', example: '123456')
      ]
    )
  )]
  #[OA\Response(response: 200, description: 'Login efetuado com sucesso')]
  #[OA\Response(response: 401, description: 'E-mail ou senha inválidos')]
  public function login(Request $request): JsonResponse
  {
    try {
      $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
      ]);

      $credentials = $request->only('email', 'password');

      if (! $token = Auth::guard('api')->attempt($credentials)) {
        return response()->json(['message' => 'E-mail ou senha inválidos'], 401);
      }

      /** @var \Tymon\JWTAuth\JWTGuard $guard */
      $guard = Auth::guard('api');

      return response()->json([
        'message' => 'Login efetuado com sucesso',
        'token' => $token,
        'token_type' => 'bearer',
        'expires_in' => $guard->factory()->getTTL() * 60,
        'user' => $guard->user()
      ], 200);
    } catch (Throwable $e) {
      Log::error('[AUTH ERROR] ' . $e->getMessage());
      return response()->json([
        'message' => 'Erro interno no servidor (500): ' . $e->getMessage()
      ], 500);
    }
  }

  public function logout(): JsonResponse
  {
    try {
      Auth::guard('api')->logout();
      return response()->json(['message' => 'Logout efetuado com sucesso']);
    } catch (Throwable $e) {
      return response()->json(['message' => 'Erro ao realizar logout'], 500);
    }
  }
}
