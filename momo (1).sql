-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 25 avr. 2023 à 22:08
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `momo`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `insert_actu`$$
CREATE DEFINER=`zjaouedmo`@`%` PROCEDURE `insert_actu` (IN `ID_MATCH` INT)  BEGIN
set @virgule =', ';
set @a= 'Nouveau match : '; 
set @b = '. Il commencera le ';
set @c = ' et finira le ';
set @d = '. Les joueurs participants a ce match sont les joueurs de numero : ';

 SET @joueurs =(SELECT GROUP_CONCAT(JOU_id,@virgule) from T_MATCH_MAT where mat_id = ID_MATCH);
 
SET @match_details=( SELECT GROUP_CONCAT(@a,MAT_intitule,@b,Mat_datedebut,@d,@joueurs) from T_MATCH_MAT where mat_id = ID_MATCH); 
 
set @end_date = (select mat_datefin from T_MATCH_MAT where mat_id = ID_MATCH);
IF @end_date != NULL THEN 
 set @id_cpt = 1;
ELSE 
 set @id_cpt = (select cpt_id from T_MATCH_MAT where mat_id = ID_MATCH);


END IF;

INSERT into T_ACTUALITE_ACT VALUES (NULL,@match_details, NOW(),@id_cpt) ;
END$$

DROP PROCEDURE IF EXISTS `nombre_match`$$
CREATE DEFINER=`zjaouedmo`@`%` PROCEDURE `nombre_match` (OUT `NB_MATCH` INT)  BEGIN
 SELECT  count(MAT_id) from T_MATCH_MAT INTO NB_MATCH ; 
 SELECT NB_MATCH;

END$$

--
-- Fonctions
--
DROP FUNCTION IF EXISTS `age2`$$
CREATE DEFINER=`zjaouedmo`@`%` FUNCTION `age2` (`birth_date` DATE) RETURNS INT(11) BEGIN
  Set @age=YEAR(NOW())- YEAR(birth_date);
 IF MONTH(birth_date) > MONTH(NOW()) THEN
   RETURN @age-1;
 END IF;
 RETURN @age;

END$$

DROP FUNCTION IF EXISTS `bonne_rep`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `bonne_rep` (`ID_MAT` INT(200)) RETURNS INT(11) BEGIN
 set @nb =(Select COUNT(jou_id) FROM t_joueur_jou);
 set @somme = (select sum(jou_score) from t_joueur_jou);
 RETURN @somme/@nub ;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `t_commande_cmd`
--

