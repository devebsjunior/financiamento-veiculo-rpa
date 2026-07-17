<?php

namespace App\Http\Controllers;

use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Injeção sênior baseada na Interface do Serviço (Igual ao Spring @Autowired)
     */
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    /**
     * GET /api/users
     * Lista todos os usuários do sistema.
     */
    public function index(): JsonResponse
    {
        $usuarios = $this->userService->listar();

        return response()->json($usuarios, 200);
    }

    /**
     * POST /api/users
     * Cadastra um novo usuário, gera o token JWT e criptografa a senha.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'ativo'    => 'sometimes|boolean'
        ]);

        // O Service processa a regra de negócio e devolve o array com ['user', 'token']
        $resultado = $this->userService->cadastrar($request->all());

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'user'    => $resultado['user'],
            'token'   => $resultado['token']
        ], 201); // 201 Created
    }

    /**
     * GET /api/users/{id}
     * Busca um usuário específico por ID (UUID).
     */
    public function show(string $id): JsonResponse
    {
        $usuario = $this->userService->buscar($id);

        return response()->json($usuario, 200);
    }

    /**
     * PUT /api/users/{id}
     * Atualiza os dados cadastrais do usuário.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'nome'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|string|email|max:255',
            'password' => 'nullable|string|min:6',
            'ativo'    => 'sometimes|boolean'
        ]);

        $usuario = $this->userService->atualizar($id, $request->all());

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!',
            'user'    => $usuario
        ], 200);
    }

    /**
     * DELETE /api/users/{id}
     * Remove o usuário do banco de dados.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->userService->excluir($id);

        return response()->json([
            'message' => 'Usuário excluído com sucesso!'
        ], 200);
    }
}
