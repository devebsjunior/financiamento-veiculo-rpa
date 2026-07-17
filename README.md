 ## Dicas

composer dump-autoload

Regera o mapa de todas as classes do projeto. É o primeiro comando a se rodar quando uma classe nova dá erro de "não encontrada".

composer dump-autoload -o

(Otimizado) Converte o carregamento dinâmico em um mapa estático. Deixa a aplicação muito mais rápida em produção.

composer clear-cache

Apaga todo o cache local de pacotes baixados pelo Composer. Excelente para quando um download vem corrompido.

composer install

Lê o arquivo composer.lock e instala exatamente as versões de pacotes registradas ali (ideal para quando você clona um projeto).

composer update

Ignora o composer.lock, busca as versões mais recentes permitidas no seu composer.json e atualiza tudo. (Use com cuidado!).

composer update --dry-run

Simula um update. Mostra o que seria atualizado sem alterar nenhum arquivo de verdade no seu projeto.

📦 Gerenciamento de Pacotes (Instalação e Remoção)
composer require <pacote>

Instala um pacote de produção (ex: composer require tymon/jwt-auth).

composer require <pacote>:<versao>

Instala uma versão específica de um pacote (ex: composer require tymon/jwt-auth:^1.0.2).

composer require --dev <pacote>

Instala um pacote apenas para ambiente de desenvolvimento (ex: ferramentas de teste como o Pest, PHPUnit ou depuradores).

composer remove <pacote>

Desinstala um pacote completamente do seu projeto e limpa as dependências dele que não são mais usadas.

composer remove --dev <pacote>

Remove com segurança um pacote que foi instalado apenas para desenvolvimento.

🔍 Diagnóstico e Informação do Projeto
Comandos para entender o que está acontecendo "por baixo do capô" nas suas dependências.

composer show

Lista todos os pacotes instalados no seu projeto atualmente e suas respectivas versões.

composer show <pacote>

Mostra detalhes completos de um pacote específico (descrição, licença, dependências dele).

composer show -t

Exibe uma árvore visual de dependências. Ótimo para descobrir qual pacote instalou aquela biblioteca misteriosa de fundo.

composer outdated

Lista todos os pacotes do seu projeto que possuem versões mais recentes disponíveis para atualização.

composer why <pacote>

Explica o porquê de determinado pacote estar instalado no seu projeto (mostra qual outra biblioteca depende dele).

composer why-not <pacote> <versao>

Mostra o motivo de você não conseguir atualizar um pacote para uma versão específica (aponta conflitos de versão do PHP ou de outras libs).

composer status

Verifica se você alterou manualmente algum arquivo dentro da pasta vendor (o que nunca deve ser feito).

composer licenses

Exibe o nome e o tipo de licença de cada pacote instalado (essencial para conformidade jurídica antes de publicar sistemas comerciais).

⚡ Performance, Produção e Configuração Geral
composer install --no-dev

Instala apenas pacotes essenciais de produção. Ignora testadores, geradores de código e debuggers para deixar o servidor leve.

composer install --no-dev -o

O combo perfeito para colocar seu sistema Laravel em produção: sem pacotes de desenvolvimento e com carregamento otimizado de classes.

composer validate

Verifica se o seu arquivo composer.json está com a sintaxe correta e sem erros estruturais antes de você subir para o Git.

composer init

Cria um novo arquivo composer.json interativamente para iniciar um projeto PHP do zero absoluta.

## composer self-update

Atualiza a ferramenta do Composer globalmente na sua máquina para a versão mais recente estável.

## composer diagnose

Faz uma varredura completa no seu sistema para identificar problemas de internet, permissões de pasta ou chaves de criptografia do Composer.

🏃 Automação e Atalhos Personalizados (Scripts)
O Laravel já traz alguns atalhos por padrão, mas você pode criar os seus dentro do composer.json no bloco "scripts".

## composer run-script <nome>

Executa um comando ou script personalizado mapeado dentro do seu ## composer.json.

## composer test

Atalho padrão do Composer para rodar a sua suíte de testes automatizados (geralmente mapeado para rodar phpunit ou pest).

Se precisar criar comandos rápidos para o seu dia a dia, você pode abrir o seu arquivo composer.json e adicionar atalhos customizados na seção "scripts" assim:

JSON
"scripts": {
    "limpar": [
        "php artisan config:clear",
        "php artisan cache:clear",
        "composer dump-autoload"
    ]
}
composer limpar (Exemplo de Script Customizado)

Ao rodar esse comando criado por você, o composer executará os três comandos em lote automaticamente!

## composer dump-autoload


## Developer: Reload Window

## composer require tymon/jwt-auth

## composer require tymon/jwt-auth --with-all-dependencies && composer dump-autoload


Erros de limpeza
## composer dump-autoload

## composer dump-autoload -o


## composer clear-cache



## Autocompleta Models, Relations, Facades e Services.
## composer require --dev barryvdh/laravel-ide-helper



## Ajuda muito a codar

## composer require laravel/pint --dev

## Gerar Helpers
## php artisan ide-helper:generate

Verifica se você alterou manualmente algum arquivo dentro da pasta vendor (o que nunca deve ser feito).
## composer status


## composer show -t

Exibe uma árvore visual de dependências. Ótimo para descobrir qual pacote instalou aquela biblioteca misteriosa de fundo.

## composer outdated

Lista todos os pacotes do seu projeto que possuem versões mais recentes disponíveis para atualização.

## composer why <pacote>

Explica o porquê de determinado pacote estar instalado no seu projeto (mostra qual outra biblioteca depende dele).

## composer why-not <pacote> <versao>

Mostra o motivo de você não conseguir atualizar um pacote para uma versão específica (aponta conflitos de versão do PHP ou de outras libs).



## Instalar o larastan para ficar mais rápido

## composer require larastan/larastan --dev

## composer require yajra/laravel-datatables-oracle

## Shell
## composer require prettus/l5-repository


## composer require ramsey/uuid

## composer require fakerphp/faker

## Gerenciar Comandos Uteis

## php artisan ide-helper:generate

## hp artisan ide-helper:models -RW

## php artisan ide-helper:meta



## PHP ARTISAN OPTIMIZE:CLEAR (FAZ O QUE)
Plain Text

PHP Intelephense
Laravel Extra Intellisense
Laravel Blade Formatter
Laravel Snippets

Laravel Artisan
GitLens
Error Lens
Path Intellisense


code --install-extension bmewburn.vscode-intelephense-client

code --install-extension amiralizadeh9480.laravel-extra-intellisense

code --install-extension shufo.vscode-blade-formatter

code --install-extension onecentlin.laravel-blade

code --install-extension ryannaddy.laravel-artisan

code --install-extension eamodio.gitlens

code --install-extension usernamehw.errorlens

code --install-extension christian-kohler.path-intellisense

code --install-extension mikestead.dotenv

code --install-extension deveditormx.phptools-vscode


ctrl shift + p

Preferences: Open User Settings (JSON)
Mostrar mais linhas

