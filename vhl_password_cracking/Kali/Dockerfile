FROM kalilinux/kali-rolling

RUN apt update && apt upgrade -y
RUN DEBIAN_FRONTEND='noninteractive' apt install -y \
  --no-install-recommends \
  kali-linux-headless httpie iputils-ping && apt-get clean