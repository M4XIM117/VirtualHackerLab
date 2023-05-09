FROM httpd
COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install -y \
  nodejs \
  npm \
  docker-ce \
  docker-ce-cli \
  containerd.io \
  docker-buildx-plugin \
  docker-compose-plugin

# User anlegen für Terminal
RUN groupadd -g 1000 student \
    && useradd -u 1000 -g 1000 -m -s /bin/bash student

# Ordner anlegen für die Versuche
RUN mkdir /home/student/versuche
RUN chown -R student:student /home/student/versuche
RUN chmod 700 /home/student/versuche
# Versuche rüberkopieren
COPY ./exercises/ /home/student/versuche/


RUN npm install /usr/local/apache2/htdocs/js/
EXPOSE 8080 6060