{
    "editor.formatOnSave": true,
    "editor.codeActionsOnSave": {
        "source.organizeImports": "always"
    },
    "[php]": {
        "editor.defaultFormatter": "bmewburn.vscode-intelephense-client"
    },
    "[blade]": {
        "editor.defaultFormatter": "shufo.vscode-blade-formatter"
    }
}


## Compose Require

composer require --dev barryvdh/laravel-ide-helper


## Atalhos Uteis

F12 → Ir para definição
Alt + ← → Voltar
F2 → Renomear
Ctrl + Espaço → Autocomplete
Ctrl + P → Procurar arquivo
Ctrl + Shift + P → Paleta de comandos
Shift + Alt + F → Formatar código


## IDE HELPER
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models -RW
php artisan ide-helper:meta
php artisan jwt:secret



## php artisan optimize:clear

## composer dump-autoload


## ctrl + shift + P
Developer: Reload Window


## php artisan config:clear
## sudo apt update
## sudo apt install php8.4-pgsql php8.4-sqlite3 -y


#### DICAS

# 1. Limpa o cache de configurações antigo
php artisan config:clear
php artisan cache:clear

# 2. Roda as migrações no Postgres (ou SQLite, dependendo do seu .env)

## php artisan migrate


## composer ide


## Veiculo::all();

## Veiculo::find(1);

## Veiculo::create($dados);

## Veiculo::count();

## Veiculo::where('placa', 'ABC1234')->first();


# Instala o autocomplete perfeito de PHP
code --install-extension bmewburn.vscode-intelephense

# Instala o autocomplete específico para rotas, views e configs do Laravel
code --install-extension amiralizadeh9480.laravel-extra-intellisense

# Instala formatação para arquivos .blade.php
code --install-extension shufo.vscode-blade-formatter

# Atalho para clicar em uma View no Controller e ir direto para o arquivo
code --install-extension codingyu.laravel-goto-view


##
code --install-extension bmewburn.vscode-intelephense-client
code --install-extension amiralizadeh9480.laravel-extra-intellisense
code --install-extension onecentlin.laravel-extension-pack
code --install-extension eamodio.gitlens
code --install-extension usernamehw.errorlens
code --install-extension christian-kohler.path-intellisense
code --install-extension formulahendry.auto-rename-tag
code --install-extension streetsidesoftware.code-spell-checker

##################################


➜  financiamento-veiculos php artisan list
Laravel Framework 13.20.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
      --silent          Do not output any message
  -q, --quiet           Only errors are displayed. All other output is suppressed
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  about                     Display basic information about your application
  clear-compiled            Remove the compiled class file
  completion                Dump the shell completion script
  db                        Start a new database CLI session
  dev                       Run the dev processes
  docs                      Access the Laravel documentation
  down                      Put the application into maintenance / demo mode
  env                       Display the current framework environment
  help                      Display help for a command
  inspire                   Display an inspiring quote
  list                      List commands
  migrate                   Run the database migrations
  optimize                  Cache framework bootstrap, configuration, and metadata to increase performance
  pail                      Tails the application logs
  reload                    Reload running services
  serve                     Serve the application on the PHP development server
  test                      Run the application tests
  tinker                    Interact with your application
  up                        Bring the application out of maintenance mode
 app
  app:main                  Command description
 auth
  auth:clear-resets         Flush expired password reset tokens
 cache
  cache:clear               Flush the application cache
  cache:forget              Remove an item from the cache
  cache:prune-stale-tags    Prune stale cache tags from the cache (Redis only)
 channel
  channel:list              List all registered private broadcast channels
 config
  config:cache              Create a cache file for faster configuration loading
  config:clear              Remove the configuration cache file
  config:publish            Publish configuration files to your application
  config:show               Display all of the values for a given configuration file or key
 db
  db:monitor                Monitor the number of connections on the specified database
  db:seed                   Seed the database with records
  db:show                   Display information about the given database
  db:table                  Display information about the given database table
  db:wipe                   Drop all tables, views, and types
 dev
  dev:list                  List the registered dev processes
 env
  env:decrypt               Decrypt an environment file
  env:encrypt               Encrypt an environment file
 event
  event:cache               Discover and cache the application's events and listeners
  event:clear               Clear all cached events and listeners
  event:list                List the application's events and listeners
 ide-helper
  ide-helper:eloquent       Add \Eloquent helper to \Eloquent\Model
  ide-helper:generate       Generate a new IDE Helper file.
  ide-helper:meta           Generate metadata for PhpStorm
  ide-helper:models         Generate autocompletion for models
 install
  install:api               Create an API routes file and install Laravel Sanctum or Laravel Passport
  install:broadcasting      Create a broadcasting channel routes file
 jwt
  jwt:secret                Set the JWTAuth secret key used to sign the tokens
 key
  key:generate              Set the application key
 lang
  lang:publish              Publish all language files that are available for customization
 make
  make:cache-table          [cache:table] Create a migration for the cache database table
  make:cast                 Create a new custom Eloquent cast class
  make:channel              Create a new channel class
  make:class                Create a new class
  make:command              Create a new Artisan command
  make:component            Create a new view component class
  make:config               [config:make] Create a new configuration file
  make:controller           Create a new controller class
  make:enum                 Create a new enum
  make:event                Create a new event class
  make:exception            Create a new custom exception class
  make:export               Create a new export class
  make:factory              Create a new model factory
  make:import               Create a new import class
  make:interface            Create a new interface
  make:job                  Create a new job class
  make:job-middleware       Create a new job middleware class
  make:listener             Create a new event listener class
  make:mail                 Create a new email class
  make:middleware           Create a new HTTP middleware class
  make:migration            Create a new migration file
  make:model                Create a new Eloquent model class
  make:notification         Create a new notification class
  make:notifications-table  [notifications:table] Create a migration for the notifications table
  make:observer             Create a new observer class
  make:policy               Create a new policy class
  make:provider             Create a new service provider class
  make:queue-batches-table  [queue:batches-table] Create a migration for the batches database table
  make:queue-failed-table   [queue:failed-table] Create a migration for the failed queue jobs database table
  make:queue-table          [queue:table] Create a migration for the queue jobs database table
  make:request              Create a new form request class
  make:resource             Create a new resource
  make:rule                 Create a new validation rule
  make:scope                Create a new scope class
  make:seeder               Create a new seeder class
  make:session-table        [session:table] Create a migration for the session database table
  make:test                 Create a new test class
  make:trait                Create a new trait
  make:view                 Create a new view
 migrate
  migrate:fresh             Drop all tables and re-run all migrations
  migrate:install           Create the migration repository
  migrate:refresh           Reset and re-run all migrations
  migrate:reset             Rollback all database migrations
  migrate:rollback          Rollback the last database migration
  migrate:status            Show the status of each migration
 model
  model:prune               Prune models that are no longer needed
  model:show                Show information about an Eloquent model
 optimize
  optimize:clear            Remove the cached bootstrap files
 package
  package:discover          Rebuild the cached package manifest
 queue
  queue:clear               Delete all of the jobs from the specified queue
  queue:failed              List all of the failed queue jobs
  queue:flush               Flush all of the failed queue jobs
  queue:forget              Delete a failed queue job
  queue:listen              Listen to a given queue
  queue:monitor             Monitor the size of the specified queues
  queue:pause               Pause job processing for a specific queue
  queue:prune-batches       Prune stale entries from the batches database
  queue:prune-failed        Prune stale entries from the failed jobs table
  queue:restart             Restart queue worker daemons after their current job
  queue:resume              [queue:continue] Resume job processing for a paused queue
  queue:retry               Retry a failed queue job
  queue:retry-batch         Retry the failed jobs for a batch
  queue:work                Start processing jobs on the queue as a daemon
 route
  route:cache               Create a route cache file for faster route registration
  route:clear               Remove the route cache file
  route:list                List all registered routes
 schedule
  schedule:clear-cache      Delete the cached mutex files created by scheduler
  schedule:interrupt        Interrupt the current schedule run
  schedule:list             List all scheduled tasks
  schedule:pause            Pause the scheduler
  schedule:resume           [schedule:continue] Resume the schedule
  schedule:run              Run the scheduled commands
  schedule:test             Run a scheduled command
  schedule:work             Start the schedule worker
 schema
  schema:dump               Dump the given database schema
 storage
  storage:link              Create the symbolic links configured for the application
  storage:unlink            Delete existing symbolic links configured for the application
 stub
  stub:publish              Publish all stubs that are available for customization
 vendor
  vendor:publish            Publish any publishable assets from vendor packages
 view
  view:cache                Compile all of the application's Blade templates
  view:clear                Clear all compiled view files


  ## Ctrl + Shift + P
  ## Developer: Reload Window

  ## SQLLite3

