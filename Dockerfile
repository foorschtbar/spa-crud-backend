FROM php:7.4-apache

# install packages via apt-get
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
    unzip \
    git \
    ; \
    rm -rf /var/lib/apt/lists/*

# install php extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN set -eux; \
    install-php-extensions \
    opcache \
    pdo_mysql \
    ; \
    rm /usr/local/bin/install-php-extensions

# change apache config
RUN set -eux; \
    a2enmod rewrite; \
    sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

# change php config
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# move to apache root
WORKDIR /var/www/html

# install composer dependencies
COPY composer.json composer.lock ./
COPY --from=composer /usr/bin/composer /usr/local/bin/
RUN set -eux; \
    composer install --no-dev --no-progress

# copy application files
COPY ./code ./
RUN set -eux; \
    composer dump-autoload --classmap-authoritative; \
    rm /usr/local/bin/composer

# additional binaries
ENV PATH="/var/www/html/bin:${PATH}"
RUN chmod +x bin/*

# docker entrypoint
COPY entrypoint.sh /entrypoint.sh
ENTRYPOINT [ "sh", "/entrypoint.sh" ]
CMD ["apache2-foreground"]
