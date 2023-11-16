FROM php:8.2.4-apache

WORKDIR /var/www/html

COPY . /var/www/html/

RUN apt-get update -y
RUN apt-get install -y nano curl gcc
RUN apt-get install -y libpq-dev libonig-dev libzip-dev libxml2-dev libcurl4-openssl-dev
RUN docker-php-ext-install curl
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_pgsql
RUN apt-get update -y

RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

ADD 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
