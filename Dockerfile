FROM httpd
EXPOSE 8080 6060

COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install -y \
  nodejs \
  npm \
  docker.io \
  docker-compose \
  php \
  libapache2-mod-php

# User anlegen für Terminal
RUN useradd -u 1000 -g docker -m -s /bin/bash student 

# Versuche rüberkopieren
COPY ./exercises/ /home/student/

RUN npm install /usr/local/apache2/htdocs/js/

# PHP Modul zu Apache config hinzufügen und neustarten
RUN echo "LoadModule php_module modules/libphp.so" >> /usr/local/apache2/conf/httpd.conf
RUN httpd -k restart


