#!/bin/bash
# Generate .env from environment variables for Laravel
echo "APP_ENV=${APP_ENV:-production}" > .env
echo "APP_DEBUG=${APP_DEBUG:-false}" >> .env
echo "APP_KEY=${APP_KEY}" >> .env
echo "DB_CONNECTION=${DB_CONNECTION:-pgsql}" >> .env
echo "DB_URL=${DB_URL}" >> .env
echo "SESSION_DRIVER=${SESSION_DRIVER:-file}" >> .env
echo "CACHE_STORE=${CACHE_STORE:-file}" >> .env
echo "QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}" >> .env

php artisan serve --host=0.0.0.0 --port=$PORT
