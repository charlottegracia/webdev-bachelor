# Use an official PHP image as a parent image
FROM php:8.2-fpm

# Install system dependencies (for running Laravel, MySQL client)
RUN apt-get update && apt-get install -y \
    git \
    default-mysql-client # MySQL client

# Install PHP extensions for Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory in the container
WORKDIR /var/www

# Copy composer.json and composer.lock to install dependencies
COPY composer.json composer.lock ./

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the rest of the application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

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
