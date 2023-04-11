FROM kalilinux/kali-rolling
EXPOSE 80

RUN apt-get update
COPY create_users.sh create_users.sh
RUN chmod a+x create_users.sh
RUN ./create_users.sh
CMD service ssh start
