#!/bin/sh
set -e

echo "Starting entrypoint..."

# --- Attendre MySQL ---
echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h"$DB_HOST" -P"$DB_PORT" --silent; do
    sleep 2
done
echo "MySQL is ready!"

# --- Lancer les migrations ---
echo "Running migrations..."
php artisan migrate:fresh --seed --force
#php artisan db:seed --force

# --- Lancer le serveur Laravel ---
echo "Starting Laravel..."
exec php artisan serve --host=0.0.0.0 --port=8085
