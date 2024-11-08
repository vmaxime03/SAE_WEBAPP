SET foreign_key_checks = 0;

DROP TABLE IF EXISTS Soiree;
CREATE TABLE Soiree (
                        id  INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        nom VARCHAR(30),
                        theme VARCHAR(30),
                        date DATETIME,
                        tarif DECIMAL(8,2),
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
                           heure DATETIME,
                           duree VARCHAR(30),
                           libelleStyle VARCHAR(90),
                           video VARCHAR(200),
                           id_soiree INT(4),
                        est_annule BOOLEAN default 0
)ENGINE=INNODB;




DROP TABLE IF EXISTS Artiste;
CREATE TABLE Artiste (
                         id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         Nom VARCHAR(30),
                         info VARCHAR(200)
)ENGINE=INNODB;


DROP TABLE IF EXISTS User;
CREATE TABLE User (
                      id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      email VARCHAR(30),
                      passwd VARCHAR(200),
                      role  INT(4)
)ENGINE=INNODB;


DROP TABLE IF EXISTS Image;
CREATE TABLE Image (
                       id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       filetype VARCHAR(200),
                       description VARCHAR(200),
                       data MEDIUMBLOB
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

DROP TABLE IF EXISTS Lieu2Image;
CREATE TABLE Lieu2Image (
                                 id_lieu INT(4),
                                 id_image INT(4),
                                 PRIMARY KEY (id_lieu, id_image)

)ENGINE=INNODB;


ALTER TABLE Soiree ADD foreign key (id_lieu) References Lieu(id) ON DELETE CASCADE;

ALTER TABLE Spectacle ADD foreign key (id_soiree) References Soiree(id) ON DELETE CASCADE;

ALTER TABLE Spectacle2Artiste ADD foreign key (id_spectacle) References Spectacle(id) ON DELETE CASCADE;
ALTER TABLE Spectacle2Artiste ADD foreign key (id_artiste) References Artiste(id) ON DELETE CASCADE;

ALTER TABLE Spectacle2Image ADD foreign key (id_spectacle) References Spectacle(id) ON DELETE CASCADE;
ALTER TABLE Spectacle2Image ADD foreign key (id_image) References Image(id) ON DELETE CASCADE;

ALTER TABLE Lieu2Image ADD foreign key (id_lieu) References Lieu(id) ON DELETE CASCADE;
ALTER TABLE Lieu2Image ADD foreign key (id_image) References Image(id) ON DELETE CASCADE;

SET foreign_key_checks = 1;
