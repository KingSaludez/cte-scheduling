#!/bin/bash
echo "=== start.sh running ==="

APP_KEY=$(php -r "echo 'base64:' . base64_encode(random_bytes(32));")
cat > .env << EOF
APP_NAME="CTE NEMSU Tagbina"
APP_ENV=production
APP_URL=https://cte-scheduling.onrender.com
APP_DEBUG=false
APP_KEY=${APP_KEY}
DB_CONNECTION=pgsql
DB_URL=postgresql://cte_scheduling_user:NwKQJuzccef5H7EpLZzQxJfbnHbqUhCS@dpg-d97qqh57vvec73cok1r0-a.singapore-postgres.render.com/cte_scheduling
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
EOF

echo "Warming caches..."
php artisan optimize 2>&1

echo "Running migrations..."
for i in 1 2 3; do
  php artisan migrate --force --no-interaction 2>&1 && { echo "OK"; break; }
  [ "$i" -lt 3 ] && echo "Retry $i..." && sleep 3
done

echo "Starting PHP server..."
exec php -S 0.0.0.0:${PORT} -t public
