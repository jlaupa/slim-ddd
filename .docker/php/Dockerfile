FROM php:8.1.3-fpm
RUN apt-get update && apt-get install -y apt-transport-https
RUN apt-get update \
    && apt-get -y install libssl-dev libc-client2007e-dev libkrb5-dev curl git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod 755 /usr/local/bin/composer \
    && docker-php-ext-install -j$(nproc) bcmath
	RUN apt-get install -y \
            libzip-dev \
            zip \
      && docker-php-ext-configure zip \
      && docker-php-ext-install zip

# Install PECL extensions
RUN pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode = debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request = yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host = 1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log_level = 0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && docker-php-ext-enable xdebug

RUN apt-get install -y libxml2-dev
RUN docker-php-ext-install simplexml xmlwriter sockets

WORKDIR /var/www/html