-- phpMyAdmin SQL Dump
-- version 3.3.7deb8
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 04 Novembre 2015 à 17:00
-- Version du serveur: 5.1.73
-- Version de PHP: 5.3.3-7+squeeze27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `echecs95`
--

-- --------------------------------------------------------

--
-- Structure de la table `club`
--

CREATE TABLE IF NOT EXISTS `club` (
  `Ref` int(2) DEFAULT NULL,
  `NrFFE` varchar(6) DEFAULT NULL,
  `Nom` varchar(47) DEFAULT NULL,
  `Ligue` varchar(3) DEFAULT NULL,
  `Commune` varchar(22) DEFAULT NULL,
  `dep` varchar(2) DEFAULT NULL,
  `nba` int(11) NOT NULL DEFAULT '0',
  `nbj` int(11) NOT NULL DEFAULT '0',
  KEY `NrFFE` (`NrFFE`),
  KEY `Ref` (`Ref`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
