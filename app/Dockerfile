FROM php:apache-bullseye

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite