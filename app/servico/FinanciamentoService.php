<?php

namespace App\Services;

use App\Models\Financiamento;
use App\Models\Parcela;
use Illuminate\Support\Facades\DB;

class FinanciamentoService
{
    public function listar()
    {
        return Financiamento::with([
            'cliente',
            'veiculo',
            'parcelas'
        ])->get();
    }

    public function buscar(int $id)
    {
        return Financiamento::with([
            'cliente',
            'veiculo',
            'parcelas'
        ])->findOrFail($id);
    }

    public function criar(array $dados)
    {
        return DB::transaction(function () use ($dados) {

            $financiamento = Financiamento::create($dados);

            $valorParcela =
                $dados['valor_financiado']
                /
                $dados['quantidade_parcelas'];

            for ($i = 1; $i <= $dados['quantidade_parcelas']; $i++) {

                Parcela::create([
                    'financiamento_id' => $financiamento->id,
                    'numero_parcela' => $i,
                    'data_vencimento' => now()->addMonths($i),
                    'valor_parcela' => round($valorParcela, 2),
                    'situacao' => 'PENDENTE'
                ]);
            }

            return $financiamento->load('parcelas');
        });
    }
}
