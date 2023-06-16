FROM httpd
COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install -y php libapache2-mod-php
#RUN apt-get update && apt-get install -y \
  #nodejs \
  #npm \
  #docker.io \
  #docker-compose

RUN echo "AddType application/x-httpd-php .php" >> /usr/local/apache2/conf/httpd.conf
# User anlegen für Terminal
#RUN useradd -u 1000 -g docker -m -s /bin/bash student 

# Versuche rüberkopieren
#COPY ./exercises/ /home/student/


#RUN npm install /usr/local/apache2/htdocs/js/
EXPOSE 8080 6060


