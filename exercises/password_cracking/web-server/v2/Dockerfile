FROM ubuntu:latest
EXPOSE 22

RUN apt update && apt install \
  openssh-server \
  sudo -y

COPY passwords.txt /usr/share/wordlists/passwords.txt
COPY create_users.sh create_users.sh
RUN chmod a+x create_users.sh
RUN ./create_users.sh
