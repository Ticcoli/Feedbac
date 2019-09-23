-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 23 Septembre 2019 à 16:33
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `stadjutodmbd01`
--

-- --------------------------------------------------------

--
-- Structure de la table `horaires`
--

CREATE TABLE IF NOT EXISTS `horaires` (
  `IDhor` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `heure` time(6) NOT NULL COMMENT 'heure du début',
  `moment` varchar(50) NOT NULL COMMENT 'moment de la journée',
  PRIMARY KEY (`IDhor`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='demandes de congé' AUTO_INCREMENT=2986 ;

--
-- Contenu de la table `horaires`
--

INSERT INTO `horaires` (`IDhor`, `heure`, `moment`) VALUES
(2940, '00:00:00.000000', ''),
(2941, '00:00:00.000000', ''),
(2942, '00:00:00.000000', ''),
(2943, '00:00:00.000000', ''),
(2944, '00:00:00.000000', ''),
(2945, '00:00:00.000000', ''),
(2959, '00:00:00.000000', ''),
(2960, '00:00:00.000000', ''),
(2961, '00:00:00.000000', ''),
(2962, '00:00:00.000000', ''),
(2963, '00:00:00.000000', ''),
(2964, '00:00:00.000000', ''),
(2965, '00:00:00.000000', ''),
(2966, '00:00:00.000000', ''),
(2967, '00:00:00.000000', ''),
(2968, '00:00:00.000000', ''),
(2969, '00:00:00.000000', ''),
(2970, '00:00:00.000000', ''),
(2974, '00:00:00.000000', ''),
(2975, '00:00:00.000000', ''),
(2976, '00:00:00.000000', ''),
(2977, '00:00:00.000000', ''),
(2978, '00:00:00.000000', ''),
(2979, '00:00:00.000000', ''),
(2980, '00:00:00.000000', ''),
(2981, '00:00:00.000000', ''),
(2982, '00:00:00.000000', ''),
(2983, '00:00:00.000000', ''),
(2984, '00:00:00.000000', ''),
(2985, '00:00:00.000000', '');

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

CREATE TABLE IF NOT EXISTS `intervention` (
  `IDinter` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `date` date NOT NULL COMMENT 'date d''intervention',
  `accepte` int(2) NOT NULL DEFAULT '0' COMMENT '0=en attente; 1=accepté; 2=refusé',
  `commenteleve` varchar(255) NOT NULL COMMENT 'commentaire de l''élève',
  `commentprof` varchar(255) NOT NULL COMMENT 'commentaire du prof',
  `idutilisateur` int(11) NOT NULL COMMENT 'clé étrangère élève',
  `idhoraires` int(11) NOT NULL COMMENT 'clé étrangère horraires',
  `idutilisateur_examiner_par` int(11) NOT NULL COMMENT 'clé étrangère prof',
  PRIMARY KEY (`IDinter`),
  KEY `idutilisateur` (`idutilisateur`),
  KEY `idutilisateur_examiner_par` (`idutilisateur_examiner_par`),
  KEY `idhoraires` (`idhoraires`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `jours_feries`
--

CREATE TABLE IF NOT EXISTS `jours_feries` (
  `IDjoursf` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `date` date NOT NULL COMMENT 'la date ',
  `nom` varchar(50) NOT NULL COMMENT 'le nom',
  PRIMARY KEY (`IDjoursf`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `jours_feries`
--

INSERT INTO `jours_feries` (`IDjoursf`, `date`, `nom`) VALUES
(1, '2019-01-01', 'Nouvel an'),
(2, '2018-12-24', 'Noël'),
(5, '1000-07-14', 'Fête nationale'),
(13, '2019-08-15', '15 août'),
(14, '1000-11-11', '11 novembre'),
(15, '1000-05-08', '8 Mai'),
(16, '1000-05-01', 'Fête du travail');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `IDuser` int(11) NOT NULL AUTO_INCREMENT COMMENT 'clef primaire',
  `nom` varchar(20) NOT NULL COMMENT 'nom de l''utilisateur',
  `prenom` varchar(20) NOT NULL COMMENT 'prenom de l''utilisateur',
  `mail` varchar(50) NOT NULL COMMENT 'mail de l''utilisateur',
  `droits` tinyint(2) NOT NULL DEFAULT '2' COMMENT '0=admin;1=prof;2=élève',
  `password` varchar(200) NOT NULL,
  `serie` varchar(30) NOT NULL COMMENT 'Série de bac',
  `session` varchar(30) NOT NULL COMMENT 'session de l''année',
  `parcours` varchar(255) NOT NULL COMMENT 'parcours scolaire',
  `telephone` int(20) DEFAULT NULL,
  PRIMARY KEY (`IDuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='les données de chaque employé' AUTO_INCREMENT=18 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`IDuser`, `nom`, `prenom`, `mail`, `droits`, `password`, `serie`, `session`, `parcours`, `telephone`) VALUES
(15, 'test', '02', 'test02.mail@mail.com', 2, '078bbb4bf0f7117fb131ec45f15b5b87', 's', '2018', 'test test test test test test', NULL),
(16, 'test', '01', 'test01.mail@mail.com', 1, '078bbb4bf0f7117fb131ec45f15b5b87', 'prof', 'prof', 'prof', NULL),
(17, 'test', '00', 'test.mail@mail.com', 0, '078bbb4bf0f7117fb131ec45f15b5b87', 'admin', 'admin', 'admin', NULL);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `intervention`
--
ALTER TABLE `intervention`
  ADD CONSTRAINT `idhoraires` FOREIGN KEY (`idhoraires`) REFERENCES `horaires` (`IDhor`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
