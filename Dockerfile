FROM php:apache
WORKDIR /var/www/html
EXPOSE 8080 6060

COPY ./www/ src

RUN apt-get update && apt-get install -y \
  nodejs \
  npm \
  docker.io \
  docker-compose 

# Install mysqli
RUN docker-php-ext-install mysqli exif

# User anlegen für Terminal
RUN useradd -u 1000 -g docker -m -s /bin/bash student 

# Versuche rüberkopieren
COPY ./exercises/ /home/student/
WORKDIR /var/www/html/src/js/
RUN npm install

COPY startup.sh /usr/local/bin/startup.sh
RUN chmod +x /usr/local/bin/startup.sh
# execute startup script
# ENTRYPOINT ["/usr/local/bin/startup.sh"]
