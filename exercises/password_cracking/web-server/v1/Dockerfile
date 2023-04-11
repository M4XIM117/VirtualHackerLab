FROM php:8.0.11-apache
COPY www/html /var/www/html
EXPOSE 80 22

RUN apt-get update && apt-get install -y \
    mariadb-server \
    nano \
    openssh-server

RUN docker-php-ext-install pdo pdo_mysql exif
RUN docker-php-ext-enable exif

# Set Alice as SSH user
# Allows root user to login via SSH
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config
RUN adduser --home /home/alice --shell /bin/bash alice
RUN echo "alice:bluebirds" | chpasswd
RUN cd /home/alice && mkdir .ssh
# Copy public/private keys with rsh encryption and 'bluebirds' as passphrase
COPY .ssh /home/alice/.ssh
RUN chown -R alice:alice /home/alice/.ssh
RUN chmod 604 /home/alice/.ssh/id_rsa

# Add web directory to maintainence group for administration
RUN groupadd maintainance
RUN chgrp -R maintainance /var/www/html
RUN chown -R alice /var/www/html
RUN chown -R www-data /var/www/html/public/uploads/images
RUN find /var/www/html -type d -exec chmod 2775 {} +
RUN find /var/www/html -type f -exec chmod 0674 {} +
RUN echo "umask 0002" >> ~/.bashrc

RUN usermod -aG maintainance alice

COPY config/apache2.conf /etc/apache2/

CMD service ssh start && apachectl -D FOREGROUND