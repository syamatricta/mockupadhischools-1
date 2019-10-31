-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2016 at 06:58 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.4.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `adhischools`
--

-- --------------------------------------------------------

--
-- Table structure for table `adhi_trial_settings`
--

CREATE TABLE IF NOT EXISTS `adhi_trial_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `validity_days` tinyint(2) NOT NULL,
  `quiz_list_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `adhi_trial_settings`
--

INSERT INTO `adhi_trial_settings` (`id`, `validity_days`, `quiz_list_id`, `updated_at`) VALUES
(1, 16, 487, '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
