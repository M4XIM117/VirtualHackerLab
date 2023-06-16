FROM httpd
COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install -y \
    mariadb-server \
    nano 

RUN docker-php-ext-install mysqli exif

COPY config/apache2.conf /etc/apache2/

CMD apachectl -D FOREGROUND
# User anlegen für Terminal
#RUN useradd -u 1000 -g docker -m -s /bin/bash student 

# Versuche rüberkopieren
#COPY ./exercises/ /home/student/


#RUN npm install /usr/local/apache2/htdocs/js/
EXPOSE 8080 6060


