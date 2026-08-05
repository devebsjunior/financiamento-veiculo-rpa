<?php
// config/open-telemetry.php

return [
    'service_name' => env('OTEL_SERVICE_NAME', 'laravel-sistema-agencias'),

    // Endereço do coletor central (o arquivo #1 que configuramos acima)
    'exporter' => [
        'endpoint' => env('OTEL_EXPORTER_OTLP_ENDPOINT', 'http://otel-collector.internal.banco:4318'),
        'protocol' => 'http/protobuf', // Protocolo performático para web
    ],

    // O que rastrear automaticamente nas agências
    'instrumentation' => [
        'requests'  => true,  // Rastreia acessos às rotas do caixa
        'database'  => true,  // Rastreia lentidão de queries no PostgreSQL
        'redis'     => true,  // Rastreia performance do cache de sessões
        'queues'    => true,  // Rastreia filas assíncronas
    ],
];
