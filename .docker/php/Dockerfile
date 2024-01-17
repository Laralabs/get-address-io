ARG PHP_IMAGE="php:8.1"
FROM $PHP_IMAGE
ARG PHP_IMAGE

RUN apt-get update

RUN apt autoremove -y
RUN apt-get install libicu-dev zip -y --no-install-recommends
RUN apt-get install libmcrypt-dev -y --no-install-recommends
RUN apt-get install git unzip -y
RUN docker-php-ext-install mysqli pdo_mysql bcmath

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get install zlib1g-dev libzip-dev -y --no-install-recommends
RUN docker-php-ext-install zip

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

ENV XDEBUG_MODE=coverage

RUN rm -rf /var/lib/apt/lists/*