##  sudo apt update

## sudo apt install php8.4-pgsql php8.4-sqlite3 -y

composer ide

## php artisan about
  make:component            Create a new view component class
  make:config               [config:make] Create a new configuration file
  make:controller           Create a new controller class
  make:enum                 Create a new enum
  make:event                Create a new event class
  make:exception            Create a new custom exception class
  make:export               Create a new export class
  make:factory              Create a new model factory
  make:import               Create a new import class
  make:interface            Create a new interface
  make:job                  Create a new job class
  make:job-middleware       Create a new job middleware class
  make:listener             Create a new event listener class
  make:mail                 Create a new email class
  make:middleware           Create a new HTTP middleware class
  make:migration            Create a new migration file
  make:model                Create a new Eloquent model class
  make:notification         Create a new notification class
  make:notifications-table  [notifications:table] Create a migration for the notifications table
  make:observer             Create a new observer class
  make:policy               Create a new policy class
  make:provider             Create a new service provider class
  make:queue-batches-table  [queue:batches-table] Create a migration for the batches database table
  make:queue-failed-table   [queue:failed-table] Create a migration for the failed queue jobs database table
  make:queue-table          [queue:table] Create a migration for the queue jobs database table
  make:request              Create a new form request class
  make:resource             Create a new resource
  make:rule                 Create a new validation rule
  make:scope                Create a new scope class
  make:seeder               Create a new seeder class
  make:session-table        [session:table] Create a migration for the session database table
  make:test                 Create a new test class
  make:trait                Create a new trait
  make:view                 Create a new view
 migrate
  migrate:fresh             Drop all tables and re-run all migrations
  migrate:install           Create the migration repository
  migrate:refresh           Reset and re-run all migrations
  migrate:reset             Rollback all database migrations
  migrate:rollback          Rollback the last database migration
  migrate:status            Show the status of each migration
 model
  model:prune               Prune models that are no longer needed
  model:show                Show information about an Eloquent model
 optimize
  optimize:clear            Remove the cached bootstrap files
 package
  package:discover          Rebuild the cached package manifest
 queue
  queue:clear               Delete all of the jobs from the specified queue
  queue:failed              List all of the failed queue jobs
  queue:flush               Flush all of the failed queue jobs
  queue:forget              Delete a failed queue job
  queue:listen              Listen to a given queue
  queue:monitor             Monitor the size of the specified queues
  queue:pause               Pause job processing for a specific queue
  queue:prune-batches       Prune stale entries from the batches database
  queue:prune-failed        Prune stale entries from the failed jobs table
  queue:restart             Restart queue worker daemons after their current job
  queue:resume              [queue:continue] Resume job processing for a paused queue
  queue:retry               Retry a failed queue job
  queue:retry-batch         Retry the failed jobs for a batch
  queue:work                Start processing jobs on the queue as a daemon
 route
  route:cache               Create a route cache file for faster route registration
  route:clear               Remove the route cache file
  route:list                List all registered routes
 schedule
  schedule:clear-cache      Delete the cached mutex files created by scheduler
  schedule:interrupt        Interrupt the current schedule run
  schedule:list             List all scheduled tasks
  schedule:pause            Pause the scheduler
  schedule:resume           [schedule:continue] Resume the schedule
  schedule:run              Run the scheduled commands
  schedule:test             Run a scheduled command
  schedule:work             Start the schedule worker
 schema
  schema:dump               Dump the given database schema
 storage
  storage:link              Create the symbolic links configured for the application
  storage:unlink            Delete existing symbolic links configured for the application
 stub
  stub:publish              Publish all stubs that are available for customization
 vendor
  vendor:publish            Publish any publishable assets from vendor packages
 view
  view:cache                Compile all of the application's Blade templates
?➜  financiamento-veiculos
 *  History restored

➜  financiamento-veiculos php artisan about

  Environment ...........................................................
  Application Name .............................................. Laravel
  Laravel Version ............................................... 13.20.0
  PHP Version .................................................... 8.4.23
  Composer Version ............................................... 2.10.2
  Environment ..................................................... local
  Debug Mode .................................................... ENABLED
  URL ......................................................... localhost
  Maintenance Mode .................................................. OFF
  Timezone .......................................................... UTC
  Locale ............................................................. en

  Cache .................................................................
  Config ..................................................... NOT CACHED
  Events ..................................................... NOT CACHED
  Routes ..................................................... NOT CACHED
  Views ...................................................... NOT CACHED

  Drivers ...............................................................
  Broadcasting ...................................................... log
  Cache ........................................................ database
  Database ........................................................ pgsql
  Logs ................................................... stack / single
  Mail .............................................................. log
  Queue ........................................................ database
  Session ...................................................... database

  Storage ...............................................................
  public/storage ............................................. NOT LINKED

  ## Current application environment: local

  ## Current application environment: production

  ## php artisan migrate

  ## php artisan env

  ## php artisan serve

  ## php artisan serve --port=8080

  ## php artisan test --filter=VeiculoTest

  ## php artisan test tests/Feature/AuthTest.php



## php artisan config:clear

## php artisan cache:clear
 php artisan about

  Environment ...........................................................
  Application Name .............................................. Laravel
  Laravel Version ............................................... 13.20.0
  PHP Version .................................................... 8.4.23
  Composer Version ............................................... 2.10.2
  Environment ..................................................... local
  Debug Mode .................................................... ENABLED
  URL ......................................................... localhost
  Maintenance Mode .................................................. OFF
  Timezone .......................................................... UTC
  Locale ............................................................. en

  Cache .................................................................
  Config ..................................................... NOT CACHED
  Events ..................................................... NOT CACHED
  Routes ..................................................... NOT CACHED
  Views ...................................................... NOT CACHED

  Drivers ...............................................................
  Broadcasting ...................................................... log
  Cache ........................................................ database
  Database ........................................................ pgsql
  Logs ................................................... stack / single
  Mail .............................................................. log
  Queue ........................................................ database
  Session ...................................................... database

  Storage ...............................................................
  public/storage ............................................. NOT LINKED


