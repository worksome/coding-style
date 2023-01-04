FROM php:8.2-cli-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
