FROM ubuntu:22.04

# Installer les dépendances système
RUN apt-get update \
    && apt-get install -y \
        git \
        curl \
        zip \
        unzip \
        php \
        php-cli \
        php-common \
        php-fpm \
        php-mysql \
        php-xml \
        php-mbstring \
        php-curl \
        php-zip \
        php-tokenizer \
        php-fileinfo \
        php-opcache \
    && apt-get clean

# Installer Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Définir le dossier de travail
WORKDIR /var/www/html

# Copier l’application
COPY . /var/www/html

# Donner les permissions nécessaires à Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Exposer le port (utile pour Nginx interne de Sail)
EXPOSE 80

CMD ["php-fpm"]