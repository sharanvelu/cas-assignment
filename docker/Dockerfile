FROM php:8.2.1-fpm

RUN apt-get update && \
    apt-get install -y \
        git \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libldap2-dev \
        libgmp-dev \
        libmcrypt-dev \
        libonig-dev \
        libpng-dev \
        libpq-dev \
        libwebp-dev \
        libzip-dev \
        nginx  \
        procps \
        vim \
        yarn \
        zip \
        zlib1g-dev

RUN docker-php-ext-configure gd --with-freetype --with-webp  --with-jpeg
RUN docker-php-ext-configure intl

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install exif
RUN docker-php-ext-install gd
RUN docker-php-ext-install gmp
RUN docker-php-ext-install intl
RUN docker-php-ext-install ldap
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install sysvmsg
RUN docker-php-ext-install zip

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer --version=2.1.3

# Node and NPM
RUN curl -fsSL https://raw.githubusercontent.com/sharanvelu/dockr-extras/master/node-npm-install.sh | bash

# PHP Memory Limit conf
COPY docker/php/mem-limit.ini /usr/local/etc/php/conf.d/dockr-mem-limit.ini

WORKDIR /var/www/html

RUN mkdir /var/www/html/public

COPY docker/nginx.conf /etc/nginx/nginx.conf

COPY docker/entrypoint.sh /usr/bin/entrypoint.sh
RUN chmod +x /usr/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

COPY . /var/www/html

RUN composer install --ignore-platform-reqs
RUN npm install
RUN npm run build

CMD ["php-fpm"]

RUN rm -rf /var/www/html/public \
    && apt-get clean
