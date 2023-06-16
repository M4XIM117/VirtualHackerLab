FROM mysql:latest

ENV MYSQL_DATABASE=vhl \
    MYSQL_ROOT_PASSWORD=root

ADD init.sql /docker-entrypoint-initdb.d/

EXPOSE 3306