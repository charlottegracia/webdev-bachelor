# Use an official PHP image as a parent image
FROM php:8.2-fpm

# Install system dependencies (e.g., for running Laravel, MySQL client, etc.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    default-mysql-client # Install default MySQL client

# Install PHP extensions for Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Set the working directory in the container
WORKDIR /var/www

# Copy composer.json and composer.lock to install dependencies
COPY composer.json composer.lock ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application files
COPY . .

# Set proper permissions (especially for Laravel storage and cache directories)
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy the entrypoint script into the container
COPY docker-entrypoint.sh /usr/local/bin/

# Make the script executable
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set the entrypoint to our script
ENTRYPOINT ["docker-entrypoint.sh"]

# Expose port 8000 for the Laravel server
EXPOSE 8000

# Start Laravel server, listening on all interfaces (0.0.0.0)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
