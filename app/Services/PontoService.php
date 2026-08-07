<?php

namespace App\Services;

use App\Models\Ponto;
use Carbon\Carbon;

class PontoService
{
    /**
     * Registra um novo ponto para o usuário.
     *
     * @param string $userId
     * @param string|null $observacao
     * @return array
     */
    public function registrarPonto(string $userId, ?string $observacao = null): array
    {
        $hoje = Carbon::now()->format('Y-m-d');
        $horaAtual = Carbon::now()->format('H:i:s');
        $ponto = Ponto::firstOrCreate(
            [
                'user_id' => $userId,
                'data' => $hoje,
            ],
            [
                'horarios' => [],
                'total_horas' => 0.00,
                'observacao' => $observacao,
            ]
        );

        $horarios = $ponto->horarios ?? [];
        $horarios[] = $horaAtual;
        $totalHoras = $this->calcularTotalHoras($horarios);

        $ponto->update([
            'horarios' => $horarios,
            'total_horas' => $totalHoras,
            'observacao' => $observacao ?? $ponto->observacao,
        ]);

        return [
            'mensagem' => 'Ponto registrado com sucesso!',
            'data' => $hoje,
            'hora' => $horaAtual,
            'batidas' => $horarios,
            'total_horas' => $totalHoras,
        ];
    }

    /**
     * Consulta o espelho de ponto do mês.
     *
     * @param string $userId
     * @param string $anoMes
     * @return array
     */
    public function obterEspelhoMes(string $userId, string $anoMes): array
    {
        $pontos = Ponto::where('user_id', $userId)
            ->where('data', 'like', "{$anoMes}%")
            ->orderBy('data', 'asc')
            ->get();

        $totalHorasMes = $pontos->sum('total_horas');

        return [
            'periodo' => $anoMes,
            'total_horas_mes' => $totalHorasMes,
            'registros' => $pontos,
        ];
    }

    /**
     * Auxiliar para calcular horas a partir de pares de horários
     */
    private function calcularTotalHoras(array $horarios): float
    {
        $totalMinutos = 0;
        $count = count($horarios);

        for ($i = 0; $i < $count - 1; $i += 2) {
            $entrada = Carbon::createFromFormat('H:i:s', $horarios[$i]);
            $saida = Carbon::createFromFormat('H:i:s', $horarios[$i + 1]);
            $totalMinutos += $saida->diffInMinutes($entrada);
        }

        return round($totalMinutos / 60, 2);
    }

    /**
     * Lista todos os registros de ponto do sistema (Admin)
     */
    public function listarTodos(int $perPage = 15)
    {
        return Ponto::with('user')->orderBy('data', 'desc')->paginate($perPage);
    }

    /**
     * Atualiza um registro de ponto específico (Admin)
     */
    public function atualizarPonto(string $id, array $dados): Ponto
    {
        $ponto = Ponto::findOrFail($id);

        if (isset($dados['horarios'])) {
            $dados['total_horas'] = $this->calcularTotalHoras($dados['horarios']);
        }
        $ponto->update($dados);
        return $ponto;
    }

    /**
     * Remove um registro de ponto (Admin)
     */
    public function deletarPonto(string $id): bool
    {
        $ponto = Ponto::findOrFail($id);
        return $ponto->delete();
    }

    /**
     * Remove um horário específico do array de batidas pelo seu índice (0, 1, 2...)
     */
   public function removerHorarioEspecifico(string $id, int $index): Ponto
    {
        $ponto = Ponto::findOrFail($id);
        $horarios = $ponto->horarios ?? [];

        if (array_key_exists($index, $horarios)) {
            array_splice($horarios, $index, 1);
            $ponto->horarios = $horarios;
            $ponto->total_horas = $this->calcularTotalHoras($horarios);
            $ponto->save();
        }

        return $ponto;
    }

}
