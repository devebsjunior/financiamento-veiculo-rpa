<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:main')]
#[Description('Command description')]
class Main extends Command
{

    public function handle()
    {
        $this->info('Olá Mundo');
        return self::SUCCESS;
    }
}
