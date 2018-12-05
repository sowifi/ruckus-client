FROM php:7.2-fpm

# Composer install.
RUN if [ ! -f /usr/bin/composer ]; then curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer; fi

# Install server dependencies.
RUN apt-get update
RUN apt-get install -y git zip unzip curl nano net-tools zlib1g-dev mysql-client
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Copy source (see also .dockerignore)
COPY ./ /code
WORKDIR /code

# Install composer dependencies
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --optimize-autoloader --no-dev

# Easy cli debugging with XDebug
RUN echo "export PHP_IDE_CONFIG=\"serverName=ruckus-client\"" >> ~/.bashrc