DROP TABLE IF EXISTS `t_commande_cmd`;
CREATE TABLE IF NOT EXISTS `t_commande_cmd` (
  `cmd_id` int(11) NOT NULL,
  `cmd_prix` int(11) DEFAULT NULL,
  `cmd_date` date DEFAULT NULL,
  `pdt_id` int(11) NOT NULL,
  `cpt_id` int(11) NOT NULL,
  PRIMARY KEY (`cmd_id`,`pdt_id`,`cpt_id`),
  KEY `fk_t_commande_cmd_t_produit_pdt1` (`pdt_id`),
  KEY `fk_t_commande_cmd_t_profil_pfl1` (`cpt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `t_compte_cpt`
--

DROP TABLE IF EXISTS `t_compte_cpt`;
CREATE TABLE IF NOT EXISTS `t_compte_cpt` (
  `cpt_id` int(11) NOT NULL,
  `cpt_mdp` varchar(45) DEFAULT NULL,
  `cpt_mail` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`cpt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `t_compte_cpt`
--

INSERT INTO `t_compte_cpt` (`cpt_id`, `cpt_mdp`, `cpt_mail`) VALUES
(1, 'qwerty572', 'jaouedmoetaz@gmail.com'),
(2, 'lazreg', 'lazreg@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `t_couleur_col`
--

DROP TABLE IF EXISTS `t_couleur_col`;
CREATE TABLE IF NOT EXISTS `t_couleur_col` (
  `col_clr` varchar(45) NOT NULL,
  `tal_size` char(1) NOT NULL,
  `pdt_id` int(11) NOT NULL,
  PRIMARY KEY (`col_clr`,`tal_size`,`pdt_id`),
  KEY `fk_t_couleur_col_t_taile_tal1` (`tal_size`,`pdt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `t_couleur_col`
--

INSERT INTO `t_couleur_col` (`col_clr`, `tal_size`, `pdt_id`) VALUES
('Gris', 'S', 2),
('Noir', 'S', 2);

-- --------------------------------------------------------

--
-- Structure de la table `t_produit_pdt`
--

DROP TABLE IF EXISTS `t_produit_pdt`;
CREATE TABLE IF NOT EXISTS `t_produit_pdt` (
  `pdt_id` int(11) NOT NULL AUTO_INCREMENT,
  `pdt_nom` varchar(45) DEFAULT NULL,
  `pdt_prix` int(11) DEFAULT NULL,
  `pdt_prixjr` int(11) NOT NULL,
  `pdt_description` varchar(600) DEFAULT NULL,
  `pdt_dispo` char(1) DEFAULT NULL,
  `pdt_img` varchar(45) DEFAULT NULL,
  `pdt_type` varchar(45) NOT NULL,
  PRIMARY KEY (`pdt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `t_produit_pdt`
--

INSERT INTO `t_produit_pdt` (`pdt_id`, `pdt_nom`, `pdt_prix`, `pdt_prixjr`, `pdt_description`, `pdt_dispo`, `pdt_img`, `pdt_type`) VALUES
(8, 'Survêtement Club Hummel ', 35, 35, 'Le survêtement Club Hummel est le choix parfait pour les sportifs. Composé d\'une veste à fermeture éclair et d\'un pantalon assorti, ce survêtement complet est fabriqué avec des matériaux de haute qualité pour vous garder au chaud et au sec pendant vos entraînements. Avec une taille élastique et des poches pratiques, ce survêtement est disponible dans différentes tailles pour s\'adapter à tous les styles.', 'D', 'survetement.png', 'app'),
(9, 'Ballon de Handball Hummel orange', 16, 16, 'Le ballon de handball Hummel orange est conçu avec des matériaux de haute qualité pour offrir une bonne adhérence et une meilleure durabilité. Avec une couleur vive orange pour une meilleure visibilité et des détails sportifs en noir et blanc, ce ballon est disponible en différentes tailles pour s\'adapter aux joueurs de tous les niveaux.', 'D', 'ballon.png', 'product'),
(10, 'Sweat Hummel Noir', 28, 26, 'Le sweat-shirt noir Hummel est le choix parfait pour vos activités sportives et décontractées. Avec un design minimaliste et élégant, ce sweat-shirt est conçu avec des matériaux de haute qualité pour vous garder au chaud et au sec. Doté d\'une capuche ajustable et d\'une poche kangourou pratique, ce sweat-shirt est disponible dans différentes tailles pour s\'adapter à tous les styles.', 'D', 'sweat.png', 'app'),
(11, 'T-shirt Noir Hummel', 11, 11, 'Le T-shirt noir Hummel est un choix élégant pour tous les styles. Fabriqué avec des matériaux de qualité, il est conçu pour offrir un confort et un style optimal.', 'D', 't-shirt.png', 'app'),
(12, 'Sac à dos CORE  BACK PACK ', 21, 21, 'Le sac à dos CORE BACK PACK est le choix idéal pour les déplacements quotidiens et les activités sportives. Fabriqué avec des matériaux résistants, il offre une grande capacité de rangement et un confort optimal grâce à ses bretelles matelassées réglables. Que ce soit pour aller en cours, au travail ou pour un voyage, ce sac à dos sera votre allié indispensable.', 'D', 'backpack.png', 'product'),
(13, 'Hoodie veste coton', 34, 30, 'Le hoodie veste en coton est un choix confortable pour les journées décontractées. Fabriqué à partir de matériaux doux et respirants, ce hoodie est parfait pour une utilisation quotidienne ou pour vos activités sportives. Avec sa coupe décontractée et son style intemporel, ce hoodie est un indispensable de votre garde-robe.', 'D', 'hoodie.png', 'app');

-- --------------------------------------------------------

--
-- Structure de la table `t_profil_pfl`
--

DROP TABLE IF EXISTS `t_profil_pfl`;
CREATE TABLE IF NOT EXISTS `t_profil_pfl` (
  `pfl_prenom` varchar(45) DEFAULT NULL,
  `pfl_nom` varchar(45) DEFAULT NULL,
  `pfl_role` char(1) DEFAULT NULL,
  `pfl_mail` varchar(45) DEFAULT NULL,
  `cpt_id` int(11) NOT NULL,
  PRIMARY KEY (`cpt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `t_profil_pfl`
--

INSERT INTO `t_profil_pfl` (`pfl_prenom`, `pfl_nom`, `pfl_role`, `pfl_mail`, `cpt_id`) VALUES
('Moetaz', 'Jaoued', 'A', 'jaouedmoetaz@gmail.com', 1),
('lazreg', 'legoff', 'U', 'lazreg@gmail.com', 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `t_commande_cmd`
--
ALTER TABLE `t_commande_cmd`
  ADD CONSTRAINT `fk_t_commande_cmd_t_produit_pdt1` FOREIGN KEY (`pdt_id`) REFERENCES `t_produit_pdt` (`pdt_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_t_commande_cmd_t_profil_pfl1` FOREIGN KEY (`cpt_id`) REFERENCES `t_profil_pfl` (`cpt_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_couleur_col`
--
ALTER TABLE `t_couleur_col`
  ADD CONSTRAINT `fk_t_couleur_col_t_taile_tal1` FOREIGN KEY (`tal_size`,`pdt_id`) REFERENCES `t_taile_tal` (`tal_size`, `pdt_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `t_profil_pfl`
--
ALTER TABLE `t_profil_pfl`
  ADD CONSTRAINT `fk_t_profil_pfl_t_compte_cpt` FOREIGN KEY (`cpt_id`) REFERENCES `t_compte_cpt` (`cpt_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
