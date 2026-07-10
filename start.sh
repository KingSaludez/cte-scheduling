#!/bin/bash
echo "=== start.sh running ==="

APP_KEY=$(php -r "echo 'base64:' . base64_encode(random_bytes(32));")
DB_HOST="dpg-d97qqh57vvec73cok1r0-a.singapore-postgres.render.com"
DB_PORT="5432"
DB_NAME="cte_scheduling"
DB_USER="cte_scheduling_user"
DB_PASS="NwKQJuzccef5H7EpLZzQxJfbnHbqUhCS"

cat > .env << EOF
APP_NAME="CTE NEMSU Tagbina"
APP_ENV=production
APP_URL=https://cte-scheduling.onrender.com
APP_DEBUG=false
APP_KEY=${APP_KEY}
DB_CONNECTION=pgsql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_NAME}
DB_USERNAME=${DB_USER}
DB_PASSWORD=${DB_PASS}
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
EOF

echo "Waiting for database connection..."
for i in 1 2 3 4 5 6 7 8 9 10; do
  php -r "
    try {
      new PDO('pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_NAME}', '${DB_USER}', '${DB_PASS}');
      echo \"DB OK\n\";
      exit(0);
    } catch (Exception \$e) {
      echo \"attempt $i: \" . \$e->getMessage() . \"\n\";
      exit(1);
    }
  " 2>&1 && break
  sleep 5
done

echo "Warming caches..."
php artisan optimize 2>&1

echo "Running migrations..."
for i in 1 2 3; do
  php artisan migrate --force --no-interaction 2>&1 && { echo "Migrations OK"; break; }
  [ "$i" -lt 3 ] && echo "Retry $i..." && sleep 3
done

echo "Starting PHP server..."
exec php -S 0.0.0.0:${PORT} -t public