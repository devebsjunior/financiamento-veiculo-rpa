## Metricas Laravel

```php=
composer require renoki-co/laravel-exporter


composer require open-telemetry/sdk open-telemetry/exporter-otlp

composer show | grep open-telemetry


docker run -d --name otel-collector -p 4317:4317 -p 4318:4318 otel/opentelemetry-collector


composer show | grep open-telemetry

➜  financiamento-veiculos composer show | grep open-telemetry
open-telemetry/api                 1.10.0  API for OpenTelemetry PHP.
open-telemetry/context             1.5.0   Context implementation for OpenTelemetry PHP.
open-telemetry/exporter-otlp       1.4.0   OTLP exporter for OpenTelemetry.
open-telemetry/gen-otlp-protobuf   1.10.0  PHP protobuf files for communication with OpenTelemetry OTLP collectors/servers.
open-telemetry/sdk                 1.15.0  SDK for OpenTelemetry PHP.
open-telemetry/sem-conv            1.38.0  Semantic conventions for OpenTelemetry PHP.


 
kubectl create secret generic oauth2-proxy-creds --from-literal=client-id=SEU_CLIENT_ID --from-literal=client-secret=SEU_CLIENT_SECRET --from-literal=cookie-secret=$(openssl rand -base64 32)


```
