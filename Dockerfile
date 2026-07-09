FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
  && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader \
  && chmod -R 777 storage bootstrap/cache

CMD php artisan serve --host=0.0.0.0 --port=$PORT