## k3s
# kubectl get nodes

# kubectl get pods -a

# kubeclt create namespace portainer

## pod postgres

## postgres.yaml


apiVersion: v1
kind: PersistentVolumeClaim
metadata:
  name: postgres-pvc
spec:
  accessModes:
    - ReadWriteOnce
  resources:
    requests:
      storage: 2Gi
---
apiVersion: apps/v1
kind: Deployment
metadata:
  name: postgres
spec:
  replicas: 1
  selector:
    matchLabels:
      app: postgres
  template:
    metadata:
      labels:
        app: postgres
    spec:
      containers:
      - name: postgres
        image: postgres:15-alpine
        env:
        - name: POSTGRES_DB
          value: "laravel_db"
        - name: POSTGRES_USER
          value: "postgres_user"
        - name: POSTGRES_PASSWORD
          value: "postgres_password"
        ports:
        - containerPort: 5432
        volumeMounts:
        - name: postgres-storage
          mountPath: /var/lib/postgresql/data
      volumes:
      - name: postgres-storage
        persistentVolumeClaim:
          claimName: postgres-pvc
---
apiVersion: v1
kind: Service
metadata:
  name: postgres-service
spec:
  selector:
    app: postgres
  ports:
    - protocol: TCP
      port: 5432
      targetPort: 5432

## ===============================

# kubectl get pods -A
NAMESPACE     NAME                                      READY   STATUS      RESTARTS      AGE
default       postgres-6499d5569b-b527p                 1/1     Running     0             2m18s
kube-system   coredns-5f5694d56b-9wj7v                  1/1     Running     0             15m
kube-system   helm-install-traefik-crd-flwfq            0/1     Completed   0             15m
kube-system   helm-install-traefik-zp4gt                0/1     Completed   1 (15m ago)   15m
kube-system   local-path-provisioner-58d557dc48-gbp6j   1/1     Running     0             15m
kube-system   metrics-server-7c86f97b8d-qmb6v           1/1     Running     0             15m
kube-system   svclb-traefik-7c2ceaf5-jlzwb              2/2     Running     0             15m
kube-system   traefik-6cd8c7cd89-f2ptl                  1/1     Running     0             15m


# kubectl create namespace portainer --dry-run=client -o yaml | kubectl apply -f -

# 2. Aplica a instalação oficial do Portainer

# kubectl apply -n portainer -f https://raw.githubusercontent.com/portainer/k8s/master/deploy/manifests/portainer/portainer.yaml


## Esse dá o download e aplica

# kubectl apply -n portainer -f https://downloads.portainer.io/ce-lts/portainer.yaml


# kubectl get pods -n portainer


## kubectl get svc -n portainer

# ➜  financiamento-veiculos


## kubectl apply -n portainer -f https://downloads.portainer.io/ce-lts/portainer.yaml


namespace/portainer configured
serviceaccount/portainer-sa-clusteradmin created
persistentvolumeclaim/portainer created
clusterrolebinding.rbac.authorization.k8s.io/portainer created
service/portainer created
deployment.apps/portainer created
➜  financiamento-veiculos kubectl get pods -n portainer
NAME                         READY   STATUS    RESTARTS   AGE
portainer-6f577fd6f9-697g6   1/1     Running   0          5m13s
➜  financiamento-veiculos

## kubectl get svc -n portainer



NAME        TYPE       CLUSTER-IP     EXTERNAL-IP   PORT(S)                                         AGE
portainer   NodePort   10.43.181.98   <none>        9000:30777/TCP,9443:30779/TCP,30776:30776/TCP   27m

## kubectl get svc -n portainer

#  kubectl apply -n portainer -f https://downloads.portainer.io/ce-lts/portainer.yaml
namespace/portainer unchanged
serviceaccount/portainer-sa-clusteradmin unchanged
persistentvolumeclaim/portainer unchanged
clusterrolebinding.rbac.authorization.k8s.io/portainer unchanged
service/portainer unchanged
deployment.apps/portainer configured

# kubectl get pods -n portainer


# openssl rand -base64 32
Nbz1UYG8ayam3ARHrrd2jFOwd6AyJwWe52q1Cf2HaPs=

# nano auth-proxy.yaml

#
# kubectl apply -f auth-proxy.yaml
secret/oauth2-proxy-creds created
deployment.apps/oauth2-proxy created
service/oauth2-proxy-service created

##  kubectl rollout restart deployment/oauth2-proxy
deployment.apps/oauth2-proxy restarted

# kubectl get pods

#  openssl rand -hex 16
bfe6ba09a971b90f5bc6bf82640db154

kubectl patch secret oauth2-proxy-creds -p "{\"stringData\":{\"cookie-secret\":\"bfe6ba09a971b90f5bc6bf82640db154\"}}"
secret/oauth2-proxy-creds patched

kubectl rollout restart deployment/oauth2-proxy
kubectl get pods

➜  financiamento-veiculos kubectl get pods
NAME                            READY   STATUS    RESTARTS   AGE
oauth2-proxy-67dcf59f8b-sk5wp   1/1     Running   0          13s
postgres-6499d5569b-b527p       1/1     Running   0          122m


###

code --install-extension MehediDracula.php-namespace-resolver

 ## Dicas

composer dump-autoload

Regera o mapa de todas as classes do projeto. É o primeiro comando a se rodar quando uma classe nova dá erro de "não encontrada".

composer dump-autoload -o

(Otimizado) Converte o carregamento dinâmico em um mapa estático. Deixa a aplicação muito mais rápida em produção.

composer clear-cache

Apaga todo o cache local de pacotes baixados pelo Composer. Excelente para quando um download vem corrompido.

composer install

Lê o arquivo composer.lock e instala exatamente as versões de pacotes registradas ali (ideal para quando você clona um projeto).

composer update

Ignora o composer.lock, busca as versões mais recentes permitidas no seu composer.json e atualiza tudo. (Use com cuidado!).

composer update --dry-run

Simula um update. Mostra o que seria atualizado sem alterar nenhum arquivo de verdade no seu projeto.

📦 Gerenciamento de Pacotes (Instalação e Remoção)
composer require <pacote>

Instala um pacote de produção (ex: composer require tymon/jwt-auth).

composer require <pacote>:<versao>

Instala uma versão específica de um pacote (ex: composer require tymon/jwt-auth:^1.0.2).

composer require --dev <pacote>

Instala um pacote apenas para ambiente de desenvolvimento (ex: ferramentas de teste como o Pest, PHPUnit ou depuradores).

composer remove <pacote>

Desinstala um pacote completamente do seu projeto e limpa as dependências dele que não são mais usadas.

composer remove --dev <pacote>

