-- Remplissage de la table Lieu
INSERT INTO Lieu (nom, adresse, ville, nbPLaceAssise, nbPlaceDebout) VALUES
                                                                         ('Théâtre de Nancy', '1 Place Stanislas', 'Nancy', 500, 300),
                                                                         ('Salle Poirel', '3 Rue Victor Poirel', 'Nancy', 400, 200),
                                                                         ('Centre Culturel Jean Prouvé', '10 Rue de la Liberté', 'Nancy', 350, 150);

-- Remplissage de la table Soiree
INSERT INTO Soiree (nom, theme, date, tarif, id_lieu) VALUES
                                                          ('Soirée Rock Vintage', 'Rock Années 80', '2024-11-15 20:00:00', 18.00, 1),
                                                          ('Soirée Punk', 'Punk Rock', '2024-11-17 21:30:00', 20.00, 2),
                                                          ('Soirée Rock Alternatif', 'Alternatif', '2024-11-19 22:00:00', 22.00, 3);

-- Remplissage de la table Spectacle
INSERT INTO Spectacle (titre, description, heure, duree, libelleStyle, video, id_soiree) VALUES
                                                                                             ('Rock Legends', 'Hommage aux légendes du rock', '2024-11-15 20:00:00', '3h', 'Rock', 'rock_legends.mp4', 1),
                                                                                             ('Punk Vibes', 'Concert de punk rock explosif', '2024-11-17 23:30:00', '2h30', 'Punk', 'punk_vibes.mp4', 1),

                                                                                             ('Punk Vibes', 'Concert de punk rock explosif', '2024-11-17 21:00:00', '2h30', 'Punk', 'punk_vibes.mp4', 2),
                                                                                             ('Maxime&Alexandre', 'Soirée slow', '2024-11-19 00:00:00', '1h', 'Romantique', 'slow.mp4', 2),

                                                                                             ('Indie Night', 'Soirée rock alternatif', '2024-11-19 20:00:00', '3h', 'Indie Rock', 'indie_night.mp4', 3);

-- Remplissage de la table Artiste
INSERT INTO Artiste (Nom, info) VALUES
                                    ('The Old Timers', 'Groupe de rock vintage des années 80'),
                                    ('Punk Society', 'Groupe de punk rock local'),
                                    ('The New Waves', 'Groupe d indie rock de Nancy'),
                                    ('Maxime&Alexandre', 'Groupe de l IUT debutant');

-- Remplissage de la table User
INSERT INTO User (email, passwd, role) VALUES
                                           ('user1@mail.com', '$2y$12$zuDhMZajE1iNFspnM1dXKuA6klaPsblj2kQWw0IHLqVBMADsZlUbe', 1),
                                           ('user2@mail.com', '$2y$12$AVI.s1TYweBoptKjCNM7ruYzbt4R1Dwn0Ahh.fGuFjsPdFgtdiAVy', 1),
                                           ('staff1@mail.com', '$2y$12$/5gRMaEC2nNOylxR8Ka2Dewc9PtTM52MpB2msv.UAnUTgxS5RgGRK', 5),
                                           ('staff2@mail.com', '$2y$12$ZFedI.35kiKMTaDRN4q48uqfQ8OQuS7QVI25zuOJN0pMlJR57i.pC', 5),
                                           ('admin@mail.com', '$2y$12$pY3mRVrMS.NqHL0zkwdgZuucfpx4IMHbGp5RoW7ahzSpMMrCiafZu', 100);


-- Remplissage de la table Image
INSERT INTO Image (filetype, description, data) VALUES
                                                    ('jpeg', 'Affiche Soirée Rock Legends', NULL),
                                                    ('png', 'Bannière Soirée Punk Vibes', NULL),
                                                    ('jpg', 'Affiche Indie Night', NULL),
                                                    ('jpg', 'Led rouge', NULL);

-- Remplissage de la table Spectacle2Artiste
INSERT INTO Spectacle2Artiste (id_spectacle, id_artiste) VALUES
                                                             (1, 1),
                                                             (2, 2),
                                                             (3, 2),
                                                             (4, 4),
                                                             (5, 3);


-- Remplissage de la table Spectacle2Image
INSERT INTO Spectacle2Image (id_spectacle, id_image) VALUES
                                                         (1, 1),
                                                         (2, 2),
                                                         (3, 2),
                                                         (4, 4),
                                                         (5, 3);

-- Remplissage de la table Spectacle2Image
INSERT INTO Lieu2Image (id_lieu, id_image) VALUES
                                                         (1, 4),
                                                         (2, 3),
                                                         (3, 2);
