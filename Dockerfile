FROM php:8.3.13-cli-alpine as local

ENV TZ=UTC

ARG APP_USER_ID=1000
ARG APP_USER_NAME=local
RUN adduser -D -u ${APP_USER_ID} ${APP_USER_NAME}

RUN apk update && apk add $PHPIZE_DEPS bash \
    unzip librdkafka tzdata \
    && rm -rf /var/cache/apk/*

ARG COMPOSER_VERSION=2.8.5
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

RUN pecl config-set php_ini /usr/local/etc/php/conf.d/over.ini

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin
RUN set -eux; \
    install-php-extensions zip pcntl intl bcmath pdo pdo_pgsql rdkafka ds sockets \
    && rm -rf /tmp/*

USER ${APP_USER_NAME}
WORKDIR "/app"
