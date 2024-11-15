SET foreign_key_checks = 0;

DROP TABLE IF EXISTS soiree;
CREATE TABLE soiree (
                        id  INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        nom VARCHAR(30),
                        theme VARCHAR(30),
                        date DATETIME,
                        tarif DECIMAL(8,2),
                        id_lieu INT(4)
)ENGINE=INNODB;


DROP TABLE IF EXISTS lieu;
CREATE TABLE lieu (
                      id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      nom VARCHAR(30),
                      adresse VARCHAR(30),
                      ville VARCHAR(30),
                      nbPLaceAssise INT(6),
                      nbPlaceDebout INT(6)
)ENGINE=INNODB;


DROP TABLE IF EXISTS spectacle;
CREATE TABLE spectacle (
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




DROP TABLE IF EXISTS artiste;
CREATE TABLE artiste (
                         id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         Nom VARCHAR(30),
                         info VARCHAR(200)
)ENGINE=INNODB;


DROP TABLE IF EXISTS user;
CREATE TABLE user (
                      id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                      email VARCHAR(30),
                      passwd VARCHAR(200),
                      role  INT(4)
)ENGINE=INNODB;


DROP TABLE IF EXISTS image;
CREATE TABLE image (
                       id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       filetype VARCHAR(200),
                       description VARCHAR(200),
                       data MEDIUMBLOB
)ENGINE=INNODB;


DROP TABLE IF EXISTS spectacle2artiste;
CREATE TABLE spectacle2artiste (
                                   id_spectacle INT(4),
                                   id_artiste INT(4),
                                   PRIMARY KEY (id_spectacle, id_artiste)
)ENGINE=INNODB;


DROP TABLE IF EXISTS spectacle2image;
CREATE TABLE spectacle2image (
                                 id_spectacle INT(4),
                                 id_image INT(4),
                                 PRIMARY KEY (id_spectacle, id_image)

)ENGINE=INNODB;

DROP TABLE IF EXISTS lieu2image;
CREATE TABLE lieu2image (
                                 id_lieu INT(4),
                                 id_image INT(4),
                                 PRIMARY KEY (id_lieu, id_image)

)ENGINE=INNODB;


ALTER TABLE soiree ADD foreign key (id_lieu) References lieu(id) ON DELETE CASCADE;

ALTER TABLE spectacle ADD foreign key (id_soiree) References soiree(id) ON DELETE CASCADE;

ALTER TABLE spectacle2artiste ADD foreign key (id_spectacle) References spectacle(id) ON DELETE CASCADE;
ALTER TABLE spectacle2artiste ADD foreign key (id_artiste) References artiste(id) ON DELETE CASCADE;

ALTER TABLE spectacle2image ADD foreign key (id_spectacle) References spectacle(id) ON DELETE CASCADE;
ALTER TABLE spectacle2image ADD foreign key (id_image) References image(id) ON DELETE CASCADE;

ALTER TABLE lieu2image ADD foreign key (id_lieu) References lieu(id) ON DELETE CASCADE;
ALTER TABLE lieu2image ADD foreign key (id_image) References image(id) ON DELETE CASCADE;

SET foreign_key_checks = 1;
