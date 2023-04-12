DROP DATABASE IF EXISTS users;
CREATE DATABASE users;

create table messenger.user
(
    id              int             auto_increment
        primary key,
    full_name        varchar(64)           not null,
    password_hashed      varbinary(8000)       not null
);


INSERT INTO messenger.contacts(id, full_name, password_hashed)
VALUES
    (1, 'maxim', HASHBYTES('SHA2_256', 'Winter2017')),
    (2, 'cem', HASHBYTES('SHA2_256', 'Welcome123')),
    (3, 'bilal', HASHBYTES('SHA2_256', 'Winter2017')),
    (4, 'nicole', HASHBYTES('SHA2_256', 'Winter2017'));
    