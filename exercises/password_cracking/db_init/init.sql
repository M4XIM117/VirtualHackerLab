CREATE DATABASE users;

USE users;

CREATE TABLE user (
  id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  password_hash CHAR(64) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (username)
);


INSERT INTO users.user(id, username, password_hash)
VALUES
    (1, 'maxim', SHA2('Winter2017', 256)),
    (2, 'cem', SHA2('Welcome123', 256)),
    (3, 'bilal', SHA2('P@ssw0rd', 256)),
    (4, 'nicole', SHA2('networking', 256));
    