# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM php:7.2.26-fpm-buster
ARG TIMEZONE

RUN  apt-get update && apt-get install -y \
    apt-utils \
    openssl \
    git \
    unzip \
    curl \
    wget \
    gnupg

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql \
    && pecl install apcu-5.1.18 \
    && docker-php-ext-enable apcu \
    && docker-php-ext-install opcache

WORKDIR /var/www/symfony

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc \
    && mkdir -p /var/www/symfony/var/cache \
    && mkdir -p /var/www/symfony/var/log \
    && mkdir -p /var/www/symfony/public/uploads \
    && mkdir -p /var/www/.composer \
    && usermod -u 1000 www-data \
    && chown -R www-data:www-data /var/www/symfony/var/cache \
    && chown -R www-data:www-data /var/www/symfony/var/log \
    && chown -R www-data:www-data /var/www/symfony/public/uploads \
    && chown -R www-data:www-data /var/www/.composer
