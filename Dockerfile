FROM httpd
EXPOSE 8080 6060

COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install -y \
  nodejs \
  npm \
  docker.io \
  docker-compose \
  lipapache2-mod-php

# User anlegen für Terminal
RUN useradd -u 1000 -g docker -m -s /bin/bash student 

# Versuche rüberkopieren
COPY ./exercises/ /home/student/

RUN npm install /usr/local/apache2/htdocs/js/

# PHP Starten
RUN a2enmod php
RUN service apache2 restart



