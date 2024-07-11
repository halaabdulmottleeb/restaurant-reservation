FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        unzip \
        libonig-dev \
        nginx \
        npm \
        libgd-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo pdo_mysql zip gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --no-scripts --no-autoloader \
    && composer dump-autoload --no-scripts --optimize

COPY .env.example .env

RUN chown -R www-data:www-data /var/www

EXPOSE 8080

CMD service nginx start && php-fpm -F
