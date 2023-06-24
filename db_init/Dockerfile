FROM mysql:latest

ENV MYSQL_DATABASE=users \
    MYSQL_ROOT_PASSWORD=root

ADD init.sql /docker-entrypoint-initdb.d/

EXPOSE 1201