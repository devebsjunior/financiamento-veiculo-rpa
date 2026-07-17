<?php

namespace App\Http\Controllers;

use App\Services\ParcelaService;

class ParcelaController extends Controller
{
    public function __construct(
        private ParcelaService $service
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

    public function pagar(int $id)
    {
        return response()->json(
            $this->service->pagar($id)
        );
    }
}
