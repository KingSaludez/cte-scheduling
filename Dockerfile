FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
  && docker-php-ext-install pdo pdo_pgsql pgsql

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

COPY start.sh /app/start.sh
RUN chmod +x /app/start.sh \
  && npm ci && npm run build \
  && composer install --no-dev --optimize-autoloader \
  && chmod -R 777 storage bootstrap/cache

CMD /app/start.sh
