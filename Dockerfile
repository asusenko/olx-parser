FROM php:8.2-fpm

# Встановлення системних залежностей
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install zip pdo_mysql gd

# Встановлення Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Встановлення Node.js та npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs
RUN apt-get update && apt-get install -y cron

WORKDIR /var/www/html

# Встановлення прав доступу
RUN chown -R www-data:www-data /var/www/html
