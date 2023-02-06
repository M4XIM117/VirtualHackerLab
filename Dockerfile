FROM nginx
COPY www /usr/share/nginx/html

EXPOSE 8080:8080