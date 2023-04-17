FROM kalilinux/kali-rolling

RUN apt-get update && apt-get install -y \
  nano \
# Hydra ist a brute-force password cracking tool
  hydra \ 
# snapd used  to install sqlmap
  snapd \
# Hashcat is used to brute-force Hashed Passwords 
  hashcat \
# SQL Map scans forms etc. for possible SQL-Injections and retrieves Data if possible
  sqlmap \
# NMap is used for network discovery
  iproute2

COPY sqli_post_request ./sqli_post_request
COPY passwords.txt ./passwords.txt

RUN echo "root:root" | chpasswd