FROM php:8.3.13-cli-alpine as local

RUN apk update && apk add $PHPIZE_DEPS bash \
    && rm -rf /var/cache/apk/*

ARG COMPOSER_VERSION=2.8.5
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

RUN pecl config-set php_ini /usr/local/etc/php/conf.d/over.ini \
    && pecl install openswoole-22.1.2 redis \
    && docker-php-ext-enable openswoole redis \
    && rm -rf /tmp/*

ARG APP_USER_ID=1000
ARG APP_USER_NAME=local
RUN adduser -D -u ${APP_USER_ID} ${APP_USER_NAME}

USER ${APP_USER_NAME}
WORKDIR "/app"
