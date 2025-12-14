FROM alpine:3.9

RUN apk update && apk add --no-cache \
    apache2 \
    curl \
    supervisor \
    php7-apache2 \
    php7-intl \
    php7-openssl \
    php7-pecl-redis \
    php7-sqlite3 \
    php7-pdo_mysql \
    php7-mbstring \
    php7-json \
    php7-curl \
    php7-mysqli \
    mysql-client \
    apache2-ssl

RUN rm -rf /tmp/* /var/cache/apk/*

ADD start.sh /tmp/start.sh
ADD supervisord.conf /tmp/supervisord.conf
ADD httpd.conf /etc/apache2/httpd.conf
ADD php.ini /etc/php7/php.ini

RUN chmod +x /tmp/start.sh

EXPOSE 80

COPY html /var/www/localhost/htdocs

ENTRYPOINT ["sh", "/tmp/start.sh"]
