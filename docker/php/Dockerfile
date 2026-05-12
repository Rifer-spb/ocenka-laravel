FROM php:8.2-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    libsqlite3-dev \
    sqlite3 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Установка Node.js 20.x (LTS) и npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Установка расширений PHP
RUN docker-php-ext-install mbstring exif pcntl bcmath gd zip

# Установка pdo_pgsql отдельно с отладкой
RUN docker-php-ext-install pdo_pgsql pdo_sqlite

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Настройка рабочей директории
WORKDIR /var/www/html
