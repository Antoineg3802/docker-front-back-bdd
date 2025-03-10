# Utilisation d'une image PHP avec FPM
FROM php:8.1-fpm

# Installation des dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Installation de Composer depuis l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier les fichiers de dépendances et installer les librairies PHP
COPY composer.json composer.lock ./
RUN composer install --no-scripts --prefer-dist --no-progress --no-dev

# Copier l'intégralité du code de l'application
COPY . .

# Attribuer les droits nécessaires au dossier de l'application
RUN chown -R www-data:www-data /var/www

# Exposer le port utilisé par PHP-FPM
EXPOSE 8000

# Démarrer PHP-FPM
CMD ["php-fpm"]
