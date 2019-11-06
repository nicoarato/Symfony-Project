CREATE DATABASE IF NOT EXISTS symfony_master;

USE symfony_master;

CREATE TABLE IF NOT EXISTS users(
id      int(255) auto_increment not null,
role    varchar(50),
name    varchar(100),
surname varchar(200),
email   varchar(255),
password    varchar(255),
created_at  datetime,
CONSTRAINT pk_users PRIMARY KEY(id)

)ENGINE=InnoDb;

CREATE TABLE IF NOT EXISTS tasks(
id      int(255) auto_increment not null,
user_id    int(255) not null,
title   varchar(255),
content text,
priority varchar(20),
hours int(100),
created_at  datetime,
CONSTRAINT pk_tasks PRIMARY KEY(id),
CONSTRAINT fk_task_user FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO users VALUES(NULL,'ROLE_USER','Julio','Rojas','julio@julio.com','password', CURDATE());
INSERT INTO users VALUES(NULL,'ROLE_USER','Maria','Sanders','maria@maria.com','password', CURDATE());
INSERT INTO users VALUES(NULL,'ROLE_USER','Beto','Cuevas','beto@beto.com','password', CURDATE());

INSERT INTO tasks VALUES(NULL,1,'Tarea 1','Contenido de tarea 1.','alta',40, CURDATE());
INSERT INTO tasks VALUES(NULL,2,'Tarea 2','Contenido de tarea 2.','media',40, CURDATE());
INSERT INTO tasks VALUES(NULL,1,'Tarea 3','Contenido de tarea 3.','alta',20, CURDATE());
INSERT INTO tasks VALUES(NULL,3,'Tarea 4','Contenido de tarea 4.','alta',30, CURDATE());