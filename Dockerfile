FROM httpd
COPY ./www/ /usr/local/apache2/htdocs/

RUN apt-get update && apt-get install \
  nodejs

EXPOSE 8080