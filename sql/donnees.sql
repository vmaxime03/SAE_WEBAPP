-- Remplissage de la table Lieu
INSERT INTO Lieu (nom, adresse, ville, nbPLaceAssise, nbPlaceDebout) VALUES
                                                                         ('Théâtre National', '12 Rue de la Scène', 'Paris', 500, 200),
                                                                         ('Salle du Spectacle', '22 Boulevard des Arts', 'Lyon', 300, 100),
                                                                         ('Centre Culturel', '33 Avenue du Théâtre', 'Marseille', 400, 150);

-- Remplissage de la table Soiree
INSERT INTO Soiree (nom, theme, date, tarif, id_lieu) VALUES
                                                          ('Soirée Comédie', 'Comédie', '2024-12-01', 20.00, 1),
                                                          ('Soirée Jazz', 'Jazz', '2024-12-05', 15.00, 2),
                                                          ('Soirée Théâtre', 'Théâtre Classique', '2024-12-10', 25.00, 3);

-- Remplissage de la table Spectacle
INSERT INTO Spectacle (titre, description, heure, duree, libelleStyle, video, id_soiree) VALUES
                                                                                             ('Comedy Night', 'Spectacle humoristique', '2024-12-01 20:00:00', '2h', 'Humour', 'comedy_night.mp4', 1),
                                                                                             ('Jazz Live', 'Concert de jazz en live', '2024-12-05 21:00:00', '1h30', 'Jazz', 'jazz_live.mp4', 2),
                                                                                             ('Théâtre Classique', 'Pièce de théâtre', '2024-12-10 19:30:00', '2h30', 'Classique', 'theatre_classique.mp4', 3);

-- Remplissage de la table Artiste
INSERT INTO Artiste (Nom, info) VALUES
                                    ('Jean Dupont', 'Humoriste'),
                                    ('Marie Leclerc', 'Chanteuse de jazz'),
                                    ('Paul Durand', 'Acteur de théâtre');

-- Remplissage de la table User
INSERT INTO User (email, passwd, role) VALUES
                                           ('jean.dupont@example.com', 'password123', 1),
                                           ('marie.leclerc@example.com', 'securepass', 2),
                                           ('paul.durand@example.com', 'mysecretpass', 1);

-- Remplissage de la table Image
INSERT INTO Image (filetype, description, data) VALUES
                                                    ('jpeg', 'Affiche Comedy Night', NULL),
                                                    ('png', 'Bannière Jazz Live', NULL),
                                                    ('jpg', 'Affiche Théâtre Classique', NULL);

-- Remplissage de la table Spectacle2Artiste
INSERT INTO Spectacle2Artiste (id_spectacle, id_artiste) VALUES
                                                             (1, 1),
                                                             (2, 2),
                                                             (3, 3);

-- Remplissage de la table Spectacle2Image
INSERT INTO Spectacle2Image (id_spectacle, id_image) VALUES
                                                         (1, 1),
                                                         (2, 2),
                                                         (3, 3);
