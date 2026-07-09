#!/bin/bash
echo "=== start.sh running ==="
echo "APP_ENV=${APP_ENV:-not_set}"
echo "DB_URL=${DB_URL:-not_set}"
echo "APP_KEY length: ${#APP_KEY}"
echo "SESSION_DRIVER=${SESSION_DRIVER:-not_set}"
echo "=== All env vars ==="
env | sort
echo "=== End env vars ==="

echo "APP_ENV=${APP_ENV:-production}" > .env
echo "APP_DEBUG=${APP_DEBUG:-false}" >> .env
if [ -z "$APP_KEY" ]; then
  echo "APP_KEY not set, generating..."
  php artisan key:generate
else
  echo "APP_KEY=${APP_KEY}" >> .env
fi
echo "DB_CONNECTION=${DB_CONNECTION:-pgsql}" >> .env
echo "DB_URL=${DB_URL}" >> .env
echo "SESSION_DRIVER=${SESSION_DRIVER:-file}" >> .env
echo "CACHE_STORE=${CACHE_STORE:-file}" >> .env
echo "QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}" >> .env

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=$PORT
