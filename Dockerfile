FROM php:apache
WORKDIR /var/www/html
EXPOSE 8080 6060

COPY ./www/ src
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 648ACFD622F3D138 0E98404D386FA1D9 F8D2585B8783D481 6ED0E7B82643E131 54404762BBB6E853 BDE6D2B9216EC7A8

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
ENTRYPOINT ["/usr/local/bin/startup.sh"]
