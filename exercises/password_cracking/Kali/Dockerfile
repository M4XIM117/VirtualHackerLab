FROM kalilinux/kali-rolling

RUN apt-get update && apt-get install -y \
  kali-linux-headless\
  nano \
  netcat-openbsd \
  openssh-server \
  kali-tools-passwords

RUN echo "root:root" | chpasswd