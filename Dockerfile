# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY enrollment/ .

# Copy the SSL certificate
RUN mkdir -p /var/www/html/storage/certs
COPY enrollment/storage/certs/tidb-ca.pem /var/www/html/storage/certs/tidb-ca.pem

# Install PHP dependencies (without running artisan commands that need DB)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Create all required storage directories
RUN mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/framework/cache/data \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache

# Set permissions (777 for session storage to ensure writes work)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/storage \
    && chmod -R 777 /var/www/html/bootstrap/cache

# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Create a startup script
RUN echo '#!/bin/bash\n\
# Ensure storage directories exist and are writable\n\
mkdir -p /var/www/html/storage/framework/sessions\n\
mkdir -p /var/www/html/storage/framework/views\n\
mkdir -p /var/www/html/storage/framework/cache/data\n\
chmod -R 777 /var/www/html/storage\n\
chmod -R 777 /var/www/html/bootstrap/cache\n\
# Clear caches\n\
php artisan config:clear\n\
php artisan cache:clear\n\
php artisan view:clear\n\
# Start Apache\n\
apache2-foreground' > /var/www/html/start.sh && chmod +x /var/www/html/start.sh

# Expose port 80
EXPOSE 80

# Start with our script
CMD ["/var/www/html/start.sh"]
