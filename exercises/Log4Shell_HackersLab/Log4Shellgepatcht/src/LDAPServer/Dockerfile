FROM openjdk:8u181-jdk-alpine
EXPOSE 1390
WORKDIR /root
COPY . /root
COPY dependencies/ /root/dependencies
RUN javac -cp "/root/dependencies/*" LDAPServer.java
CMD ["java", "-cp", "/root/dependencies/*:/root", "LDAPServer"]