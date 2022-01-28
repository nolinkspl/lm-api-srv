FROM php:7.3-fpm-alpine3.13
ENV TZ=Europe/Moscow

RUN apk update && apk upgrade && \
    apk add --no-cache $PHPIZE_DEPS composer supervisor

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

COPY ./supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html/company-service

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
