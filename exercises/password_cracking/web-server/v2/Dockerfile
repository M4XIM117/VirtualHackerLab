FROM kalilinux/kali-rolling
EXPOSE 22

RUN apt-get update && apt-get install -y \
  netcat-openbsd \
  openssh-server 

COPY passwords.txt /usr/share/wordlists/passwords.txt
COPY create_users.sh create_users.sh
# RUN chmod a+x create_users.sh
# CMD ./create_users.sh
