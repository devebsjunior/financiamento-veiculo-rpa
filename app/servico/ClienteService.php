<?php

namespace App\Services;

use App\Models\Cliente;

class ClienteService
{
    public function listar()
    {
        return Cliente::orderBy('nome')->get();
    }

    public function buscar(int $id)
    {
        return Cliente::findOrFail($id);
    }

    public function criar(array $dados)
    {
        return Cliente::create($dados);
    }

    public function atualizar(int $id, array $dados)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->update($dados);

        return $cliente->fresh();
    }

    public function excluir(int $id)
    {
        return Cliente::destroy($id);
    }
}
