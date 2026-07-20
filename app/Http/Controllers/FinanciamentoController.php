<?php

namespace App\Http\Controllers;

use App\Services\FinanciamentoService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class FinanciamentoController extends Controller
{
    public function __construct(
        private FinanciamentoService $service
    ) {}

    #[OA\Get(
        path: '/api/financiamentos',
        operationId: 'listarFinanciamentos',
        tags: ['Financiamentos'],
        summary: 'Lista todos os financiamentos'
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
        path: '/api/financiamentos/{id}',
        operationId: 'buscarFinanciamento',
        tags: ['Financiamentos'],
        summary: 'Buscar financiamento por ID'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID do financiamento'
    )]
    #[OA\Response(
        response: 200,
        description: 'Financiamento encontrado'
    )]
    #[OA\Response(
        response: 404,
        description: 'Financiamento não encontrado'
    )]
    public function show(int $id)
    {
        return response()->json(
            $this->service->buscar($id)
        );
    }

    #[OA\Post(
        path: '/api/financiamentos',
        operationId: 'criarFinanciamento',
        tags: ['Financiamentos'],
        summary: 'Cadastrar financiamento'
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: [
                'cliente_id',
                'veiculo_id',
                'numero_contrato',
                'valor_veiculo',
                'valor_entrada',
                'valor_financiado',
                'taxa_juros',
                'quantidade_parcelas',
                'data_contratacao',
                'situacao'
            ],
            properties: [
                new OA\Property(
                    property: 'cliente_id',
                    type: 'integer',
                    example: 1
                ),
                new OA\Property(
                    property: 'veiculo_id',
                    type: 'integer',
                    example: 1
                ),
                new OA\Property(
                    property: 'numero_contrato',
                    type: 'string',
                    example: 'CTR-2026-0001'
                ),
                new OA\Property(
                    property: 'valor_veiculo',
                    type: 'number',
                    format: 'float',
                    example: 80000.00
                ),
                new OA\Property(
                    property: 'valor_entrada',
                    type: 'number',
                    format: 'float',
                    example: 20000.00
                ),
                new OA\Property(
                    property: 'valor_financiado',
                    type: 'number',
                    format: 'float',
                    example: 60000.00
                ),
                new OA\Property(
                    property: 'taxa_juros',
                    type: 'number',
                    format: 'float',
                    example: 1.99
                ),
                new OA\Property(
                    property: 'quantidade_parcelas',
                    type: 'integer',
                    example: 48
                ),
                new OA\Property(
                    property: 'data_contratacao',
                    type: 'string',
                    format: 'date',
                    example: '2026-07-20'
                ),
                new OA\Property(
                    property: 'situacao',
                    type: 'string',
                    example: 'ATIVO'
                )
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: 'Financiamento criado com sucesso'
    )]
    public function store(Request $request)
    {
        return response()->json(
            $this->service->criar(
                $request->all()
            ),
            201
        );
    }
}
