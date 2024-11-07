SET foreign_key_checks = 0;

DROP TABLE IF EXISTS Soiree;
CREATE TABLE Soiree (
    id  INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(30),
    theme VARCHAR(30),
    date DATE,
    tarif DOUBLE(8,2),
    id_lieu INT(4)
)ENGINE=INNODB;


DROP TABLE IF EXISTS Lieu;
CREATE TABLE Lieu (
    id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(30),
    adresse VARCHAR(30),
    ville VARCHAR(30),
    nbPLaceAssise INT(6),
    nbPlaceDebout INT(6)
)ENGINE=INNODB;


DROP TABLE IF EXISTS Spectacle;
CREATE TABLE Spectacle (
    id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(30),
    description VARCHAR(30),
    heure DATE,
    duree VARCHAR(30),
    libelleStyle VARCHAR(90),
    video VARCHAR(90)
)ENGINE=INNODB;




DROP TABLE IF EXISTS Artiste;
CREATE TABLE Artiste (
    id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nom VARCHAR(30),
    info VARCHAR(30)
)ENGINE=INNODB;


DROP TABLE IF EXISTS User;
CREATE TABLE User (
    id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(30),
    passwd VARCHAR(30),
    role  INT(4)
)ENGINE=INNODB;


DROP TABLE IF EXISTS Image;
CREATE TABLE Image (
    id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    filetype VARCHAR(30),
    description VARCHAR(50),
    data MEDIUMBLOB
)ENGINE=INNODB;


DROP TABLE IF EXISTS Soiree2Spectacle;
CREATE TABLE Soiree2Spectacle (
    id_soiree INT(4),
    id_spectacle INT(4),
    PRIMARY KEY (id_soiree, id_spectacle)
)ENGINE=INNODB;


DROP TABLE IF EXISTS Spectacle2Artiste;
CREATE TABLE Spectacle2Artiste (
    id_spectacle INT(4),
    id_artiste INT(4),
    PRIMARY KEY (id_spectacle, id_artiste)
)ENGINE=INNODB;


DROP TABLE IF EXISTS Spectacle2Image;
CREATE TABLE Spectacle2Image (
    id_spectacle INT(4),
    id_image INT(4),
    PRIMARY KEY (id_spectacle, id_image)

)ENGINE=INNODB;


ALTER TABLE Soiree ADD foreign key (id_lieu) References Lieu(id) ON DELETE CASCADE;

ALTER TABLE Soiree2Spectacle ADD foreign key (id_soiree) References Soiree(id) ON DELETE CASCADE;
ALTER TABLE Soiree2Spectacle ADD foreign key (id_spectacle) References Spectacle(id) ON DELETE CASCADE;


ALTER TABLE Spectacle2Artiste ADD foreign key (id_spectacle) References Spectacle(id) ON DELETE CASCADE;
ALTER TABLE Spectacle2Artiste ADD foreign key (id_artiste) References Artiste(id) ON DELETE CASCADE;

ALTER TABLE Spectacle2Image ADD foreign key (id_spectacle) References Spectacle(id) ON DELETE CASCADE;
ALTER TABLE Spectacle2Image ADD foreign key (id_image) References Image(id) ON DELETE CASCADE;

SET foreign_key_checks = 1;
