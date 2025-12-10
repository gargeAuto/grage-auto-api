#!/bin/sh

# Attendre MySQL
echo "Waiting for MySQL..."
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); echo 'OK'; } catch (Exception \$e) { exit(1); }"; do
    sleep 2
done

echo "MySQL is ready!"

# Lancer les migrations
php artisan migrate --force

# Exécuter la commande finale (php artisan serve)
exec "$@"
