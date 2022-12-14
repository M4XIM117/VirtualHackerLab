# Versioning, current latest
FROM registry.gitlab.com/kalilinux/build-scripts/kali-docker/kali-rolling:2021.10.25

RUN apt-get update && apt-get install -y \
  john \
  nano \
  netcat-openbsd \
  openssh-server \
  python-is-python3 \
  wget \
  wordlists --reinstall

RUN cd /home && wget https://raw.githubusercontent.com/openwall/john/bleeding-jumbo/run/ssh2john.py

# Unzip rockyou.txt.gz
RUN gunzip /usr/share/wordlists/rockyou.txt.gz

# Set password for root user
RUN echo "root:root" | chpasswd