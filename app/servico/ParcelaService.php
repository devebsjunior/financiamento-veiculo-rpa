<?php

namespace App\Services;

use App\Models\Parcela;

class ParcelaService
{
    public function listar()
    {
        return Parcela::with('financiamento')->get();
    }

    public function buscar(int $id)
    {
        return Parcela::with('financiamento')->findOrFail($id);
    }

    public function pagar(int $id)
    {
        $parcela = Parcela::findOrFail($id);

        $parcela->update([
            'valor_pago' => $parcela->valor_parcela,
            'data_pagamento' => now(),
            'situacao' => 'PAGA'
        ]);

        return $parcela->fresh();
    }
}
