-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 29. Apr 2014 um 15:04
-- Server Version: 5.5.32
-- PHP-Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `timer_app`
--
CREATE DATABASE IF NOT EXISTS `timer_app` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `timer_app`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `projects`
--

INSERT INTO `projects` (`id`, `name`, `date`, `user_id`) VALUES
(1, 'todo list', '2014-04-26 22:00:00', 1),
(2, 'project manager', '2014-04-29 11:01:35', 1),
(3, 'pause', '2014-04-27 22:00:00', 1),
(4, 'briefing', '2014-04-27 22:00:00', 1),
(5, 'Victoris2', '2014-04-29 09:26:43', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `times`
--

CREATE TABLE IF NOT EXISTS `times` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `startUnix` varchar(255) NOT NULL,
  `stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stopUnix` varchar(255) NOT NULL,
  `unixDiff` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `times`
--

INSERT INTO `times` (`id`, `project_id`, `start`, `startUnix`, `stop`, `stopUnix`, `unixDiff`, `date`, `user_id`) VALUES
(1, 4, '2014-04-29 11:47:59', '1398764879', '2014-04-29 11:48:04', '1398764884', '5', '2014-04-29 09:48:04', 1),
(2, 4, '2014-04-28 23:22:40', '1398720160', '2014-04-28 23:22:55', '1398720175', '3315', '0000-00-00 00:00:00', 1),
(3, 4, '2014-04-29 12:17:00', '1398766620', '2014-04-29 12:17:05', '1398766625', '5', '2014-04-29 10:17:05', 1),
(4, 4, '2014-04-29 12:45:29', '1398768329', '2014-04-29 12:45:43', '1398768343', '15', '2014-04-29 10:45:43', 1),
(5, 4, '2014-04-29 12:52:30', '1398768750', '2014-04-29 12:52:40', '1398768760', '11', '2014-04-29 10:52:41', 1),
(6, 4, '2014-04-29 12:53:12', '1398768792', '2014-04-29 12:53:19', '1398768799', '8', '2014-04-29 10:53:19', 1),
(7, 4, '2014-04-29 13:01:56', '1398769316', '2014-04-29 13:02:04', '1398769324', '8', '2014-04-29 11:02:04', 1),
(8, 4, '2014-04-29 13:02:30', '1398769350', '2014-04-29 13:02:45', '1398769365', '16', '2014-04-29 11:02:46', 1),
(9, 1, '2014-04-29 13:46:07', '1398771967', '2014-04-29 13:46:21', '1398771981', '15', '2014-04-29 11:46:21', 1),
(10, 4, '2014-04-29 13:47:25', '1398772045', '2014-04-29 13:47:27', '1398772047', '3', '2014-04-29 11:47:27', 1),
(11, 4, '2014-04-29 14:58:31', '1398776311', '2014-04-29 14:58:34', '1398776314', '4', '2014-04-29 12:58:34', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created`, `modified`, `user_status_id`) VALUES
(1, 'emil', 'db43bbbd4f206b51b6362bf9846489585a6d2491', 'admin', '2014-04-28 00:00:00', '2014-04-28 00:00:00', 0),
(2, 'emaran', 'db43bbbd4f206b51b6362bf9846489585a6d2491', 'admin', '2014-04-29 11:36:32', '2014-04-29 11:36:32', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
