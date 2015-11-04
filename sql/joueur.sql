-- phpMyAdmin SQL Dump
-- version 3.3.7deb8
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 04 Novembre 2015 à 16:59
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
-- Structure de la table `joueur`
--

CREATE TABLE IF NOT EXISTS `joueur` (
  `Ref` int(11) DEFAULT NULL,
  `NrFFE` varchar(6) DEFAULT NULL,
  `Nom` varchar(20) DEFAULT NULL,
  `Prenom` varchar(20) DEFAULT NULL,
  `Sexe` varchar(1) DEFAULT NULL,
  `NeLe` date DEFAULT NULL,
  `Cat` varchar(4) DEFAULT NULL,
  `Federation` varchar(3) DEFAULT NULL,
  `ClubRef` int(11) DEFAULT NULL,
  `Elo` int(11) DEFAULT NULL,
  `elo_s` int(11) NOT NULL DEFAULT '0',
  `Rapide` int(11) DEFAULT NULL,
  `Fide` varchar(1) DEFAULT NULL,
  `FideCode` int(11) DEFAULT NULL,
  `FideTitre` varchar(2) DEFAULT NULL,
  `AffType` varchar(1) DEFAULT NULL,
  `Actif` int(11) DEFAULT NULL,
  KEY `ClubRef` (`ClubRef`),
  KEY `NrFFE` (`NrFFE`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
