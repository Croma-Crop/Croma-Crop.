FROM php:8.2-apache
COPY web/php.ini /usr/local/etc/php/conf.d/croma.ini
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
COPY Cromapagina/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
