# 🚀 Sistema de Gestão & Marcação de Ponto
Ecossistema Laravel, Kafka, Prometheus, Grafana & Swagger
Uma solução completa e robusta de Controle e Marcação de Ponto desenvolvida em Laravel (PHP 8.4), projetada sob a arquitetura orientada a eventos (Event-Driven Architecture). O sistema conta com observabilidade avançada, gestão centralizada de colaboradores, exportação de relatórios, processamento de e-mails via filas de mensageria assíncrona e capacidade de integração aberta com microsserviços e ERPs externos.

![PHP 8.4](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php&logoColor=white) ![Laravel 11](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel&logoColor=white) ![Apache Kafka](https://img.shields.io/badge/Apache%20Kafka-Event--Driven-231F20?style=flat&logo=apachekafka&logoColor=white) ![Prometheus](https://img.shields.io/badge/Prometheus-Metrics-E6522C?style=flat&logo=prometheus&logoColor=white) ![Grafana](https://img.shields.io/badge/Grafana-Dashboards-F46800?style=flat&logo=grafana&logoColor=white) ![Swagger / OpenAPI](https://img.shields.io/badge/Swagger-OpenAPI%203.0-85EA2D?style=flat&logo=swagger&logoColor=black) ![JWT Auth](https://img.shields.io/badge/JWT-Authentication-000000?style=flat&logo=jsonwebtokens&logoColor=white) ![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16-4169E1?style=flat&logo=postgresql&logoColor=white) ![Docker Compose](https://img.shields.io/badge/Docker-Compose-2496ED?style=flat&logo=docker&logoColor=white) ![License](https://img.shields.io/badge/license-MIT-green?style=flat)

📑 Sumário
- Visão Geral do Projeto
- 🌐 URLs de Acesso Aos Serviços
- 🚀 Como Executar o Projeto
- 📜 Documentação de APIs (Swagger / OpenApi)
- 📊 Observabilidade & Monitoramento (Prometheus + Grafana)
- 📬 Módulo de Marcação de Ponto & Eventos Kafka
- 👥 Gestão & Controle de Usuários
- 🔌 Integração & Arquitetura Aberta para Outros Projetos
- 📂 Estrutura do Projeto


## 📌 Visão Geral do Projeto
Este sistema foi construído para gerenciar jornadas de trabalho com precisão, permitindo que colaboradores registrem seus pontos em tempo real, acompanhem previsões de saída para a jornada diária de 8 horas e consultem seus espelhos de ponto com cálculo automático de banco de horas e saldos positivos/negativos.

### Destaques da Arquitetura:
- Autenticação Segura: Autenticação via JWT (tymon/jwt-auth) com suporte a múltiplos papéis (Colaboradores e Administradores).
- Interface Moderna: Painel responsivo desenvolvido com Tailwind CSS e componentes dinâmicos em JavaScript isolado (resources/js/ponto.js), mantendo a camada visual limpa.
- Documentação Viva: Swagger UI integrado para testes e fácil integração entre equipes.
- Processamento de Alta Performance: Desacoplamento de rotas HTTP pesadas utilizando Apache Kafka e Laravel Queue Workers para envio automático de e-mails de comprovante e geração de planilhas.
- Observabilidade Completa: Coleta automática de métricas de negócio e técnicas via Prometheus exibidas em gráficos e dashboards executivos no Grafana.

## 🌐 URLs de Acesso Aos Serviços
Após iniciar o ecossistema, os seguintes endereços ficam disponíveis para acesso e teste:

- 💻 Aplicação Web / Interface Principal:
👉 http://localhost:8000 (ou http://localhost:8001 caso a porta 8000 esteja em uso)

- 📜 Documentação de APIs (Swagger UI):
👉 http://localhost:8000/api/documentation

- 📊 Métricas Brutas em PromQL (Scraping Endpoint):
👉 http://localhost:8000/prometheus

- 📈 Dashboards de Observabilidade (Grafana):
👉 http://localhost:3000 (Credenciais padrão: admin / admin)

- 🔍 Serviço Prometheus (Métricas e Queries Directs):
👉 http://localhost:9090

## 🚀 Como Executar o Projeto
Você pode rodar a aplicação através de duas abordagens: utilizando o ambiente totalmente isolado via Docker Compose ou em modo de Desenvolvimento Local.

**Execução Completa via Docker Compose (Recomendado)**
Esta abordagem sobe toda a infraestrutura contêinerizada (Laravel App, PostgreSQL, Redis, Apache Kafka, Zookeeper, Prometheus e Grafana)[cite: 1, 2].

Subir todos os contêineres em segundo plano:
```
docker compose up -d
```

Executar as Migrations e Seeders do banco de dados PostgreSQL:
```
docker exec -it financiamento-veiculos-laravel-app php artisan migrate --seed
```

Acompanhar os logs do Queue Worker em tempo real:
```
docker logs -f laravel-queue-worker
```

## 📜 Documentação de APIs (Swagger / OpenApi)

A aplicação conta com documentação interativa gerada automaticamente através do **L5-Swagger**. Ela permite testar os endpoints diretamente pelo navegador com suporte a autenticação por Token Bearer (JWT).

### O que o Swagger cobre:
* **Autenticação (`/api/auth`):** Login, Logout, Refresh Token, Me (dados do usuário logado).
* **Gestão de Usuários (`/api/users`):** Cadastro, edição, alteração de permissões e listagem de colaboradores.
* **Marcação de Ponto (`/api/ponto`):**
  * `POST /api/ponto/marcar`: Registra um novo horário para o colaborador autenticado no dia atual (com opção de observações como "Trabalho remoto").
  * `GET /api/ponto/espelho/{anoMes}`: Retorna o espelho mensal detalhado das batidas, calculando horas diárias e saldo acumulado.
  * `GET /api/ponto/exportar/xls`: Exporta o relatório mensal de marcações em planilha `.xlsx` (OpenPyXL/Laravel Excel).

Acesse a interface gráfica da documentação em:
👉 `http://localhost:8000/api/documentation`

---

## 📊 Observabilidade & Monitoramento (Prometheus + Grafana)

A aplicação foi projetada para monitoramento em tempo real da saúde técnica do backend e de métricas de negócio.

### 1. Prometheus (Coleta de Métricas)
O Laravel expõe um endpoint dedicado em `/prometheus` via pacote `spatie/laravel-prometheus`. O container do **Prometheus** faz o *scraping* periódico desses dados a cada 15 segundos.

* **Métricas Técnicas Expostas:** Versão do PHP, uso de memória e tempo de execução.
* **Métricas de Negócio Expostas:**
  * `total_de_usuarios`: Total de colaboradores cadastrados na base.
  * `horas_trabalhadas_hoje`: Quantidade de horas acumuladas registradas no dia corrente.
  * `horas_trabalhadas_por_dia{data="YYYY-MM-DD"}`: Métrica rotulada (*labeled metric*) para acompanhamento histórico de jornadas diárias.

### 2. Grafana (Visualização em Dashboards)
O **Grafana** consome a fonte de dados do Prometheus e apresenta dashboards executivos e operacionais com visualizações dinâmicas:

* **Gráficos de Barras Diárias (Bar Charts):** Exibe a quantidade exata de horas trabalhadas por dia (ex: `2026-08-04`, `2026-08-05`), permitindo identificar horas extras ou jornadas incompletas com rótulos organizados.
* **Indicadores de Usuários (Stat Panels):** Exibe o crescimento de usuários ativos e engajamento no uso do ponto.
* **Gráficos Temporais (Time Series):** Acompanhamento contínuo da volumetria de batidas registradas no sistema.

Acesse a interface do Grafana em:
👉 `http://localhost:3000` (Credenciais padrão: `admin` / `admin`)

---

## 📬 Módulo de Marcação de Ponto & Eventos Kafka

O módulo de controle de ponto opera com baixo tempo de resposta no HTTP e alta resiliência graças ao desacoplamento por mensageria e filas.

### Fluxo da Batida de Ponto:
1. **Requisição HTTP (Registro Rápido):** O funcionário realiza a marcação no frontend ou mobile. A API grava imediatamente o registro na tabela `pontos` no **PostgreSQL** e responde com `200 OK` ao usuário sem qualquer atraso.
2. **Disparo do Evento Assíncrono (`PontoRegistradoEvent` / Kafka):**
   * A aplicação publica um payload JSON com os dados do ponto no tópico **`ponto-registrado`** do **Apache Kafka** (ou na fila gerenciada do Redis/PostgreSQL).
3. **Consumidores Dedicados em Background (Consumers):**
   * **Serviço de E-mail (`EnviarEmailPontoConsumer`):** Escuta o tópico/fila e envia instantaneamente um comprovante formal de marcação para o e-mail do funcionário (`ComprovantePontoMail`), sem travar o endpoint de ponto.
   * **Serviço de Relatórios / Consolidação em Excel:** Processa o evento e grava/atualiza as informações consolidadas em planilhas ou storage em segundo plano.

---

## 👥 Gestão & Controle de Usuários

O sistema possui uma camada robusta de controle de acesso e usuários:

* **Controle de Perfil:** Separação clara entre administradores e colaboradores padrão.
* **Ativação e Status:** Possibilidade de ativar/desativar contas e gerenciar credenciais.
* **Integração de Cadastro via Mensageria / EAI:**
  * Suporta criação e sincronização de usuários via APIs externas ou barramentos de integração como **Apache Camel** (porta `8080`), permitindo que cadastros realizados em ERPs ou sistemas de RH externos sejam injetados no sistema de ponto de forma totalmente transparente e autenticada.

---

## 🔌 Integração & Arquitetura Aberta para Outros Projetos

Uma das maiores virtudes desta arquitetura é a sua preparação para **Ecossistemas de Microsserviços**:

1. **Consumo de Eventos via Kafka (Event-Driven Architecture):**
   * Qualquer outro microsserviço da empresa (ex: **Sistema de Folha de Pagamento**, **BI/People Analytics**, **Auditoria de Compliance**) pode assinar o tópico `ponto-registrado` do Kafka.
   * Sem alterar uma única linha de código do Laravel, novos sistemas receberão uma cópia do payload em tempo real toda vez que um ponto for batido.
2. **Integração REST / Endpoints de Espelho:**
   * Outros backends podem consumir os dados consolidados do espelho de ponto via rotas protegidas por JWT para geração de relatórios externos ou conciliação bancária de horas.
3. **Suporte a Barramentos ESB / Apache Camel:**
   * Rotas adaptadas para receber entradas provenientes de conectores Java (Apache Camel/Quarkus/Spring Boot) garantem interoperabilidade entre linguagens e ecossistemas legados.

---

## 📂 Estrutura do Projeto
```
├── app/
│   ├── Console/Commands/        # Comandos de CLI do Artisan
│   ├── Events/                  # Eventos da aplicação (PontoRegistradoEvent.php)
│   ├── Http/Controllers/        # PontoController, AuthController, UserController
│   ├── Kafka/Consumers/         # Consumidores dedicados para eventos Kafka
│   ├── Listeners/               # Listeners nativos para envio de e-mail e tarefas
│   ├── Mail/                    # Mailable ComprovantePontoMail.php
│   ├── Models/                  # User.php, Ponto.php
│   ├── Providers/               # AppServiceProvider (Registro de Métricas Prometheus)
│   └── Services/                # PontoService.php (Regras de Negócio e Cálculos)
├── config/                      # Configurações do Laravel (prometheus, jwt, l5-swagger)
├── database/                    # Migrations e Seeders da base PostgreSQL
├── resources/
│   ├── js/                      # Lógica de interface (ponto.js, dashboard)
│   └── views/                   # Views Blade (ponto.blade.php, layouts)
├── routes/
│   ├── api.php                  # Rotas das APIs REST com anotações OpenApi
│   └── web.php                  # Rotas web e endpoint /prometheus
├── prometheus.yml               # Configuração de scraping do Prometheus
├── docker-compose.yml           # Orquestração dos serviços (App, Postgres, Redis, Kafka, Prometheus, Grafana)
└── README.md                    # Documentação do Projeto
```

Este ecossistema foi projetado para oferecer alta disponibilidade, resiliência no processamento de batidas e observabilidade completa. Ao unir a estabilidade do Laravel, o processamento orientados a eventos via Apache Kafka, o monitoramento em tempo real com Prometheus/Grafana e a facilidade de testes do Swagger, o projeto entrega uma infraestrutura robusta de controle de ponto, pronta para escala corporativa e para integração fluida com novos microsserviços.

