FROM kalilinux/kali-rolling
EXPOSE 80 22

RUN apt-get update && apt-get install -y \
    openssh-server
COPY create_users.sh create_users.sh
RUN chmod a+x create_users.sh
RUN ./create_users.sh
