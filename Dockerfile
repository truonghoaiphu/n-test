FROM php:8.2-fpm-alpine

COPY docker/php/composer-installer.sh /usr/local/bin/composer-installer

RUN apk update && apk add --no-cache \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    bash \
    vim \
    curl \
    git \
    unzip \
    mysql-client \
    oniguruma-dev \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd zip mbstring

RUN chmod +x /usr/local/bin/composer-installer \
&& /usr/local/bin/composer-installer \
&& mv composer.phar /usr/local/bin/composer \
&& chmod +x /usr/local/bin/composer \
&& composer --version

COPY docker/php/php.ini /usr/local/etc/php/

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
