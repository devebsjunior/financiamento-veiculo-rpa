<?php

namespace App\Providers;

use App\Events\PontoRegistradoEvent;
use App\Listeners\EnviarComprovantePontoListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * O mapeamento de eventos para ouvintes da aplicação.
     */
    protected $listen = [
        PontoRegistradoEvent::class => [
            EnviarComprovantePontoListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
