# Use an official PHP image as the base image
FROM php:7.4-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Install required extensions and utilities
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        zlib1g-dev \
        unzip \
    && docker-php-ext-install zip pdo_mysql \
    && a2enmod rewrite \
    && service apache2 restart

# Copy composer.json and composer.lock to the working directory
COPY composer.json composer.lock /var/www/html/

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-plugins --no-scripts --no-interaction

# Copy the rest of the application files to the working directory
COPY . /var/www/html/

# Expose port 80 for Apache
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
