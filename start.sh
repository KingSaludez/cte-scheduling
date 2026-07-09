#!/bin/bash
echo "=== start.sh running ==="

echo "APP_ENV=production" > .env
echo "APP_DEBUG=true" >> .env
php artisan key:generate
echo "DB_CONNECTION=pgsql" >> .env
echo "DB_URL=postgresql://cte_scheduling_user:NwKQJuzccef5H7EpLZzQxJfbnHbqUhCS@dpg-d97qqh57vvec73cok1r0-a/cte_scheduling" >> .env
echo "SESSION_DRIVER=file" >> .env
echo "CACHE_STORE=file" >> .env
echo "QUEUE_CONNECTION=sync" >> .env

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=$PORT
