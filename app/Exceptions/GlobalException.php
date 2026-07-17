<?php

namespace App\Exceptions;

use Exception;

class GlobalException extends Exception
{
   public $statusCode;

    public function __construct(string $message = "Erro interno na aplicação.", int $statusCode = 400)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
