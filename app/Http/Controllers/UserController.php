<?php

namespace App\Http\Controllers;

use App\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class UserController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService
    ) {}

    #[OA\Get(
        path: '/api/users',
        operationId: 'listarUsuarios',
        tags: ['Usuários'],
        summary: 'Lista todos os usuários',
        description: 'Retorna todos os usuários cadastrados'
    )]
    #[OA\Response(
        response: 200,
        description: 'Lista retornada com sucesso'
    )]
    public function index(): JsonResponse
    {
        $usuarios = $this->userService->listar();
        return response()->json($usuarios, 200);
    }

    #[OA\Post(
        path: '/api/users',
        operationId: 'criarUsuario',
        tags: ['Usuários'],
        summary: 'Cadastrar usuário'
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['nome', 'email', 'password'],
            properties: [
                new OA\Property(
                    property: 'nome',
                    type: 'string',
                    example: 'Edson Belém'
                ),
                new OA\Property(
                    property: 'email',
                    type: 'string',
                    example: 'edson@gmail.com'
                ),
                new OA\Property(
                    property: 'password',
                    type: 'string',
                    example: '123456'
                ),
                new OA\Property(
                    property: 'ativo',
                    type: 'boolean',
                    example: true
                )
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Usuário criado'
    )]
    #[OA\Response(
        response: 422,
        description: 'Erro de validação'
    )]
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nome'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'ativo'    => 'sometimes|boolean'
        ]);
        $resultado = $this->userService->cadastrar($request->all());

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'user'    => $resultado['user'],
            'token'   => $resultado['token']
        ], 201);
    }

    #[OA\Get(
        path: '/api/users/{id}',
        operationId: 'buscarUsuario',
        tags: ['Usuários'],
        summary: 'Buscar usuário'
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'UUID do usuário',
        in: 'path',
        required: true
    )]
    #[OA\Response(
        response: 200,
        description: 'Usuário encontrado'
    )]
    #[OA\Response(
        response: 404,
        description: 'Usuário não encontrado'
    )]
    public function show(string $id): JsonResponse
    {
        $usuario = $this->userService->buscar($id);
        return response()->json($usuario, 200);
    }

    #[OA\Put(
        path: '/api/users/{id}',
        operationId: 'atualizarUsuario',
        tags: ['Usuários'],
        summary: 'Atualizar usuário',
        description: 'Atualiza os dados cadastrais de um usuário'
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'UUID do usuário',
        in: 'path',
        required: true
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: 'nome',
                    type: 'string',
                    example: 'Edson Belém'
                ),
                new OA\Property(
                    property: 'email',
                    type: 'string',
                    example: 'edson@gmail.com'
                ),
                new OA\Property(
                    property: 'password',
                    type: 'string',
                    example: '123456'
                ),
                new OA\Property(
                    property: 'ativo',
                    type: 'boolean',
                    example: true
                )
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Usuário atualizado com sucesso'
    )]
    #[OA\Response(
        response: 404,
        description: 'Usuário não encontrado'
    )]
    #[OA\Response(
        response: 422,
        description: 'Erro de validação'
    )]
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


    #[OA\Delete(
        path: '/api/users/{id}',
        operationId: 'excluirUsuario',
        tags: ['Usuários'],
        summary: 'Excluir usuário',
        description: 'Remove um usuário do sistema'
    )]
    #[OA\Parameter(
        name: 'id',
        description: 'UUID do usuário',
        in: 'path',
        required: true
    )]
    #[OA\Response(
        response: 200,
        description: 'Usuário removido com sucesso'
    )]
    #[OA\Response(
        response: 404,
        description: 'Usuário não encontrado'
    )]
    public function destroy(string $id): JsonResponse
    {
        $this->userService->excluir($id);

        return response()->json([
            'message' => 'Usuário excluído com sucesso!'
        ], 200);
    }
}
