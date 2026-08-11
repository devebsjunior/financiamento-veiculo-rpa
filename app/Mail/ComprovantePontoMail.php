<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ComprovantePontoMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $dadosPonto;

    public function __construct(array $dadosPonto)
    {
        $this->dadosPonto = $dadosPonto;
    }

    public function build()
    {
        $nome = $this->dadosPonto['usuario_nome'] ?? 'Colaborador';

        // Captura a data_hora vinda do payload (ex: "2026-08-11 11:29:26")
        $rawDataHora = $this->dadosPonto['data_hora'] ?? now();

        // Formata para o padrão brasileiro: DD/MM/AAAA às HH:MM:SS
        $dataHoraFormatada = Carbon::parse($rawDataHora)->format('d/m/Y \à\s H:i:s');

        return $this->subject('Comprovante de Registro de Ponto')
          ->html("
              <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px;'>
                  <h2 style='color: #4f46e5; margin-top: 0;'>Comprovante de Registro de Ponto</h2>
                  <p>Olá, <strong>{$nome}</strong>!</p>
                  <p>Sua batida de ponto foi registrada com sucesso no sistema <strong>Gestão Car</strong>.</p>
                  <div style='background-color: #f8fafc; border-left: 4px solid #4f46e5; padding: 12px 16px; margin: 20px 0;'>
                      <p style='margin: 0;'><strong>Data e Hora:</strong> {$dataHoraFormatada}</p>
                  </div>
                  <p style='color: #64748b; font-size: 14px;'><em>Equipe RH — Gestão Car</em></p>
              </div>
          ");
    }
}
