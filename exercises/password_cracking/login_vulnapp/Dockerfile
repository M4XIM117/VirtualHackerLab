FROM php:8.0.11-apache
COPY www/html /var/www/html
EXPOSE 80 22

RUN apt-get update && apt-get install -y \
    mariadb-server \
    nano 

RUN docker-php-ext-install pdo pdo_mysql exif

COPY config/apache2.conf /etc/apache2/

CMD apachectl -D FOREGROUND