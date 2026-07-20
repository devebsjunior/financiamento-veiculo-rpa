<?php

namespace App\Http\Controllers;

use App\Services\ClienteService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ClienteController extends Controller
{
    public function __construct(
        private ClienteService $service
    ) {}

    #[OA\Get(
        path: '/api/clientes',
        operationId: 'listarClientes',
        tags: ['Clientes'],
        summary: 'Lista todos os clientes'
    )]
    #[OA\Response(
        response: 200,
        description: 'Lista retornada com sucesso'
    )]
    public function index()
    {
        return response()->json(
            $this->service->listar()
        );
    }

    #[OA\Get(
        path: '/api/clientes/{id}',
        operationId: 'buscarCliente',
        tags: ['Clientes'],
        summary: 'Buscar cliente por ID'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID do cliente'
    )]
    #[OA\Response(
        response: 200,
        description: 'Cliente encontrado'
    )]
    #[OA\Response(
        response: 404,
        description: 'Cliente não encontrado'
    )]
    public function show(int $id)
    {
        return response()->json(
            $this->service->buscar($id)
        );
    }

    #[OA\Post(
        path: '/api/clientes',
        operationId: 'criarCliente',
        tags: ['Clientes'],
        summary: 'Cadastrar cliente'
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: [
                'nome',
                'cpf'
            ],
            properties: [
                new OA\Property(
                    property: 'nome',
                    type: 'string',
                    example: 'Edson Belém'
                ),
                new OA\Property(
                    property: 'cpf',
                    type: 'string',
                    example: '12345678901'
                ),
                new OA\Property(
                    property: 'data_nascimento',
                    type: 'string',
                    format: 'date',
                    example: '1990-05-10'
                ),
                new OA\Property(
                    property: 'telefone',
                    type: 'string',
                    example: '(24)99999-9999'
                ),
                new OA\Property(
                    property: 'email',
                    type: 'string',
                    example: 'edson@gmail.com'
                ),
                new OA\Property(
                    property: 'cep',
                    type: 'string',
                    example: '27510000'
                ),
                new OA\Property(
                    property: 'logradouro',
                    type: 'string',
                    example: 'Rua das Flores'
                ),
                new OA\Property(
                    property: 'numero',
                    type: 'string',
                    example: '123'
                ),
                new OA\Property(
                    property: 'bairro',
                    type: 'string',
                    example: 'Centro'
                ),
                new OA\Property(
                    property: 'cidade',
                    type: 'string',
                    example: 'Resende'
                ),
                new OA\Property(
                    property: 'uf',
                    type: 'string',
                    example: 'RJ'
                )
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Cliente criado com sucesso'
    )]
    public function store(Request $request)
    {
        return response()->json(
            $this->service->criar($request->all()),
            201
        );
    }

    #[OA\Put(
        path: '/api/clientes/{id}',
        operationId: 'atualizarCliente',
        tags: ['Clientes'],
        summary: 'Atualizar cliente'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID do cliente'
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
                    property: 'cpf',
                    type: 'string',
                    example: '12345678901'
                ),
                new OA\Property(
                    property: 'data_nascimento',
                    type: 'string',
                    format: 'date',
                    example: '1990-05-10'
                ),
                new OA\Property(
                    property: 'telefone',
                    type: 'string',
                    example: '(24)99999-9999'
                ),
                new OA\Property(
                    property: 'email',
                    type: 'string',
                    example: 'edson@gmail.com'
                ),
                new OA\Property(
                    property: 'cep',
                    type: 'string',
                    example: '27510000'
                ),
                new OA\Property(
                    property: 'logradouro',
                    type: 'string',
                    example: 'Rua das Flores'
                ),
                new OA\Property(
                    property: 'numero',
                    type: 'string',
                    example: '123'
                ),
                new OA\Property(
                    property: 'bairro',
                    type: 'string',
                    example: 'Centro'
                ),
                new OA\Property(
                    property: 'cidade',
                    type: 'string',
                    example: 'Resende'
                ),
                new OA\Property(
                    property: 'uf',
                    type: 'string',
                    example: 'RJ'
                )
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Cliente atualizado com sucesso'
    )]
    public function update(Request $request, int $id)
    {
        return response()->json(
            $this->service->atualizar(
                $id,
                $request->all()
            )
        );
    }

    #[OA\Delete(
        path: '/api/clientes/{id}',
        operationId: 'excluirCliente',
        tags: ['Clientes'],
        summary: 'Excluir cliente'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID do cliente'
    )]
    #[OA\Response(
        response: 200,
        description: 'Cliente removido com sucesso'
    )]
    public function destroy(int $id)
    {
        $this->service->excluir($id);
        return response()->json([
            'message' => 'Cliente removido'
        ]);
    }
}
