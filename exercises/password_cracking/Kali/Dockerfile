FROM kalilinux/kali-rolling

RUN apt-get update && apt-get install -y \
  nano \
  openssh-server 

RUN echo "root:root" | chpasswd