Remove com segurança um pacote que foi instalado apenas para desenvolvimento.

🔍 Diagnóstico e Informação do Projeto
Comandos para entender o que está acontecendo "por baixo do capô" nas suas dependências.

composer show

Lista todos os pacotes instalados no seu projeto atualmente e suas respectivas versões.

composer show <pacote>

Mostra detalhes completos de um pacote específico (descrição, licença, dependências dele).

composer show -t

Exibe uma árvore visual de dependências. Ótimo para descobrir qual pacote instalou aquela biblioteca misteriosa de fundo.

composer outdated

Lista todos os pacotes do seu projeto que possuem versões mais recentes disponíveis para atualização.

composer why <pacote>

Explica o porquê de determinado pacote estar instalado no seu projeto (mostra qual outra biblioteca depende dele).

composer why-not <pacote> <versao>

Mostra o motivo de você não conseguir atualizar um pacote para uma versão específica (aponta conflitos de versão do PHP ou de outras libs).

composer status

Verifica se você alterou manualmente algum arquivo dentro da pasta vendor (o que nunca deve ser feito).

composer licenses

Exibe o nome e o tipo de licença de cada pacote instalado (essencial para conformidade jurídica antes de publicar sistemas comerciais).

⚡ Performance, Produção e Configuração Geral
composer install --no-dev

Instala apenas pacotes essenciais de produção. Ignora testadores, geradores de código e debuggers para deixar o servidor leve.

composer install --no-dev -o

O combo perfeito para colocar seu sistema Laravel em produção: sem pacotes de desenvolvimento e com carregamento otimizado de classes.

composer validate

Verifica se o seu arquivo composer.json está com a sintaxe correta e sem erros estruturais antes de você subir para o Git.

composer init

Cria um novo arquivo composer.json interativamente para iniciar um projeto PHP do zero absoluta.

## composer self-update

Atualiza a ferramenta do Composer globalmente na sua máquina para a versão mais recente estável.

## composer diagnose

Faz uma varredura completa no seu sistema para identificar problemas de internet, permissões de pasta ou chaves de criptografia do Composer.

🏃 Automação e Atalhos Personalizados (Scripts)
O Laravel já traz alguns atalhos por padrão, mas você pode criar os seus dentro do composer.json no bloco "scripts".

## composer run-script <nome>

Executa um comando ou script personalizado mapeado dentro do seu ## composer.json.

## composer test

Atalho padrão do Composer para rodar a sua suíte de testes automatizados (geralmente mapeado para rodar phpunit ou pest).

Se precisar criar comandos rápidos para o seu dia a dia, você pode abrir o seu arquivo composer.json e adicionar atalhos customizados na seção "scripts" assim:

JSON
"scripts": {
    "limpar": [
        "php artisan config:clear",
        "php artisan cache:clear",
        "composer dump-autoload"
    ]
}
composer limpar (Exemplo de Script Customizado)

Ao rodar esse comando criado por você, o composer executará os três comandos em lote automaticamente!

## composer dump-autoload


## Developer: Reload Window

## composer require tymon/jwt-auth

## composer require tymon/jwt-auth --with-all-dependencies && composer dump-autoload


Erros de limpeza
## composer dump-autoload

## composer dump-autoload -o


## composer clear-cache



## Autocompleta Models, Relations, Facades e Services.
## composer require --dev barryvdh/laravel-ide-helper



## Ajuda muito a codar

## composer require laravel/pint --dev

## Gerar Helpers
## php artisan ide-helper:generate

Verifica se você alterou manualmente algum arquivo dentro da pasta vendor (o que nunca deve ser feito).
## composer status


## composer show -t

Exibe uma árvore visual de dependências. Ótimo para descobrir qual pacote instalou aquela biblioteca misteriosa de fundo.

## composer outdated

Lista todos os pacotes do seu projeto que possuem versões mais recentes disponíveis para atualização.

## composer why <pacote>

Explica o porquê de determinado pacote estar instalado no seu projeto (mostra qual outra biblioteca depende dele).

## composer why-not <pacote> <versao>

Mostra o motivo de você não conseguir atualizar um pacote para uma versão específica (aponta conflitos de versão do PHP ou de outras libs).



## Instalar o larastan para ficar mais rápido

## composer require larastan/larastan --dev

## composer require yajra/laravel-datatables-oracle

## Shell
## composer require prettus/l5-repository


## composer require ramsey/uuid

## composer require fakerphp/faker

## Gerenciar Comandos Uteis

## php artisan ide-helper:generate

## hp artisan ide-helper:models -RW

## php artisan ide-helper:meta



## PHP ARTISAN OPTIMIZE:CLEAR (FAZ O QUE)
Plain Text

PHP Intelephense
Laravel Extra Intellisense
Laravel Blade Formatter
Laravel Snippets

Laravel Artisan
GitLens
Error Lens
Path Intellisense


code --install-extension bmewburn.vscode-intelephense-client

code --install-extension amiralizadeh9480.laravel-extra-intellisense

code --install-extension shufo.vscode-blade-formatter

code --install-extension onecentlin.laravel-blade

code --install-extension ryannaddy.laravel-artisan

code --install-extension eamodio.gitlens

code --install-extension usernamehw.errorlens

code --install-extension christian-kohler.path-intellisense

code --install-extension mikestead.dotenv

code --install-extension deveditormx.phptools-vscode


ctrl shift + p

Preferences: Open User Settings (JSON)
Mostrar mais linhas

{
    "editor.formatOnSave": true,
    "editor.codeActionsOnSave": {
        "source.organizeImports": "always"
    },
    "[php]": {
        "editor.defaultFormatter": "bmewburn.vscode-intelephense-client"
    },
    "[blade]": {
        "editor.defaultFormatter": "shufo.vscode-blade-formatter"
    }
}


## Compose Require

composer require --dev barryvdh/laravel-ide-helper


## Atalhos Uteis

F12 → Ir para definição
Alt + ← → Voltar
F2 → Renomear
Ctrl + Espaço → Autocomplete
Ctrl + P → Procurar arquivo
Ctrl + Shift + P → Paleta de comandos
Shift + Alt + F → Formatar código


## IDE HELPER
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models -RW
php artisan ide-helper:meta
php artisan jwt:secret



## php artisan optimize:clear

## composer dump-autoload


## ctrl + shift + P
Developer: Reload Window


## php artisan config:clear
## sudo apt update
## sudo apt install php8.4-pgsql php8.4-sqlite3 -y


#### DICAS

# 1. Limpa o cache de configurações antigo
php artisan config:clear
php artisan cache:clear

# 2. Roda as migrações no Postgres (ou SQLite, dependendo do seu .env)

## php artisan migrate


## composer ide


## Veiculo::all();

## Veiculo::find(1);

## Veiculo::create($dados);

## Veiculo::count();

## Veiculo::where('placa', 'ABC1234')->first();


# Instala o autocomplete perfeito de PHP
code --install-extension bmewburn.vscode-intelephense

# Instala o autocomplete específico para rotas, views e configs do Laravel
code --install-extension amiralizadeh9480.laravel-extra-intellisense

