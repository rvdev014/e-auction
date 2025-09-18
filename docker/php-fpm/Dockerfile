FROM php:8.1-fpm

COPY ./conf.d /usr/local/etc/php/conf.d

RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    libpq-dev \
    libicu-dev \
    zlib1g-dev \
    libpng-dev \
    libzip-dev \
    libkrb5-dev \
    zip && \
    rm -rf /var/lib/apt/lists/*

#RUN apt-get update; \
#    apt-get install -y libmagickwand-dev; \
#    pecl install imagick; \
#    docker-php-ext-enable imagick;

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pgsql pdo_pgsql && \
    docker-php-ext-configure intl && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install zip && \
    docker-php-ext-install gd

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer && \
    rm -rf /root/.composer/cache

WORKDIR /app

RUN chmod -R 777 /app
