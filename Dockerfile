# ---------- Base ----------
FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

# Installer dépendances système
RUN apt-get update && apt-get install -y \
    software-properties-common \
    ca-certificates \
    lsb-release \
    curl \
    git \
    unzip \
    zip

# Ajouter le dépôt PHP d'Ondrej
RUN add-apt-repository ppa:ondrej/php -y

# Installer PHP 8.2 + extensions
RUN apt-get update && apt-get install -y \
    php8.2 \
    php8.2-cli \
    php8.2-mysql \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-curl \
    php8.2-zip \
    php8.2-bcmath \
    php8.2-intl \
    php8.2-gd \
    php8.2-opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Dossier de travail
WORKDIR /var/www/html

# Copier l'application
COPY . /var/www/html

# Installer dépendances Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Permissions Laravel
RUN useradd -m appuser \
    && chown -R appuser:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Passer à l'utilisateur appuser
USER appuser

# Exposer le port
EXPOSE 8085

# Copier l'entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Définir l'entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# CMD final pour le serveur Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8085"]
