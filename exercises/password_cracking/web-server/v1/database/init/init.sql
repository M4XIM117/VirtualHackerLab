DROP DATABASE IF EXISTS messenger;
CREATE DATABASE messenger;

create table messenger.meta_data_users
(
    id              int             auto_increment
        primary key,
    username        varchar(255)          not null,
    pwhash   Binary(64) not null
);


INSERT INTO messenger.meta_data_users (username, pw)
VALUES
    ("maxim", "test");

