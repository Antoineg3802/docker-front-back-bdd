# Utiliser une image PHP compatible, ici PHP 8.1 avec FPM
FROM php:8.2-fpm

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libpq-dev \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y netcat-openbsd

# Installer Composer depuis une image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers de configuration de Composer et installer les dépendances
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-scripts --no-progress --no-interaction

# Installer le Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Copier l'ensemble du code
COPY . .

# Exposer le port (celui-ci doit correspondre à celui utilisé par Symfony, ici 8000 par exemple)
EXPOSE ${APP_PORT}

ENTRYPOINT [ "/var/www/entrypoint.sh" ]

CMD ["symfony", "serve", "--allow-all-ip", "--no-tls", "--port=8000"]