# Instala formatação para arquivos .blade.php
code --install-extension shufo.vscode-blade-formatter

# Atalho para clicar em uma View no Controller e ir direto para o arquivo
code --install-extension codingyu.laravel-goto-view


##
code --install-extension bmewburn.vscode-intelephense-client
code --install-extension amiralizadeh9480.laravel-extra-intellisense
code --install-extension onecentlin.laravel-extension-pack
code --install-extension eamodio.gitlens
code --install-extension usernamehw.errorlens
code --install-extension christian-kohler.path-intellisense
code --install-extension formulahendry.auto-rename-tag
code --install-extension streetsidesoftware.code-spell-checker

##################################


➜  financiamento-veiculos php artisan list
Laravel Framework 13.20.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
      --silent          Do not output any message
  -q, --quiet           Only errors are displayed. All other output is suppressed
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  about                     Display basic information about your application
  clear-compiled            Remove the compiled class file
  completion                Dump the shell completion script
  db                        Start a new database CLI session
  dev                       Run the dev processes
  docs                      Access the Laravel documentation
  down                      Put the application into maintenance / demo mode
  env                       Display the current framework environment
  help                      Display help for a command
  inspire                   Display an inspiring quote
  list                      List commands
  migrate                   Run the database migrations
  optimize                  Cache framework bootstrap, configuration, and metadata to increase performance
  pail                      Tails the application logs
  reload                    Reload running services
  serve                     Serve the application on the PHP development server
  test                      Run the application tests
  tinker                    Interact with your application
  up                        Bring the application out of maintenance mode
 app
  app:main                  Command description
 auth
  auth:clear-resets         Flush expired password reset tokens
 cache
  cache:clear               Flush the application cache
  cache:forget              Remove an item from the cache
  cache:prune-stale-tags    Prune stale cache tags from the cache (Redis only)
 channel
  channel:list              List all registered private broadcast channels
 config
  config:cache              Create a cache file for faster configuration loading
  config:clear              Remove the configuration cache file
  config:publish            Publish configuration files to your application
  config:show               Display all of the values for a given configuration file or key
 db
  db:monitor                Monitor the number of connections on the specified database
  db:seed                   Seed the database with records
  db:show                   Display information about the given database
  db:table                  Display information about the given database table
  db:wipe                   Drop all tables, views, and types
 dev
  dev:list                  List the registered dev processes
 env
  env:decrypt               Decrypt an environment file
  env:encrypt               Encrypt an environment file
 event
  event:cache               Discover and cache the application's events and listeners
  event:clear               Clear all cached events and listeners
  event:list                List the application's events and listeners
 ide-helper
  ide-helper:eloquent       Add \Eloquent helper to \Eloquent\Model
  ide-helper:generate       Generate a new IDE Helper file.
  ide-helper:meta           Generate metadata for PhpStorm
  ide-helper:models         Generate autocompletion for models
 install
  install:api               Create an API routes file and install Laravel Sanctum or Laravel Passport
  install:broadcasting      Create a broadcasting channel routes file
 jwt
  jwt:secret                Set the JWTAuth secret key used to sign the tokens
 key
  key:generate              Set the application key
 lang
  lang:publish              Publish all language files that are available for customization
 make
  make:cache-table          [cache:table] Create a migration for the cache database table
  make:cast                 Create a new custom Eloquent cast class
  make:channel              Create a new channel class
  make:class                Create a new class
  make:command              Create a new Artisan command
  make:component            Create a new view component class
  make:config               [config:make] Create a new configuration file
  make:controller           Create a new controller class
  make:enum                 Create a new enum
  make:event                Create a new event class
  make:exception            Create a new custom exception class
  make:export               Create a new export class
  make:factory              Create a new model factory
  make:import               Create a new import class
  make:interface            Create a new interface
  make:job                  Create a new job class
  make:job-middleware       Create a new job middleware class
  make:listener             Create a new event listener class
  make:mail                 Create a new email class
  make:middleware           Create a new HTTP middleware class
  make:migration            Create a new migration file
  make:model                Create a new Eloquent model class
  make:notification         Create a new notification class
  make:notifications-table  [notifications:table] Create a migration for the notifications table
  make:observer             Create a new observer class
  make:policy               Create a new policy class
  make:provider             Create a new service provider class
  make:queue-batches-table  [queue:batches-table] Create a migration for the batches database table
  make:queue-failed-table   [queue:failed-table] Create a migration for the failed queue jobs database table
  make:queue-table          [queue:table] Create a migration for the queue jobs database table
  make:request              Create a new form request class
  make:resource             Create a new resource
  make:rule                 Create a new validation rule
  make:scope                Create a new scope class
  make:seeder               Create a new seeder class
  make:session-table        [session:table] Create a migration for the session database table
  make:test                 Create a new test class
  make:trait                Create a new trait
  make:view                 Create a new view
 migrate
  migrate:fresh             Drop all tables and re-run all migrations
  migrate:install           Create the migration repository
  migrate:refresh           Reset and re-run all migrations
  migrate:reset             Rollback all database migrations
  migrate:rollback          Rollback the last database migration
  migrate:status            Show the status of each migration
 model
  model:prune               Prune models that are no longer needed
  model:show                Show information about an Eloquent model
 optimize
  optimize:clear            Remove the cached bootstrap files
 package
  package:discover          Rebuild the cached package manifest
 queue
  queue:clear               Delete all of the jobs from the specified queue
  queue:failed              List all of the failed queue jobs
  queue:flush               Flush all of the failed queue jobs
  queue:forget              Delete a failed queue job
  queue:listen              Listen to a given queue
  queue:monitor             Monitor the size of the specified queues
  queue:pause               Pause job processing for a specific queue
  queue:prune-batches       Prune stale entries from the batches database
  queue:prune-failed        Prune stale entries from the failed jobs table
  queue:restart             Restart queue worker daemons after their current job
  queue:resume              [queue:continue] Resume job processing for a paused queue
  queue:retry               Retry a failed queue job
  queue:retry-batch         Retry the failed jobs for a batch
  queue:work                Start processing jobs on the queue as a daemon
 route
  route:cache               Create a route cache file for faster route registration
  route:clear               Remove the route cache file
  route:list                List all registered routes
 schedule
  schedule:clear-cache      Delete the cached mutex files created by scheduler
  schedule:interrupt        Interrupt the current schedule run
  schedule:list             List all scheduled tasks
  schedule:pause            Pause the scheduler
  schedule:resume           [schedule:continue] Resume the schedule
  schedule:run              Run the scheduled commands
  schedule:test             Run a scheduled command
  schedule:work             Start the schedule worker
 schema
  schema:dump               Dump the given database schema
 storage
  storage:link              Create the symbolic links configured for the application
  storage:unlink            Delete existing symbolic links configured for the application
 stub
  stub:publish              Publish all stubs that are available for customization
 vendor
  vendor:publish            Publish any publishable assets from vendor packages
 view
  view:cache                Compile all of the application's Blade templates
  view:clear                Clear all compiled view files


  ## Ctrl + Shift + P
  ## Developer: Reload Window

  ## SQLLite3

##  sudo apt update

