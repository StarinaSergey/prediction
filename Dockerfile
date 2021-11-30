FROM php:7.4-fpm-alpine AS php

# persistent / runtime deps
RUN apk add --no-cache \
		acl \
		file \
		gettext \
		git \
		mysql-client \
		rabbitmq-c-dev \
        libssh-dev \
	;

ARG APCU_VERSION=5.1.18
RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		coreutils \
		freetype-dev \
		icu-dev \
		libjpeg-turbo-dev \
		libpng-dev \
		libtool \
		libwebp-dev \
		libzip-dev \
		mysql-dev \
		zlib-dev \
	; \
	\
	docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-webp=/usr/include --with-freetype=/usr/include/; \
	docker-php-ext-configure zip; \
	docker-php-ext-install -j$(nproc) \
		exif \
		gd \
		intl \
		pdo_mysql \
		zip \
	; \
	pecl install \
		apcu-${APCU_VERSION} \
		amqp \
		redis \
	; \
	pecl clear-cache; \
	docker-php-ext-enable \
		apcu \
		opcache \
		amqp \
		redis \
	; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .phpexts-rundeps $runDeps; \
	\
	apk del .build-deps

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#COPY docker/php/php.ini /usr/local/etc/php/php.ini
#COPY docker/php/php-cli.ini /usr/local/etc/php/php-cli.ini

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
#ENV COMPOSER_ALLOW_SUPERUSER=1
#RUN set -eux; \
#	composer global require "hirak/prestissimo:^0.3" --prefer-dist --no-progress --no-suggest --classmap-authoritative; \
#	composer clear-cache
#ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /application

# build for production
#ARG APP_ENV=prod

# prevent the reinstallation of vendors at every changes in the source code
COPY composer.json composer.lock ./
RUN set -eux; \
	composer install --prefer-dist --no-autoloader --no-scripts --no-progress --no-suggest; \
	composer clear-cache

# copy only specifically what we need
COPY .env ./
COPY app app/
COPY bootstrap bootstrap/
COPY config config/
COPY database database/
COPY public public/
COPY resources resources/
COPY routes routes/
COPY storage storage/

RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative; \
#	APP_SECRET='' composer run-script post-install-cmd; \
#	chmod +x bin/console; sync;
VOLUME /application/var

#VOLUME /application/public/media

#COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
#RUN chmod +x /usr/local/bin/docker-entrypoint

#ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
