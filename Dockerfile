# syntax=docker/dockerfile:1

# Use the PHP Apache image as the base image
FROM php:8.2.0-apache

# Install required dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

# Configure and install GD extension
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Install additional PHP extensions (Redis and Xdebug)
RUN pecl install redis-5.3.7 \
    && pecl install xdebug-3.2.1 \
    && docker-php-ext-enable redis xdebug

# Set production configuration for PHP runtime arguments
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install other required packages without npm
RUN apt-get install -y \
    curl

# Copy application files to the web server directory
COPY ./backend /var/www/html

# Set permissions for storage directory
RUN addgroup webmaster \
    && adduser --disabled-password --gecos '' admin \
    && adduser admin webmaster

# Create necessary directories and set permissions
RUN mkdir -p /var/www/html/node_modules /var/www/html/storage /var/www/html/public \
    && find /var/www/html/ -type f -exec chmod 664 {} \; \
    && find /var/www/html/ -type d -exec chmod 775 {} \; \
    && find /var/www/html/ -type f -exec chmod g+s {} \; \
    && chown -R admin:webmaster /var/www/html/ \
    && chmod -R u+x /var/www/html/node_modules/ \
    && chmod -R ugo+rw /var/www/html/storage/ \
    && chmod -R ugo+rw /var/www/html/public/

# Switch to a non-privileged user for running the application
USER admin

# Install Composer
RUN composer install