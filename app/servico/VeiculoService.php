<?php

namespace App\Services;

use App\Models\Veiculo;

class VeiculoService
{
    public function listar()
    {
        return Veiculo::orderBy('marca')->get();
    }

    public function buscar(int $id)
    {
        return Veiculo::findOrFail($id);
    }

    public function criar(array $dados)
    {
        return Veiculo::create($dados);
    }

    public function atualizar(int $id, array $dados)
    {
        $veiculo = Veiculo::findOrFail($id);

        $veiculo->update($dados);

        return $veiculo->fresh();
    }

    public function excluir(int $id)
    {
        return Veiculo::destroy($id);
    }
}
