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

echo "Clearing caches..."
php artisan route:clear
php artisan view:clear

echo "Running migrations (with retry)..."
for i in 1 2 3 4 5; do
  echo "--- Attempt $i ---"
  php artisan migrate --force --no-interaction -v > /tmp/migration.log 2>&1
  cat /tmp/migration.log
  if grep -qi "Nothing to migrate" /tmp/migration.log; then
    echo "All migrations already applied."
    break
  fi
  if grep -qi "DONE" /tmp/migration.log; then
    echo "Migrations applied successfully!"
    break
  fi
  echo "Migration failed or pending, retrying in 3s..."
  sleep 3
done

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=$PORT
