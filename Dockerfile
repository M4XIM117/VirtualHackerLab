FROM httpd
COPY ./www/ /usr/local/apache2/htdocs/

RUN apt update && apt install \
  nodejs

EXPOSE 8080