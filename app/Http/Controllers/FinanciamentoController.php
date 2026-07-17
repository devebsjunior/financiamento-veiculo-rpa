<?php

namespace App\Http\Controllers;

use App\Services\FinanciamentoService;
use Illuminate\Http\Request;

class FinanciamentoController extends Controller
{
    public function __construct(
        private FinanciamentoService $service
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
            $this->service->criar(
                $request->all()
            ),
            201
        );
    }
}
