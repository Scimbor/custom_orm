FROM php:8.3-cli

# Instalacja curl, unzip, git i innych zależności
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        unzip \
        git \
        libzip-dev \
        zip \
        libpq-dev \
        libsqlite3-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql pdo_pgsql pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalacja Composera
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]