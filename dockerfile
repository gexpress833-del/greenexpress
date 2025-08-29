# Utilise PHP 8.3 (pas 8.2)
FROM php:8.3-cli

# Installe les extensions nécessaires
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Répertoire de travail
WORKDIR /app

# Copie les fichiers Laravel
COPY . .

# Installation des dépendances Laravel
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 8000

# Commande de démarrage
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
