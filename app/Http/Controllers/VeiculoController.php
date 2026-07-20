<?php

namespace App\Http\Controllers;

use App\Services\VeiculoService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class VeiculoController extends Controller
{
    public function __construct(
        private VeiculoService $service
    ) {}

    #[OA\Get(
        path: '/api/veiculos',
        operationId: 'listarVeiculos',
        tags: ['Veículos'],
        summary: 'Lista todos os veículos'
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
        path: '/api/veiculos/{id}',
        operationId: 'buscarVeiculo',
        tags: ['Veículos'],
        summary: 'Buscar veículo por ID'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID do veículo'
    )]
    #[OA\Response(
        response: 200,
        description: 'Veículo encontrado'
    )]
    #[OA\Response(
        response: 404,
        description: 'Veículo não encontrado'
    )]
    public function show(int $id)
    {
        return response()->json(
            $this->service->buscar($id)
        );
    }

    #[OA\Post(
        path: '/api/veiculos',
        operationId: 'criarVeiculo',
        tags: ['Veículos'],
        summary: 'Cadastrar veículo'
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: [
                'placa',
                'marca',
                'modelo',
                'ano_fabricacao',
                'ano_modelo'
            ],
            properties: [
                new OA\Property(
                    property: 'placa',
                    type: 'string',
                    example: 'ABC1D23'
                ),
                new OA\Property(
                    property: 'marca',
                    type: 'string',
                    example: 'Toyota'
                ),
                new OA\Property(
                    property: 'modelo',
                    type: 'string',
                    example: 'Corolla'
                ),
                new OA\Property(
                    property: 'ano_fabricacao',
                    type: 'integer',
                    example: 2024
                ),
                new OA\Property(
                    property: 'ano_modelo',
                    type: 'integer',
                    example: 2025
                ),
                new OA\Property(
                    property: 'cor',
                    type: 'string',
                    example: 'Prata'
                ),
                new OA\Property(
                    property: 'renavam',
                    type: 'string',
                    example: '12345678901'
                ),
                new OA\Property(
                    property: 'chassi',
                    type: 'string',
                    example: '9BWZZZ377VT004251'
                )
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Veículo criado com sucesso'
    )]
    public function store(Request $request)
    {
        return response()->json(
            $this->service->criar($request->all()),
            201
        );
    }

    #[OA\Put(
        path: '/api/veiculos/{id}',
        operationId: 'atualizarVeiculo',
        tags: ['Veículos'],
        summary: 'Atualizar veículo'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID do veículo'
    )]
    #[OA\Response(
        response: 200,
        description: 'Veículo atualizado com sucesso'
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
        path: '/api/veiculos/{id}',
        operationId: 'excluirVeiculo',
        tags: ['Veículos'],
        summary: 'Excluir veículo'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID do veículo'
    )]
    #[OA\Response(
        response: 200,
        description: 'Veículo removido com sucesso'
    )]
    public function destroy(int $id)
    {
        $this->service->excluir($id);

        return response()->json([
            'message' => 'Veículo removido'
        ]);
    }
}
