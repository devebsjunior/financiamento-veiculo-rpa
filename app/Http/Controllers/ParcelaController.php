<?php

namespace App\Http\Controllers;

use App\Services\ParcelaService;
use OpenApi\Attributes as OA;

class ParcelaController extends Controller
{
    public function __construct(
        private ParcelaService $service
    ) {}

    #[OA\Get(
        path: '/api/parcelas',
        operationId: 'listarParcelas',
        tags: ['Parcelas'],
        summary: 'Lista todas as parcelas'
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
        path: '/api/parcelas/{id}',
        operationId: 'buscarParcela',
        tags: ['Parcelas'],
        summary: 'Buscar parcela por ID'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID da parcela'
    )]
    #[OA\Response(
        response: 200,
        description: 'Parcela encontrada'
    )]
    #[OA\Response(
        response: 404,
        description: 'Parcela não encontrada'
    )]
    public function show(int $id)
    {
        return response()->json(
            $this->service->buscar($id)
        );
    }

    #[OA\Post(
        path: '/api/parcelas/{id}/pagar',
        operationId: 'pagarParcela',
        tags: ['Parcelas'],
        summary: 'Realiza o pagamento da parcela'
    )]
    #[OA\Parameter(
        name: 'id',
        in: 'path',
        required: true,
        description: 'ID da parcela'
    )]
    #[OA\Response(
        response: 200,
        description: 'Parcela paga com sucesso'
    )]
    #[OA\Response(
        response: 404,
        description: 'Parcela não encontrada'
    )]
    public function pagar(int $id)
    {
        return response()->json(
            $this->service->pagar($id)
        );
    }
}
