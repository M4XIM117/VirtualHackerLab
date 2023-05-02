FROM httpd
COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install -y \
  nodejs \
  npm

RUN npm install /usr/local/apache2/htdocs/js/
EXPOSE 8080