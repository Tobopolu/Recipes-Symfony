# Distro Name : php 8.2 fpm-alpine (76 MB)
FROM php:8.2-fpm-alpine

# Apk install
RUN apk update
RUN apk add bash icu-dev git
# RUN apk add bash icu-dev git zip libzip-dev

# Php install
RUN docker-php-ext-install intl opcache pdo pdo_mysql

# Php config
RUN docker-php-ext-configure intl
# RUN docker-php-ext-configure zip

# Pecl install
RUN pecl install apcu

# Php ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Php enable
RUN docker-php-ext-enable apcu
RUN docker-php-ext-enable opcache

# Set Work directory
WORKDIR /var/www/html

# Php install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# Wget install Symfony-CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Git global config
RUN git config --global init.defaultBranch main
RUN git config --global --add safe.directory /var/www/html
RUN git config --global user.email "your@mail.com"
RUN git config --global user.name "your_username"