## sudo apt install php8.4-pgsql php8.4-sqlite3 -y

composer ide

## php artisan about
  make:component            Create a new view component class
  make:config               [config:make] Create a new configuration file
  make:controller           Create a new controller class
  make:enum                 Create a new enum
  make:event                Create a new event class
  make:exception            Create a new custom exception class
  make:export               Create a new export class
  make:factory              Create a new model factory
  make:import               Create a new import class
  make:interface            Create a new interface
  make:job                  Create a new job class
  make:job-middleware       Create a new job middleware class
  make:listener             Create a new event listener class
  make:mail                 Create a new email class
  make:middleware           Create a new HTTP middleware class
  make:migration            Create a new migration file
  make:model                Create a new Eloquent model class
  make:notification         Create a new notification class
  make:notifications-table  [notifications:table] Create a migration for the notifications table
  make:observer             Create a new observer class
  make:policy               Create a new policy class
  make:provider             Create a new service provider class
  make:queue-batches-table  [queue:batches-table] Create a migration for the batches database table
  make:queue-failed-table   [queue:failed-table] Create a migration for the failed queue jobs database table
  make:queue-table          [queue:table] Create a migration for the queue jobs database table
  make:request              Create a new form request class
  make:resource             Create a new resource
  make:rule                 Create a new validation rule
  make:scope                Create a new scope class
  make:seeder               Create a new seeder class
  make:session-table        [session:table] Create a migration for the session database table
  make:test                 Create a new test class
  make:trait                Create a new trait
  make:view                 Create a new view
 migrate
  migrate:fresh             Drop all tables and re-run all migrations
  migrate:install           Create the migration repository
  migrate:refresh           Reset and re-run all migrations
  migrate:reset             Rollback all database migrations
  migrate:rollback          Rollback the last database migration
  migrate:status            Show the status of each migration
 model
  model:prune               Prune models that are no longer needed
  model:show                Show information about an Eloquent model
 optimize
  optimize:clear            Remove the cached bootstrap files
 package
  package:discover          Rebuild the cached package manifest
 queue
  queue:clear               Delete all of the jobs from the specified queue
  queue:failed              List all of the failed queue jobs
  queue:flush               Flush all of the failed queue jobs
  queue:forget              Delete a failed queue job
  queue:listen              Listen to a given queue
  queue:monitor             Monitor the size of the specified queues
  queue:pause               Pause job processing for a specific queue
  queue:prune-batches       Prune stale entries from the batches database
  queue:prune-failed        Prune stale entries from the failed jobs table
  queue:restart             Restart queue worker daemons after their current job
  queue:resume              [queue:continue] Resume job processing for a paused queue
  queue:retry               Retry a failed queue job
  queue:retry-batch         Retry the failed jobs for a batch
  queue:work                Start processing jobs on the queue as a daemon
 route
  route:cache               Create a route cache file for faster route registration
  route:clear               Remove the route cache file
  route:list                List all registered routes
 schedule
  schedule:clear-cache      Delete the cached mutex files created by scheduler
  schedule:interrupt        Interrupt the current schedule run
  schedule:list             List all scheduled tasks
  schedule:pause            Pause the scheduler
  schedule:resume           [schedule:continue] Resume the schedule
  schedule:run              Run the scheduled commands
  schedule:test             Run a scheduled command
  schedule:work             Start the schedule worker
 schema
  schema:dump               Dump the given database schema
 storage
  storage:link              Create the symbolic links configured for the application
  storage:unlink            Delete existing symbolic links configured for the application
 stub
  stub:publish              Publish all stubs that are available for customization
 vendor
  vendor:publish            Publish any publishable assets from vendor packages
 view
  view:cache                Compile all of the application's Blade templates
?➜  financiamento-veiculos
 *  History restored

➜  financiamento-veiculos php artisan about

  Environment ...........................................................
  Application Name .............................................. Laravel
  Laravel Version ............................................... 13.20.0
  PHP Version .................................................... 8.4.23
  Composer Version ............................................... 2.10.2
  Environment ..................................................... local
  Debug Mode .................................................... ENABLED
  URL ......................................................... localhost
  Maintenance Mode .................................................. OFF
  Timezone .......................................................... UTC
  Locale ............................................................. en

  Cache .................................................................
  Config ..................................................... NOT CACHED
  Events ..................................................... NOT CACHED
  Routes ..................................................... NOT CACHED
  Views ...................................................... NOT CACHED

  Drivers ...............................................................
  Broadcasting ...................................................... log
  Cache ........................................................ database
  Database ........................................................ pgsql
  Logs ................................................... stack / single
  Mail .............................................................. log
  Queue ........................................................ database
  Session ...................................................... database

  Storage ...............................................................
  public/storage ............................................. NOT LINKED

  ## Current application environment: local

  ## Current application environment: production

  ## php artisan migrate

  ## php artisan env

  ## php artisan serve

  ## php artisan serve --port=8080

  ## php artisan test --filter=VeiculoTest

  ## php artisan test tests/Feature/AuthTest.php



## php artisan config:clear

## php artisan cache:clear
 php artisan about

  Environment ...........................................................
  Application Name .............................................. Laravel
  Laravel Version ............................................... 13.20.0
  PHP Version .................................................... 8.4.23
  Composer Version ............................................... 2.10.2
  Environment ..................................................... local
  Debug Mode .................................................... ENABLED
  URL ......................................................... localhost
  Maintenance Mode .................................................. OFF
  Timezone .......................................................... UTC
  Locale ............................................................. en

  Cache .................................................................
  Config ..................................................... NOT CACHED
  Events ..................................................... NOT CACHED
  Routes ..................................................... NOT CACHED
  Views ...................................................... NOT CACHED

  Drivers ...............................................................
  Broadcasting ...................................................... log
  Cache ........................................................ database
  Database ........................................................ pgsql
  Logs ................................................... stack / single
  Mail .............................................................. log
  Queue ........................................................ database
  Session ...................................................... database

  Storage ...............................................................
  public/storage ............................................. NOT LINKED


## k3s
# kubectl get nodes

# kubectl get pods -a

# kubeclt create namespace portainer

## pod postgres

## postgres.yaml


apiVersion: v1
kind: PersistentVolumeClaim
metadata:
  name: postgres-pvc
spec:
  accessModes:
    - ReadWriteOnce
  resources:
    requests:
      storage: 2Gi
---
apiVersion: apps/v1
kind: Deployment
metadata:
  name: postgres
spec:
  replicas: 1
  selector:
    matchLabels:
      app: postgres
  template:
    metadata:
      labels:
        app: postgres
    spec:
      containers:
      - name: postgres
        image: postgres:15-alpine
        env:
        - name: POSTGRES_DB
          value: "laravel_db"
        - name: POSTGRES_USER
          value: "postgres_user"
        - name: POSTGRES_PASSWORD
          value: "postgres_password"
        ports:
        - containerPort: 5432
        volumeMounts:
        - name: postgres-storage
          mountPath: /var/lib/postgresql/data
      volumes:
      - name: postgres-storage
        persistentVolumeClaim:
          claimName: postgres-pvc
