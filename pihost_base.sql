-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: mysql3.iq.pl
-- Generation Time: Nov 04, 2011 at 07:29 AM
-- Server version: 5.0.91
-- PHP Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pihost_base`
--

-- --------------------------------------------------------

--
-- Table structure for table `desk_fields`
--

CREATE TABLE IF NOT EXISTS `desk_fields` (
  `id` bigint(20) NOT NULL auto_increment,
  `uid` bigint(20) NOT NULL,
  `tid` bigint(20) NOT NULL,
  `value` text collate utf8_polish_ci NOT NULL,
  `item_index` bigint(30) NOT NULL,
  `category` int(11) NOT NULL,
  `name` varchar(200) collate utf8_polish_ci NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `item_index` (`item_index`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `desk_fields`
--

-- --------------------------------------------------------

--
-- Table structure for table `desk_field_types`
--

CREATE TABLE IF NOT EXISTS `desk_field_types` (
  `id` bigint(20) NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `fields` text collate utf8_polish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `desk_field_types`
--

-- --------------------------------------------------------

--
-- Table structure for table `desk_files`
--

CREATE TABLE IF NOT EXISTS `desk_files` (
  `id` bigint(20) NOT NULL auto_increment,
  `uid` bigint(20) NOT NULL,
  `filename` varchar(200) collate utf8_polish_ci NOT NULL,
  `name` varchar(200) collate utf8_polish_ci NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `desk_files`
--

-- --------------------------------------------------------

--
-- Table structure for table `desk_users`
--

CREATE TABLE IF NOT EXISTS `desk_users` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(200) collate utf8_polish_ci NOT NULL,
  `pass` varchar(100) collate utf8_polish_ci NOT NULL,
  `email` varchar(200) collate utf8_polish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `name` varchar(200) collate utf8_polish_ci NOT NULL,
  `active` int(11) NOT NULL,
  `link` bigint(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `desk_users`
--

INSERT INTO `desk_users` (`id`, `login`, `pass`, `email`, `status`, `name`, `active`, `link`) VALUES
(1, 'admin', '7f8af2989cf9051beb9cf6ce19fbced3b7407b2d', 'spam@pihost.pl', 999, 'System Operator', 1, 0);
