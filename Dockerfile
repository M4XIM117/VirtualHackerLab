FROM php:8.2-apache
WORKDIR /var/www/html

COPY ./www/ src

RUN apt-get update && apt-get install -y \
  nodejs \
  npm \
  docker.io \
  docker-compose 

# User anlegen für Terminal
RUN useradd -u 1000 -g docker -m -s /bin/bash student 

# Versuche rüberkopieren
COPY ./exercises/ /home/student/

#RUN npm install /var/www/html/src/js/

EXPOSE 8080 6060

#Start Socket
#CMD ["node", "./src/js/backend.js"]
