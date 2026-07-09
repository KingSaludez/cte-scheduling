#!/bin/bash
echo "=== start.sh running ==="

APP_KEY=$(php -r "echo 'base64:' . base64_encode(random_bytes(32));")
cat > .env << EOF
APP_ENV=production
APP_DEBUG=true
APP_KEY=${APP_KEY}
DB_CONNECTION=pgsql
DB_URL=postgresql://cte_scheduling_user:NwKQJuzccef5H7EpLZzQxJfbnHbqUhCS@dpg-d97qqh57vvec73cok1r0-a/cte_scheduling
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
EOF

echo "Starting Laravel server..."
php artisan serve --host=0.0.0.0 --port=$PORT
