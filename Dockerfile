FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY composer.json composer.lock* ./

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --no-scripts --no-autoloader --prefer-dist \
    || true

COPY . .

RUN composer dump-autoload --optimize --no-dev

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/writable

COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["apache2-foreground"]
