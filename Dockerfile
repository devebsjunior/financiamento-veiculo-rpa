FROM php:8.4-fpm-alpine

# Instala dependências do SO + librdkafka para o Kafka
RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    librdkafka-dev \
    $PHPIZE_DEPS

# Instala extensoes PHP (pdo_pgsql) e compila rdkafka via PECL
RUN docker-php-ext-install pdo_pgsql zip \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

WORKDIR /var/www
