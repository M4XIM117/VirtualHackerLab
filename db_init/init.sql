DROP DATABASE IF EXISTS jahresprojekt;
CREATE DATABASE jahresprojekt;

USE jahresprojekt;

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  hashedPassword VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (username)
);
