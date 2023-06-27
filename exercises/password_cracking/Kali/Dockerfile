FROM kalilinux/kali-rolling

# Kali keyrings
RUN wget http://http.kali.org/kali/pool/main/k/kali-archive-keyring/kali-archive-keyring_2022.1_all.deb
RUN dpkg -i kali-archive-keyring_2022.1_all.deb

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
  nmap \
  iproute2

COPY sqli_post_request ./sqli_post_request
COPY passwords.txt ./passwords.txt
COPY users.txt ./users.txt

RUN echo "root:root" | chpasswd