FROM httpd
COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install -y \
  nodejs \
  npm \
  docker.io

# Ordner anlegen für die Versuche
RUN mkdir /home/student
# Versuche rüberkopieren
COPY ./exercises/ /home/student/


RUN npm install /usr/local/apache2/htdocs/js/
EXPOSE 8080 6060


