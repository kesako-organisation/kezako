-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 12 Juin 2014 à 14:48
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `kezako`
--
DROP DATABASE IF EXISTS `kezako`;
CREATE DATABASE `kezako` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `kezako`;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `labelCategorie` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idCategorie`),
  UNIQUE KEY `idCategorie` (`idCategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `labelCategorie`) VALUES
(1, 'Toutes'),
(2, 'Astronomie'),
(3, 'Cinéma'),
(4, 'Géographie'),
(5, 'Histoire'),
(6, 'Jeux'),
(7, 'Sport'),
(8, 'Série');

-- --------------------------------------------------------

--
-- Structure de la table `joueur`
--

CREATE TABLE IF NOT EXISTS `joueur` (
  `idJoueur` int(11) NOT NULL AUTO_INCREMENT,
  `login` text COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `email` text COLLATE utf8_bin NOT NULL,
  `nbQuestionsCorrectes` int(11) NOT NULL DEFAULT '0',
  `nbQuestionsRepondus` int(11) NOT NULL DEFAULT '0',
  `nbTotalPoints` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `isConnect` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idJoueur`),
  UNIQUE KEY `idJoueur` (`idJoueur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Contenu de la table `joueur`
--

INSERT INTO `joueur` (`idJoueur`, `login`, `password`, `email`, `nbQuestionsCorrectes`, `nbQuestionsRepondus`, `nbTotalPoints`, `status`, `isConnect`) VALUES
(1, 'Fabien', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'fabien.lassie@gmail.com', 0, 0, 0, 1, 0),
(2, 'Faouzi', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'faouzi.gazzah@gmail.com', 0, 0, 0, 1, 0),
(3, 'Julien', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'dealmeida.julien@gmail.com', 0, 0, 0, 1, 0),
(4, 'Matthias', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'matthias.ballarini@gmail.com', 0, 0, 0, 1, 0),
(5, 'Thomas', '22b12a761a4cc5fb8b3633b2bf728ce7ffc1db96593b9fa3adbdb6c88df1f974cd306ef4d6217f5406781dcf7d165822e3a8d2cd2bf8eb425330def115eb9920', 'tomavron94@gmail.com', 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `log` varchar(400) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `idQuestion` int(11) NOT NULL AUTO_INCREMENT,
  `labelQuestion` text COLLATE utf8_bin NOT NULL,
  `idCategorie` int(11) NOT NULL,
  `isValidated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idQuestion`),
  UNIQUE KEY `idQuestion` (`idQuestion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=52 ;

--
-- Contenu de la table `question`
--

INSERT INTO `question` (`idQuestion`, `labelQuestion`, `idCategorie`, `isValidated`) VALUES
(2, 'Qui a gagné Rolland Garros, catégorie homme, en 2009 ?', 7, 1),
(3, 'Combien de ligue des champions compte le S.L.Benfica ?', 7, 1),
(4, 'A quel âge est décédé le pilote de Formule 1, Ayrton Senna ?', 7, 1),
(5, 'Combien de courses a disputé Alain Prost ?', 7, 1),
(6, 'Quel joueur a obtenu le Ballon d''or en 2008 ?', 7, 1),
(7, 'Quelle est la date de sortie du film "E.T." ?', 3, 1),
(8, 'Qui a réalisé le film "Indiana Jones : Les Aventuriers de l''arche perdue" ?', 3, 1),
(9, 'Quel acteur a été le plus récompensé pour l''Oscar du meilleur acteur ?', 3, 1),
(10, 'Qui a reçu le prix du César du meilleur acteur en 2011 ?', 3, 1),
(11, 'En quelle année Coluche a-t-il reçu le prix du César du meilleur acteur ?', 3, 1),
(12, 'Quel est le métier principal de Walter White, dans la série "Breaking bad" ?', 8, 1),
(13, 'Quel est le nom de l''hopital de la série "Dr House" ?', 8, 1),
(14, 'Quel est le nom de la prison dans la série "Prison Break" ?', 8, 1),
(15, 'Comment est surnommé le personnage "Daenerys Targaryen", dans la série "Games of Thrones" ?', 8, 1),
(16, 'Quel personnage de la série "the Walking dead" ne fait pas parti de la BD ?', 8, 1),
(17, 'Qui est le premier président de la République française ?', 5, 1),
(18, 'Quel est le nom du premier homme a avoir fait le tour du Monde ?', 5, 1),
(19, 'Qui a été le premier roi de France ?', 5, 1),
(20, 'En quel année Louis XIV est-il mort ?', 5, 1),
(21, 'Quel navigateur a découvert le Brésil ?', 5, 1),
(22, 'Quelle est la capital du Brésil ?', 4, 1),
(23, 'Quelle est la capital du Bénin ?', 4, 1),
(24, 'Dans quel pays le fleuve du "Douro" prend-t-il source ?', 4, 1),
(25, 'Quel est l''océan le plus vaste du globe terrestre ?', 4, 1),
(26, 'Dans quel pays se situe le Kilimandjaro ?', 4, 1),
(27, 'Qui est le créateur de Mario ?', 6, 1),
(28, 'Qui est le créateur de Kirby ?', 6, 1),
(29, 'En quel année est sortie le titre "Sonic the Hedgehog" ?', 6, 1),
(30, 'Quelle est la nationalité du créateur de Tetris ?', 6, 1),
(31, 'Qui est le créateur de "Metal Gear Solid" ?', 6, 1),
(32, 'Quel est la planète la plus proche du Soleil ?', 2, 1),
(33, 'Quel est la planète la plus proche de la Terre ?', 2, 1),
(34, 'A quelle distance se situe la Lune par rapport à la Terre ?', 2, 1),
(35, 'En quelle année a été lancé le programme  "Apollo" ?', 2, 1),
(36, 'Quel est le nom de la première navette spatiale ?', 2, 1),
(37, 'Combien de coupe du Monde compte l''équipe de France de football ?', 7, 1),
(38, 'Quel est le sportif possèdant le plus de titre en Jeux Olympiques ?', 7, 1),
(39, 'Quel est l''année des premiers Jeux paralympiques ?', 7, 1),
(40, 'En quel année ont eu lieu les Jeux paralympiques de Barcelone ?', 7, 1),
(41, 'De combien est le record du monde de 100 m détenu par Usain Bolt ?', 7, 1),
(42, 'En quelle année est sortie en salle le film "Retour vers le futur" ?', 3, 1),
(43, 'En quelle année est sortie le film "Bad boy"', 3, 1),
(44, 'En quelle année, l''acteur Will Smith débute sa carrière dans le cinéma ?', 3, 1),
(45, 'Combien le film "Intouchables" a-t-il comptabilisé d''entrées en France ?', 3, 1),
(46, 'Quel est le film le plus vu de l''histoire ?', 3, 1),
(47, 'En quelle année s''est arrêté la série "Heroes" ?', 8, 1),
(48, 'Quel est le pouvoir du personnage "Hiro Nakamura" dans la série "Heroes" ?', 8, 1),
(49, 'Dans quelle série a joué l''acteur "Bryan Cranston" ?', 8, 1),
(50, 'Combien compte d''épisode la série "Sliders" ?', 8, 1),
(51, 'Quelle chaine américaine diffuse la série "Dr House" ?', 8, 1);

--
-- Déclencheurs `question`
--
DROP TRIGGER IF EXISTS `deleteReponse`;
DELIMITER //
CREATE TRIGGER `deleteReponse` AFTER DELETE ON `question`
 FOR EACH ROW BEGIN
DELETE FROM questionreponse WHERE idQuestion NOT IN (SELECT idQuestion FROM question);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `questionreponse`
--

CREATE TABLE IF NOT EXISTS `questionreponse` (
  `idQuestion` int(11) NOT NULL,
  `idReponse` int(11) NOT NULL,
  `isCorrect` tinyint(1) NOT NULL,
  PRIMARY KEY (`idQuestion`,`idReponse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `questionreponse`
--

INSERT INTO `questionreponse` (`idQuestion`, `idReponse`, `isCorrect`) VALUES
(0, 221, 1),
(0, 222, 0),
(0, 223, 0),
(0, 224, 0),
(2, 5, 1),
(2, 6, 0),
(2, 7, 0),
(2, 8, 0),
(3, 9, 1),
(3, 10, 0),
(3, 11, 0),
(3, 12, 0),
(4, 13, 1),
(4, 14, 0),
(4, 15, 0),
(4, 16, 0),
(5, 17, 1),
(5, 18, 0),
(5, 19, 0),
(5, 20, 0),
(6, 21, 1),
(6, 22, 0),
(6, 23, 0),
(6, 24, 0),
(7, 25, 1),
(7, 26, 0),
(7, 27, 0),
(7, 28, 0),
(8, 29, 1),
(8, 30, 0),
(8, 31, 0),
(8, 32, 0),
(9, 33, 1),
(9, 34, 0),
(9, 35, 0),
(9, 36, 0),
(10, 37, 1),
(10, 38, 0),
(10, 39, 0),
(10, 40, 0),
(11, 25, 0),
(11, 26, 0),
(11, 28, 1),
(11, 42, 0),
(12, 45, 1),
(12, 46, 0),
(12, 47, 0),
(12, 48, 0),
(13, 49, 1),
(13, 50, 0),
(13, 51, 0),
(13, 52, 0),
(14, 53, 1),
(14, 54, 0),
(14, 55, 0),
(14, 56, 0),
(15, 57, 1),
(15, 58, 0),
(15, 59, 0),
(15, 60, 0),
(16, 61, 1),
(16, 62, 0),
(16, 63, 0),
(16, 64, 0),
(17, 65, 1),
(17, 66, 0),
(17, 67, 0),
(17, 68, 0),
(18, 69, 1),
(18, 70, 0),
(18, 71, 0),
(18, 72, 0),
(19, 73, 1),
(19, 74, 0),
(19, 75, 0),
(19, 76, 0),
(20, 77, 1),
(20, 78, 0),
(20, 79, 0),
(20, 80, 0),
(21, 70, 0),
(21, 81, 1),
(21, 83, 0),
(21, 84, 0),
(22, 85, 1),
(22, 86, 0),
(22, 87, 0),
(22, 88, 0),
(23, 89, 1),
(23, 90, 0),
(23, 91, 0),
(23, 92, 0),
(24, 1, 0),
(24, 3, 0),
(24, 93, 1),
(24, 94, 0),
(25, 97, 1),
(25, 98, 0),
(25, 99, 0),
(25, 100, 0),
(26, 101, 1),
(26, 102, 0),
(26, 103, 0),
(26, 104, 0),
(27, 105, 1),
(27, 106, 0),
(27, 107, 0),
(27, 108, 0),
(28, 59, 0),
(28, 105, 0),
(28, 107, 1),
(28, 112, 0),
(29, 27, 0),
(29, 113, 1),
(29, 115, 0),
(29, 116, 0),
(30, 117, 1),
(30, 118, 0),
(30, 119, 0),
(30, 120, 0),
(31, 105, 0),
(31, 107, 0),
(31, 112, 1),
(31, 124, 0),
(32, 125, 1),
(32, 126, 0),
(32, 127, 0),
(32, 128, 0),
(33, 125, 0),
(33, 126, 1),
(33, 130, 0),
(33, 132, 0),
(34, 133, 1),
(34, 134, 0),
(34, 135, 0),
(34, 136, 0),
(35, 28, 0),
(35, 137, 1),
(35, 139, 0),
(35, 140, 0),
(36, 141, 1),
(36, 142, 0),
(36, 143, 0),
(36, 144, 0),
(37, 9, 0),
(37, 10, 1),
(37, 11, 0),
(37, 12, 0),
(38, 149, 1),
(38, 150, 0),
(38, 151, 0),
(38, 152, 0),
(39, 153, 1),
(39, 154, 0),
(39, 155, 0),
(39, 156, 0),
(40, 157, 1),
(40, 158, 0),
(40, 159, 0),
(40, 160, 0),
(41, 161, 1),
(41, 162, 0),
(41, 163, 0),
(41, 164, 0),
(42, 42, 1),
(42, 166, 0),
(42, 167, 0),
(42, 168, 0),
(43, 160, 1),
(43, 170, 0),
(43, 171, 0),
(43, 172, 0),
(44, 113, 0),
(44, 159, 0),
(44, 160, 1),
(44, 170, 0),
(45, 177, 1),
(45, 178, 0),
(45, 179, 0),
(45, 180, 0),
(46, 181, 1),
(46, 182, 0),
(46, 183, 0),
(46, 184, 0),
(47, 185, 1),
(47, 186, 0),
(47, 187, 0),
(47, 188, 0),
(48, 189, 1),
(48, 190, 0),
(48, 191, 0),
(48, 192, 0),
(49, 193, 1),
(49, 194, 0),
(49, 195, 0),
(49, 196, 0),
(50, 197, 1),
(50, 198, 0),
(50, 199, 0),
(50, 200, 0),
(51, 201, 1),
(51, 202, 0),
(51, 203, 0),
(51, 204, 0);

--
-- Déclencheurs `questionreponse`
--
DROP TRIGGER IF EXISTS `deleteReponse2`;
DELIMITER //
CREATE TRIGGER `deleteReponse2` AFTER DELETE ON `questionreponse`
 FOR EACH ROW BEGIN
DELETE FROM reponse WHERE idReponse NOT IN (SELECT idReponse FROM questionreponse);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `reponse`
--

CREATE TABLE IF NOT EXISTS `reponse` (
  `idReponse` int(11) NOT NULL AUTO_INCREMENT,
  `labelReponse` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idReponse`),
  UNIQUE KEY `idReponse` (`idReponse`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=225 ;

--
-- Contenu de la table `reponse`
--

INSERT INTO `reponse` (`idReponse`, `labelReponse`) VALUES
(1, 'France'),
(3, 'Allemagne'),
(5, 'Roger Federer'),
(6, 'Rafael Nadal'),
(7, 'Novak Djokovic'),
(8, 'Andre Agassi'),
(9, '2'),
(10, '1'),
(11, '3'),
(12, '0'),
(13, '34'),
(14, '27'),
(15, '32'),
(16, '33'),
(17, '199'),
(18, '254'),
(19, '158'),
(20, '186'),
(21, 'C. Ronaldo'),
(22, 'L. Messi'),
(23, 'W. Sneijder'),
(24, 'Z. Ibrahimovic'),
(25, '1982'),
(26, '1983'),
(27, '1981'),
(28, '1984'),
(29, 'Steven Spielberg'),
(30, 'James Cameron'),
(31, 'George Lucas'),
(32, 'Luc Besson'),
(33, 'Daniel Day-Lewis'),
(34, 'Tom Hanks'),
(35, 'Sean Penn'),
(36, 'Dustin Hoffman'),
(37, 'Éric Elmosnino'),
(38, 'Omar Sy'),
(39, 'Gérard Depardieu'),
(40, 'Romain Duris'),
(42, '1985'),
(45, 'Professeur'),
(46, 'Chimiste'),
(47, 'Avocat'),
(48, 'Juriste'),
(49, 'Princeton-Plainsboro'),
(50, 'C.H.U'),
(51, 'Sacred Heart'),
(52, 'Seattle Grace Hospital'),
(53, 'Fox River'),
(54, 'Fox Reaver'),
(55, 'Fresnes'),
(56, 'Foxe Reavers'),
(57, 'Mother dragons'),
(58, 'Mother hobbits'),
(59, 'Hodor'),
(60, 'Mother dwarf'),
(61, 'Daryl Dixon'),
(62, 'Rick Grimes'),
(63, 'Glenn'),
(64, 'Michonne'),
(65, 'Napoléon Bonaparte'),
(66, 'Louis XIV'),
(67, 'Félix Faure'),
(68, 'Jules Grévy'),
(69, 'Magellan'),
(70, 'Christophe Colomb'),
(71, 'Amerigo Vespucci'),
(72, 'Pietro Querini'),
(73, 'Clovis 1er'),
(74, 'Clodomir'),
(75, 'Dagobert 1er'),
(76, 'Thierry III'),
(77, '1715'),
(78, '1789'),
(79, '1756'),
(80, '1790'),
(81, 'Pedro Álvares Cabral'),
(83, 'Gerard Depardieu'),
(84, 'Hoddor'),
(85, 'Brasilia'),
(86, 'Rio de Janeiro'),
(87, 'São Paulo'),
(88, 'Salvador'),
(89, 'Porto-Novo'),
(90, 'Porto-Nuevo'),
(91, 'Porto-Rico'),
(92, 'Puerto-Rico'),
(93, 'Portugal'),
(94, 'Espagne '),
(97, 'Pacifique'),
(98, 'Atlantique'),
(99, 'Indien'),
(100, 'Arctique'),
(101, 'Tanzanie '),
(102, 'Afrique du Sud'),
(103, 'Egypte'),
(104, 'Maroc'),
(105, 'Shigeru Miyamoto'),
(106, 'Pham Dat'),
(107, 'Masahiro Sakurai'),
(108, 'Stéphanie Choux'),
(112, 'Hideo Kojima'),
(113, '1991'),
(115, '1971'),
(116, '2001'),
(117, 'Russe'),
(118, 'Chinoise'),
(119, 'Française'),
(120, 'Belge'),
(124, 'Vaik Duhautois'),
(125, 'Mercure'),
(126, 'Mars'),
(127, 'Vénus'),
(128, 'Saturne'),
(130, 'Venus'),
(132, 'Jupiter'),
(133, '384 400'),
(134, '256800'),
(135, '436100'),
(136, '198200'),
(137, '1961'),
(139, '1956'),
(140, '1958'),
(141, 'Colombia'),
(142, 'Mississippi'),
(143, 'Atlantis '),
(144, 'Chicago'),
(149, 'Michael Phelps'),
(150, 'Larissa Latynina'),
(151, 'Carl Lewis'),
(152, 'Usain Bolt'),
(153, '1960'),
(154, '1970'),
(155, '1655'),
(156, '1963'),
(157, '1992'),
(158, '1966'),
(159, '1990'),
(160, '1995'),
(161, '9s58'),
(162, '9s56'),
(163, '9s55'),
(164, '9s57'),
(166, '1986'),
(167, '1987'),
(168, '1988'),
(170, '1996'),
(171, '1998'),
(172, '1994'),
(177, '52457243'),
(178, '55602236'),
(179, '26222789'),
(180, '56320147'),
(181, 'Avatar'),
(182, 'Titanic'),
(183, 'Avengers'),
(184, 'Toy Story 3'),
(185, '2010'),
(186, '2009'),
(187, '2007'),
(188, '2008'),
(189, 'Courber l''espace-temps'),
(190, 'Télékinésie'),
(191, 'Téléportation'),
(192, 'Télépathie'),
(193, 'Malcolm'),
(194, 'Dr House'),
(195, 'Heroes'),
(196, 'Dallas'),
(197, '88'),
(198, '89'),
(199, '100'),
(200, '101'),
(201, 'Fox'),
(202, 'AMC'),
(203, 'HBO'),
(204, 'WC'),
(221, 'Zidane'),
(222, 'Ta soeur'),
(223, 'Ta mère'),
(224, 'Faouzi');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `idSalle` int(11) NOT NULL AUTO_INCREMENT,
  `nomSalle` text COLLATE utf8_bin NOT NULL,
  `idCategorie` int(11) NOT NULL DEFAULT '0',
  `nbQuestions` int(11) NOT NULL,
  `tempsLimite` int(11) NOT NULL,
  `isStarted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idSalle`),
  UNIQUE KEY `idRoom` (`idSalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

--
-- Déclencheurs `salle`
--
DROP TRIGGER IF EXISTS `deleteQuestionRoom`;
DELIMITER //
CREATE TRIGGER `deleteQuestionRoom` AFTER DELETE ON `salle`
 FOR EACH ROW BEGIN
DELETE FROM sallequestion WHERE idSalle NOT IN (SELECT idSalle FROM salle);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `sallejoueur`
--

CREATE TABLE IF NOT EXISTS `sallejoueur` (
  `idSalle` int(11) NOT NULL,
  `idJoueur` int(11) NOT NULL,
  `isHost` tinyint(1) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `tempsLastQuestion` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`idSalle`,`idJoueur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déclencheurs `sallejoueur`
--
DROP TRIGGER IF EXISTS `deleteEmptyRoom`;
DELIMITER //
CREATE TRIGGER `deleteEmptyRoom` AFTER DELETE ON `sallejoueur`
 FOR EACH ROW BEGIN
DELETE FROM salle WHERE idSalle NOT IN (SELECT idSalle FROM sallejoueur);
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `sallequestion`
--

CREATE TABLE IF NOT EXISTS `sallequestion` (
  `idSalle` int(11) NOT NULL,
  `idQuestion` int(11) NOT NULL,
  `winner` int(11) NOT NULL,
  PRIMARY KEY (`idSalle`,`idQuestion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
