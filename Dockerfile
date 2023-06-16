FROM httpd

# Copy your PHP files to the Apache default directory
COPY ./www/ /usr/local/apache2/htdocs/

# Install PHP and necessary extensions
RUN apt-get update && \
    apt-get install -y php libapache2-mod-php php-mysql

# Modify the Apache configuration to handle PHP files
RUN echo "AddType application/x-httpd-php .php" >> /usr/local/apache2/conf/httpd.conf

EXPOSE 8080 6060
#RUN apt-get update && apt-get install -y \
  #nodejs \
  #npm \
  #docker.io \
  #docker-compose
# User anlegen für Terminal
#RUN useradd -u 1000 -g docker -m -s /bin/bash student 

# Versuche rüberkopieren
#COPY ./exercises/ /home/student/


#RUN npm install /usr/local/apache2/htdocs/js/

