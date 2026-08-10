FROM php:8.2-apache

RUN apt-get update && apt-get install -y libicu-dev libpq-dev libzip-dev unzip \
    && docker-php-ext-install intl pdo_pgsql pgsql zip \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer update --no-dev --prefer-dist --no-interaction --no-progress

RUN composer dump-autoload --optimize --no-dev

RUN printf '%s\n' '<VirtualHost *:80>' '    DocumentRoot /var/www/html/public' '' '    <Directory /var/www/html/public>' '        AllowOverride All' '        Require all granted' '    </Directory>' '' '    ErrorLog ${APACHE_LOG_DIR}/error.log' '    CustomLog ${APACHE_LOG_DIR}/access.log combined' '</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/html/writable/{cache,logs,session,uploads} \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/writable

ENV PGSSLMODE=prefer

EXPOSE 80

CMD ["apache2-foreground"]
