FROM php:apache-bullseye

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN apt-get update &&\
    apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
    rm -rf /var/lib/apt/lists/*

RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -

ENV PATH /usr/local/go/bin:$PATH

RUN go get github.com/mailhog/mhsendmail

RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail

RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf

RUN docker-php-ext-install pdo_mysql

RUN a2enmod rewrite