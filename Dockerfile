# ---------- Base image ----------
FROM ubuntu:22.04

# ---------- Variables d'environnement ----------
ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Europe/Paris

# ---------- Installer dépendances système ----------
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    wget \
    nano \
    ca-certificates \
    supervisor \
    nginx \
    php8.2 \
    php8.2-fpm \
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
    php8.2-soap \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ---------- Installer Composer ----------
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# ---------- Créer le dossier de travail ----------
WORKDIR /var/www/html

# ---------- Copier l'application ----------
COPY . /var/www/html

# ---------- Permissions ----------
RUN useradd -G www-data,root -u 1000 -d /home/app app \
    && chown -R app:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ---------- Configurer Nginx ----------
RUN rm /etc/nginx/sites-enabled/default
COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# ---------- Supervisord pour PHP-FPM + Nginx ----------
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# ---------- Exposer ports ----------
EXPOSE 80 443

# ---------- Entrypoint ----------
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
