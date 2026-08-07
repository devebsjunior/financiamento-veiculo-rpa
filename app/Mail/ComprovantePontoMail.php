<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
    return $this->subject('Comprovante de Registro de Ponto')
      ->html("<h1>Comprovante de Ponto</h1>
                            <p>Olá, {$this->dadosPonto['usuario_nome']}!</p>
                            <p>Sua batida foi registrada com sucesso em: <strong>{$this->dadosPonto['data_hora']}</strong></p>");
  }
}
