<?php

return [
    'service_name' => env('OTEL_SERVICE_NAME', 'laravel-sistema-agencias'),
    'exporter' => [
        'endpoint' => env('OTEL_EXPORTER_OTLP_ENDPOINT', 'http://otel-collector.internal.banco:4318'),
        'protocol' => 'http/protobuf',
    ],
    'instrumentation' => [
        'requests'  => true,
        'database'  => true,
        'redis'     => true,
        'queues'    => true,
    ],
];
