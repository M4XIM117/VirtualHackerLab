FROM ubuntu:latest
EXPOSE 22

RUN apt-get update && apt-get install -y \
  netcat-openbsd \
  openssh-server \
  sudo

RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config
COPY passwords.txt /usr/share/wordlists/passwords.txt
COPY create_users.sh create_users.sh
RUN serice ssh start
# RUN chmod a+x create_users.sh
# CMD ./create_users.sh
