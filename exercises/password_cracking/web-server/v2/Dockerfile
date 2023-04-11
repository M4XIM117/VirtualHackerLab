FROM kalilinux/kali-rolling

RUN apt-get update && apt-get install -y \
  netcat-openbsd \
  openssh-server \
  wordlists --reinstall

RUN gunzip /usr/share/wordlists/rockyou.txt.gz

COPY create_users.sh create_users.sh
# RUN chmod a+x create_users.sh
# CMD ./create_users.sh
