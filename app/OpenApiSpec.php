<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API Financiamento Veículos",
    description: "API para gerenciamento do sistema de financiamento de veículos"
)]
#[OA\Tag(
    name: "Marcação de Ponto",
    description: "Endpoints para registro e consulta de ponto"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
#[OA\OpenApi(
    security: [
        ['bearerAuth' => []]
    ]
)]
class OpenApiSpec {}
