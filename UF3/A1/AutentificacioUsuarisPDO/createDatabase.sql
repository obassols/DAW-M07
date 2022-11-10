create database dwes_obassols_autpdo;
create user dwes_user@localhost identified by "dwes_pass";
grant all privileges on dwes_obassols_autpdo.* to dwes_user@localhost;

mysql -u dwes_user -p
use dwes_obassols_autpdo;

create table connections ( 
    ip varchar(20) NOT NULL,
    user varchar(40) NOT NULL,
    time datetime NOT NULL,
    status varchar(20) NOT NULL,
    PRIMARY KEY (ip,user,time)
);

create table users ( 
    email varchar(40) NOT NULL,
    password varchar(32) NOT NULL,
    name varchar(20) NOT NULL,
    PRIMARY KEY (email)
);

insert into users values 
( 'prova@gmail.com', MD5('prova'), 'prova'),
( 'obassols8@boscdelacoma.cat', MD5('oriolbn20'), 'oriol'),
( 'test@test.com', MD5('test'), 'test');

insert into connections values 
( '::1','test@test.com', '2022-10-24 05:25:36', 'nou-usuari'),
( '::1','test@test.com', '2022-10-24 05:25:46', 'correcte'),
( '::1','test@test.com', '2022-10-24 05:29:23', 'contrasenya-incorrecte'),
( '::1','test@test.com', '2022-10-24 05:29:33', 'correcte');
