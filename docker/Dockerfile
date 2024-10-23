FROM ubuntu:22.04

RUN apt-get update && \
    apt-get install -y software-properties-common && \
    rm -rf /var/lib/apt/lists/*
RUN add-apt-repository -y ppa:ondrej/php

RUN DEBIAN_FRONTEND=noninteractive TZ=Etc/UTC \
    apt-get install -y \
    curl \
    php8.3 \
    php8.3-fpm \
    php8.3-xml \
    supervisor \
    make

# install caddy
RUN apt install -y debian-keyring debian-archive-keyring apt-transport-https && \
    curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg && \
    curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | tee /etc/apt/sources.list.d/caddy-stable.list && \
    apt update && \
    apt install caddy

COPY docker/Caddyfile /etc/caddy/Caddyfile

COPY docker/php-fpm.conf /etc/php/8.3/fpm/pool.d/www.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY ./ /var/www/app

### BACKEND
# install composer
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php && \
    php /tmp/composer-setup.php --install-dir=/usr/bin --filename=composer && \
    rm /tmp/composer-setup.php

# composer install
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --optimize-autoloader --no-dev --no-interaction --no-progress --working-dir=/var/www/app/app

# laravel directories
RUN touch /var/www/app/app/storage/logs/laravel.log
RUN chmod -R 777 /var/www/app/app/storage /var/www/app/app/bootstrap/cache

EXPOSE 5050

CMD ["/usr/bin/supervisord"]