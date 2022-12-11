create database dwes_obassols_concurs_gossos;
create user dwes_user@localhost identified by "dwes_pass";
grant all privileges on dwes_obassols_concurs_gossos.* to dwes-user@localhost;

mysql -u dwes_user -p
use dwes_obassols_concurs_gossos;

create table AdminUsers ( 
    name varchar(20) NOT NULL,
    password varchar(32) NOT NULL,
    PRIMARY KEY (name)
);

create table Fase ( 
    id varchar(20) NOT NULL,
    dateStart DateTime NOT NULL,
    dateEnd DateTime NOT NULL,
    PRIMARY KEY (id)
);

create table Dog ( 
    id varchar(20) NOT NULL,
    name varchar(20) NOT NULL,
    img varchar(64) NOT NULL,
    owner varchar(20) NOT NULL,
    PRIMARY KEY (id)
);

create table Fase_Dog ( 
    faseId varchar(20) NOT NULL,
    idDog varchar(20) NOT NULL,
    active boolean NOT NULL,
    PRIMARY KEY (faseId, idDog),
    CONSTRAINT FK_Fase_Fase_Dog FOREIGN KEY (faseId) REFERENCES Fase(id),
    CONSTRAINT FK_Dog_Fase_Dog FOREIGN KEY (idDog) REFERENCES Dog(id)
);

create table Vote ( 
    idSession varchar(32) NOT NULL,
    faseId varchar(20) NOT NULL,
    idDog varchar(20) NOT NULL,
    PRIMARY KEY (idSession, faseId, idDog),
    CONSTRAINT FK_FaseVote FOREIGN KEY (faseId) REFERENCES Fase(id),
    CONSTRAINT FK_DogVote FOREIGN KEY (idDog) REFERENCES Dog(id)
);

insert into AdminUsers values 
( 'admin', MD5('admin'));

insert into Dog values 
( 'dog1', 'Musclo', 'g1.png', 'owner1'),
( 'dog2', 'Jingo', 'g2.png', 'owner2'),
( 'dog3', 'Xuia', 'g3.png', 'owner3'),
( 'dog4', 'Bruc', 'g4.png', 'owner4'),
( 'dog5', 'Fluski', 'g5.png', 'owner5'),
( 'dog6', 'Fonoll', 'g6.png', 'owner6'),
( 'dog7', 'Swing', 'g7.png', 'owner7'),
( 'dog8', 'Coloma', 'g8.png', 'owner8'),
( 'dog9', 'Ruffus', 'g9.png', 'owner9');