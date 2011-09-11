-- phpMyAdmin SQL Dump
-- version 3.4.4
-- http://www.phpmyadmin.net
--
-- Palvelin: localhost
-- Luontiaika: 11.09.2011 klo 19:49
-- Palvelimen versio: 5.1.56
-- PHP:n versio: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Tietokanta: `lammimt9_ibooker`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `books`
--
-- Luotu: 05.09.2011 klo 18:40
-- Viimeksi päivitetty: 09.09.2011 klo 12:27
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ISBN` varchar(16) NOT NULL,
  `name` varchar(250) NOT NULL,
  `author` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `submit_date` varchar(25) NOT NULL,
  `times_loaned` int(6) NOT NULL,
  `loaned_by` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `loans`
--
-- Luotu: 05.09.2011 klo 18:40
-- Viimeksi päivitetty: 09.09.2011 klo 12:27
--

CREATE TABLE IF NOT EXISTS `loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `loaner_name` varchar(50) NOT NULL,
  `date_loaned` varchar(25) NOT NULL,
  `date_returned` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--
-- Luotu: 07.09.2011 klo 21:22
-- Viimeksi päivitetty: 07.09.2011 klo 21:42
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(32) NOT NULL,
  `password` varchar(100) NOT NULL,
  `password_salt` varchar(50) NOT NULL,
  `created_at` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
