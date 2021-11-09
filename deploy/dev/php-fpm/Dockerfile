FROM php:8.0-fpm

COPY wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it

RUN apt-get update && \
    docker-php-ext-install pdo_mysql && \
    apt-get install -y libmemcached-dev zlib1g-dev && \
    pecl install memcached-3.1.5 && \
    docker-php-ext-enable memcached && \
    apt-get install -y libzip-dev zip && \
    docker-php-ext-install zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer install; \
    wait-for-it mysql:3307 -- bin/console doctrine:migrations:migrate; \
    bin/console currency-rate:fake; php-fpm

EXPOSE 9000