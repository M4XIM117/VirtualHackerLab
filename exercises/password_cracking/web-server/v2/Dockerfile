FROM ubuntu:latest

RUN apt update && apt install \
  netcat-openbsd \
  openssh-server \
  sudo -y

RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config
COPY passwords.txt /usr/share/wordlists/passwords.txt
COPY create_users.sh create_users.sh


CMD service ssh start
EXPOSE 22
# RUN chmod a+x create_users.sh
# CMD ./create_users.sh
