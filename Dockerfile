FROM php:7.2-apache
RUN apt-get update && apt-get install curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
