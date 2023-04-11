FROM kalilinux/kali-rolling

RUN apt-get update && apt-get install -y \
  nano \
  netcat-openbsd \
  openssh-server \
  wordlists --reinstall \
  kali-tools-passwords \
  kali-tools-vulnerability

RUN gunzip /usr/share/wordlists/rockyou.txt.gz

RUN echo "root:root" | chpasswd