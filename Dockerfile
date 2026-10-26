FROM serversideup/php:8.5-fpm-nginx-alpine AS npm

USER root

RUN apk add --update nodejs npm

USER www-data

COPY --chown=www-data:www-data . /var/www/html/

RUN npm install
RUN npm run build

FROM serversideup/php:8.5-fpm-nginx-alpine AS composer

COPY --chown=www-data:www-data . /var/www/html/

RUN composer install --no-dev --optimize-autoloader

FROM serversideup/php:8.5-fpm-nginx-alpine

LABEL org.opencontainers.image.description="Docker image for Librepolls, based on the serversideup fpm-nginx-alpine image."
LABEL org.opencontainers.image.source=https://github.com/danielhn/librepolls

COPY --from=composer /var/www/html/ /var/www/html/
COPY --from=npm /var/www/html/public/build/ /var/www/html/public/build/

COPY .env.example .env

COPY --chmod=755 docker-entrypoint.sh /etc/entrypoint.d/99-docker-entrypoint.sh
