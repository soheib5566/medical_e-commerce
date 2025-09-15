# ------------------------------
# Stage 1: Build Assets with Node
# ------------------------------
FROM node:18 AS node-builder

WORKDIR /app

# Copy package files first for better caching
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy source files for building
COPY . .

# Build assets for production
RUN npm run build

# ------------------------------
# Stage 2: PHP + Laravel Setup
# ------------------------------
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    mariadb-client \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install PHP dependencies (without dev dependencies for production)
RUN composer install --optimize-autoloader --no-dev --no-scripts

# Copy application files
COPY . .

# Copy built assets from node stage
COPY --from=node-builder /app/public/build ./public/build

# Create .env file with default production values
RUN if [ ! -f .env ]; then \
    echo "APP_NAME=Medical E-commerce" > .env && \
    echo "APP_ENV=production" >> .env && \
    echo "APP_KEY=" >> .env && \
    echo "APP_DEBUG=false" >> .env && \
    echo "APP_URL=http://localhost" >> .env && \
    echo "LOG_CHANNEL=stack" >> .env && \
    echo "LOG_DEPRECATIONS_CHANNEL=null" >> .env && \
    echo "LOG_LEVEL=error" >> .env && \
    echo "DB_CONNECTION=sqlite" >> .env && \
    echo "DB_DATABASE=/var/www/html/database/database.sqlite" >> .env && \
    echo "BROADCAST_DRIVER=log" >> .env && \
    echo "CACHE_DRIVER=file" >> .env && \
    echo "FILESYSTEM_DISK=local" >> .env && \
    echo "QUEUE_CONNECTION=sync" >> .env && \
    echo "SESSION_DRIVER=file" >> .env && \
    echo "SESSION_LIFETIME=120" >> .env && \
    echo "MEMCACHED_HOST=127.0.0.1" >> .env && \
    echo "REDIS_HOST=127.0.0.1" >> .env && \
    echo "REDIS_PASSWORD=null" >> .env && \
    echo "REDIS_PORT=6379" >> .env && \
    echo "MAIL_MAILER=smtp" >> .env && \
    echo "MAIL_HOST=mailpit" >> .env && \
    echo "MAIL_PORT=1025" >> .env && \
    echo "MAIL_USERNAME=null" >> .env && \
    echo "MAIL_PASSWORD=null" >> .env && \
    echo "MAIL_ENCRYPTION=null" >> .env && \
    echo "MAIL_FROM_ADDRESS=\"hello@example.com\"" >> .env && \
    echo "MAIL_FROM_NAME=\"\${APP_NAME}\"" >> .env && \
    echo "AWS_ACCESS_KEY_ID=" >> .env && \
    echo "AWS_SECRET_ACCESS_KEY=" >> .env && \
    echo "AWS_DEFAULT_REGION=us-east-1" >> .env && \
    echo "AWS_BUCKET=" >> .env && \
    echo "AWS_USE_PATH_STYLE_ENDPOINT=false" >> .env && \
    echo "PUSHER_APP_ID=" >> .env && \
    echo "PUSHER_APP_KEY=" >> .env && \
    echo "PUSHER_APP_SECRET=" >> .env && \
    echo "PUSHER_HOST=" >> .env && \
    echo "PUSHER_PORT=443" >> .env && \
    echo "PUSHER_SCHEME=https" >> .env && \
    echo "PUSHER_APP_CLUSTER=mt1" >> .env && \
    echo "VITE_PUSHER_APP_KEY=\"\${PUSHER_APP_KEY}\"" >> .env && \
    echo "VITE_PUSHER_HOST=\"\${PUSHER_HOST}\"" >> .env && \
    echo "VITE_PUSHER_PORT=\"\${PUSHER_PORT}\"" >> .env && \
    echo "VITE_PUSHER_SCHEME=\"\${PUSHER_SCHEME}\"" >> .env && \
    echo "VITE_PUSHER_APP_CLUSTER=\"\${PUSHER_APP_CLUSTER}\"" >> .env; \
    fi

# Create database directory and file for SQLite
RUN mkdir -p database && touch database/database.sqlite

# Set correct permissions (important for storage & cache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache database \
    && chmod 664 database/database.sqlite

# Generate application key if not set
RUN php artisan key:generate --force

# Run Laravel optimization commands
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port
EXPOSE 8000

# Health check for container monitoring
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8000 || exit 1

# Run all necessary Laravel commands before starting the server
CMD php artisan migrate --force && \
    php artisan db:seed --force && \
    php artisan storage:link --force && \
    php artisan optimize && \
    php artisan serve --host=0.0.0.0 --port=8000
