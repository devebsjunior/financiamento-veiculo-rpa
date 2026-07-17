<?php

namespace App\Http\Controllers;

use App\Services\VeiculoService;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function __construct(
        private VeiculoService $service
    ) {}

    public function index()
    {
        return response()->json(
            $this->service->listar()
        );
    }

    public function show(int $id)
    {
        return response()->json(
            $this->service->buscar($id)
        );
    }

    public function store(Request $request)
    {
        return response()->json(
            $this->service->criar($request->all()),
            201
        );
    }

    public function update(Request $request, int $id)
    {
        return response()->json(
            $this->service->atualizar(
                $id,
                $request->all()
            )
        );
    }

    public function destroy(int $id)
    {
        $this->service->excluir($id);

        return response()->json([
            'message' => 'Veículo removido'
        ]);
    }
}
