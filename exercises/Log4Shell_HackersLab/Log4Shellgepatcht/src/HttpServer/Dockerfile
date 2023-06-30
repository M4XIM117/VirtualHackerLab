FROM openjdk:8u181-jdk-alpine
EXPOSE 8080
WORKDIR /root
COPY . /root
RUN javac HttpServer.java
CMD ["java", "HttpServer"]