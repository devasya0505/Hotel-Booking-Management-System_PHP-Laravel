# ---------- Stage 1: Build frontend (Vite) ----------
FROM node:18 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# ---------- Stage 2: PHP + Laravel ----------
FROM php:8.2-cli

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy Laravel project
COPY . .

# Copy built frontend assets
COPY --from=frontend /app/public/build /var/www/public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Clear Laravel caches
RUN php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear

# Expose port (Render uses dynamic PORT)
EXPOSE 8000

# Start server (FINAL CORRECT COMMAND)
CMD php artisan serve --host=0.0.0.0 --port=$PORT