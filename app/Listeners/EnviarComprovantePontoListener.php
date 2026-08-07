<?php

namespace App\Listeners;

use App\Events\PontoRegistradoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EnviarComprovantePontoListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(PontoRegistradoEvent $event): void
    {
        // Pega os dados do evento
        $payload = $event->payload;

        // Loga a mensagem confirmando o processamento em segundo plano
        Log::info('Ponto capturado na fila pelo Worker:', $payload);
    }
}
