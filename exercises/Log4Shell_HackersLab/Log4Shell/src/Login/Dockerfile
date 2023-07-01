FROM openjdk:8u181-jdk-alpine
WORKDIR /root
COPY . /root
COPY dependencies/ /root/dependencies
RUN javac -cp "/root/dependencies/*" Login.java
CMD ["java", "-cp", "/root/dependencies/*:/root", "Login"]