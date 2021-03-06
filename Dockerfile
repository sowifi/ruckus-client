FROM php:7.2-fpm

# Composer install.
RUN if [ ! -f /usr/bin/composer ]; then curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer; fi

# Install server dependencies.
RUN apt-get update
RUN apt-get install -y git curl nano net-tools zip unzip zlib1g-dev
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
RUN docker-php-ext-install zip

# Easy cli debugging with XDebug
RUN echo "export PHP_IDE_CONFIG=\"serverName=ruckus-client\"" >> ~/.bashrc
