FROM ubuntu:latest
EXPOSE 22

RUN apt update && apt install \
  openssh-server \
  sudo -y

COPY ../passwords.txt /usr/share/wordlists/passwords.txt
COPY create_users.sh create_users.sh
RUN chmod a+x create_users.sh
RUN ./create_users.sh

# Start SSH service after creating /run/sshd directory (Directory can't automatically be created during build)
RUN mkdir /run/sshd
CMD ["/usr/sbin/sshd", "-D"]