FROM php:8.3-apache
 
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
 
# install dependencies
RUN apt-get update \
    && apt-get install -y \
        git \
        zip \
    && rm -rf /var/lib/apt/lists/*
 
# install php extensions
RUN docker-php-ext-install pdo pdo_mysql pcntl
 
# install composer
RUN curl https://getcomposer.org/installer > composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php
 
# configure apache
RUN a2enmod rewrite