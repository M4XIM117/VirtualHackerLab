FROM httpd
COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install -y \
  nodejs \
  npm \
  docker.io

# User anlegen für Terminal
RUN useradd -u 1000 -g 1000 -G docker -m -s /bin/bash student

# Ordner anlegen für die Versuche
RUN mkdir /home/student
# Versuche rüberkopieren
COPY ./exercises/ /home/student/


RUN npm install /usr/local/apache2/htdocs/js/
EXPOSE 8080 6060


