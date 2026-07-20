<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API Financiamento Veículos",
    description: "API para gerenciamento do sistema de financiamento de veículos"
)]
#[OA\Server(
    url: "http://localhost:8000/",
    description: "Servidor Local"
)]
class OpenApiSpec {}
