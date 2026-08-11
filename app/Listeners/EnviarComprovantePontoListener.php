<?php

namespace App\Listeners;

use App\Events\PontoRegistradoEvent;
use App\Mail\ComprovantePontoMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarComprovantePontoListener implements ShouldQueue
{
  use InteractsWithQueue;

  public function __construct()
  {
    //
  }

  public function handle(PontoRegistradoEvent $event): void
  {
    $payload = $event->payload;

    // Se o nome não veio no payload, busca diretamente do Model User no banco
    if (empty($payload['usuario_nome']) && !empty($payload['usuario_id'])) {
      $user = User::find($payload['usuario_id']);
      if ($user) {
        $payload['usuario_nome'] = $user->nome ?? $user->name;
      }
    }

    // Se ainda assim não encontrar, usa um nome padrão
    if (empty($payload['usuario_nome'])) {
      $payload['usuario_nome'] = 'Colaborador';
    }

    Log::info('Preparando para enviar e-mail de comprovante para:', [
      'email' => $payload['usuario_email'],
      'nome'  => $payload['usuario_nome']
    ]);

    // Dispara o e-mail preenchido
    Mail::to($payload['usuario_email'])->send(new ComprovantePontoMail($payload));
  }
}
