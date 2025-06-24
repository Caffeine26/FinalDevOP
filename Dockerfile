FROM php:8.2-fpm

# Install base tools and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev nginx nodejs npm sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo_mysql zip pdo pdo_sqlite \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
COPY . .

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 80

CMD ["php-fpm"]