---
apiVersion: v1
kind: Service
metadata:
  name: postgres-service
spec:
  selector:
    app: postgres
  ports:
    - protocol: TCP
      port: 5432
      targetPort: 5432

## ===============================

# kubectl get pods -A
NAMESPACE     NAME                                      READY   STATUS      RESTARTS      AGE
default       postgres-6499d5569b-b527p                 1/1     Running     0             2m18s
kube-system   coredns-5f5694d56b-9wj7v                  1/1     Running     0             15m
kube-system   helm-install-traefik-crd-flwfq            0/1     Completed   0             15m
kube-system   helm-install-traefik-zp4gt                0/1     Completed   1 (15m ago)   15m
kube-system   local-path-provisioner-58d557dc48-gbp6j   1/1     Running     0             15m
kube-system   metrics-server-7c86f97b8d-qmb6v           1/1     Running     0             15m
kube-system   svclb-traefik-7c2ceaf5-jlzwb              2/2     Running     0             15m
kube-system   traefik-6cd8c7cd89-f2ptl                  1/1     Running     0             15m


# kubectl create namespace portainer --dry-run=client -o yaml | kubectl apply -f -

# 2. Aplica a instalação oficial do Portainer

# kubectl apply -n portainer -f https://raw.githubusercontent.com/portainer/k8s/master/deploy/manifests/portainer/portainer.yaml


## Esse dá o download e aplica

# kubectl apply -n portainer -f https://downloads.portainer.io/ce-lts/portainer.yaml


# kubectl get pods -n portainer


## kubectl get svc -n portainer

# ➜  financiamento-veiculos


## kubectl apply -n portainer -f https://downloads.portainer.io/ce-lts/portainer.yaml


namespace/portainer configured
serviceaccount/portainer-sa-clusteradmin created
persistentvolumeclaim/portainer created
clusterrolebinding.rbac.authorization.k8s.io/portainer created
service/portainer created
deployment.apps/portainer created
➜  financiamento-veiculos kubectl get pods -n portainer
NAME                         READY   STATUS    RESTARTS   AGE
portainer-6f577fd6f9-697g6   1/1     Running   0          5m13s
➜  financiamento-veiculos

## kubectl get svc -n portainer



NAME        TYPE       CLUSTER-IP     EXTERNAL-IP   PORT(S)                                         AGE
portainer   NodePort   10.43.181.98   <none>        9000:30777/TCP,9443:30779/TCP,30776:30776/TCP   27m

## kubectl get svc -n portainer

#  kubectl apply -n portainer -f https://downloads.portainer.io/ce-lts/portainer.yaml
namespace/portainer unchanged
serviceaccount/portainer-sa-clusteradmin unchanged
persistentvolumeclaim/portainer unchanged
clusterrolebinding.rbac.authorization.k8s.io/portainer unchanged
service/portainer unchanged
deployment.apps/portainer configured

# kubectl get pods -n portainer


# openssl rand -base64 32
Nbz1UYG8ayam3ARHrrd2jFOwd6AyJwWe52q1Cf2HaPs=

# nano auth-proxy.yaml


## Comando Kubernete
```php=
 kubectl apply -f auth-proxy.yaml
secret/oauth2-proxy-creds created
deployment.apps/oauth2-proxy created
service/oauth2-proxy-service created
```

## Kubernete

```kubectl=
 kubectl rollout restart deployment/oauth2-proxy
deployment.apps/oauth2-proxy restarted
```

```kubectl=
 kubectl get pods
```

```kubectl=
 openssl rand -hex 16
```

bfe6ba09a971b90f5bc6bf82640db154

kubectl patch secret oauth2-proxy-creds -p "{\"stringData\":{\"cookie-secret\":\"bfe6ba09a971b90f5bc6bf82640db154\"}}"
secret/oauth2-proxy-creds patched

kubectl rollout restart deployment/oauth2-proxy
kubectl get pods

➜  financiamento-veiculos kubectl get pods
NAME                            READY   STATUS    RESTARTS   AGE
oauth2-proxy-67dcf59f8b-sk5wp   1/1     Running   0          13s
postgres-6499d5569b-b527p       1/1     Running   0          122m

## code --install-extension MehediDracula.php-namespace-resolver

```php=
code --install-extension Gruntfuggly.todo-tree

code --install-extension MehediDracula.php-namespace-resolver

composer require league/flysystem-aws-s3-v3



code --install-extension amiralizadeh94.laravel-extra-intellisense
code --install-extension onecentlin.laravel-blade
code --install-extension bmewburn.vscode-intelephense-client


php artisan make:job ProcessarPropostaFinanciamento

code --list-extensions

php artisan migrate:fresh --seed

ou kubectl apply -f auth-proxy.yaml

code --install-extension robertohuertas.vscode-icons

rm -rf vendor/phpunit

composer install

composer dump-autoload -o

➜  financiamento-veiculos rm -rf vendor/phpunit
➜  financiamento-veiculos composer clear-cache
Clearing cache (cache-vcs-dir): /home/edsonsouza/.cache/composer/vcs
Clearing cache (cache-repo-dir): /home/edsonsouza/.cache/composer/repo
Clearing cache (cache-files-dir): /home/edsonsouza/.cache/composer/files
Clearing cache (cache-dir): /home/edsonsouza/.cache/composer
All caches cleared.
➜  financiamento-veiculos composer install
Installing dependencies from lock file (including require-dev)
Verifying lock file contents can be installed on current platform.
Package operations: 6 installs, 0 updates, 0 removals
  - Downloading phpunit/php-timer (8.0.0)
  - Downloading phpunit/php-text-template (5.0.0)
  - Downloading phpunit/php-invoker (6.0.0)
  - Downloading phpunit/php-file-iterator (6.0.1)
  - Downloading phpunit/php-code-coverage (12.5.7)
  - Downloading phpunit/phpunit (12.5.31)
  - Installing phpunit/php-timer (8.0.0): Extracting archive
  - Installing phpunit/php-text-template (5.0.0): Extracting archive
  - Installing phpunit/php-invoker (6.0.0): Extracting archive
  - Installing phpunit/php-file-iterator (6.0.1): Extracting archive
  - Installing phpunit/php-code-coverage (12.5.7): Extracting archive
  - Installing phpunit/phpunit (12.5.31): Extracting archive
 5/6 [=======================>----]  83%    Skipped installation of bin phpunit for package phpunit/phpunit: name conflicts with an existing file
Generating optimized autoload files


  barryvdh/laravel-ide-helper ...................................... DONE
  laravel/pail ..................................................... DONE
  laravel/pao ...................................................... DONE
  laravel/tinker ................................................... DONE
  maatwebsite/excel ................................................ DONE
  nesbot/carbon .................................................... DONE
  nunomaduro/collision ............................................. DONE
  nunomaduro/termwind .............................................. DONE
  tymon/jwt-auth ................................................... DONE

86 packages you are using are looking for funding.
Use the `composer fund` command to find out more!
make -f ./Makefile test

composer install
composer dump-autoload
php artisan serve

git add composer.lock
git commit -m "fix: atualizando dependencias do excel para suportar PHP 8.5"
git push origin main
```
