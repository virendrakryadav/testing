-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2014 at 05:14 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `greencomet_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_user`
--

CREATE TABLE IF NOT EXISTS `gc_dta_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `state_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `weburl` varchar(200) NOT NULL,
  `profileurl` varchar(200) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `user_status` bit(1) NOT NULL DEFAULT b'1',
  `is_verify` bit(1) NOT NULL DEFAULT b'0',
  `user_created_at` datetime NOT NULL,
  `user_updated_at` datetime NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_video` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '1',
  `chat_id` longtext NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `gc_dta_user_contact_idx1` (`state_id`),
  KEY `gc_dta_user_contact_idx2` (`city_id`),
  KEY `gc_dta_user_contact_idx3` (`region_id`),
  KEY `gc_dta_user_contact_codex4` (`country_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `gc_dta_user`
--

INSERT INTO `gc_dta_user` (`user_id`, `firstname`, `lastname`, `email`, `password`, `mobile`, `country_code`, `state_id`, `region_id`, `city_id`, `weburl`, `profileurl`, `zip_code`, `user_status`, `is_verify`, `user_created_at`, `user_updated_at`, `user_image`, `user_video`, `language_id`, `chat_id`) VALUES
(1, 'Test', '', 'test@gmail.com', '1218124dfc3909b2c2202454453dd535', '8985858458', 'BS', 5, 6, 9, 'www.test.com', 'www.profile.com/profile', '35445', '1', '1', '2014-01-11 00:00:00', '0000-00-00 00:00:00', '', '', 1, '{"chat_id_1":["asdasdasd","Skype"],"chat_id_2":["asdasdas","Gmail"],"chat_id_3":["sadqwqwe","Yahoo"],"chat_id_4":["asdasd","Skype"],"chat_id_5":["asdasdasdas","Gmail"],"chat_id_6":["asdzxccxzc","Outlook"]}'),
(8, 'manoj', 'sharma', 'test@test.com', '3b863dbf234d9279e7a1eadc6c90b4ba', '9639639633', 'IN', 1, 2, 5, '', '', '303030', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 1, ''),
(24, 'mukul', 'medatwal', 'mukul@gmail.com', '03abbb08cc5ce43fa169fb7910d3345a', '12358965412', 'BS', 5, 6, 9, '', '', '303007', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 1, ''),
(26, 'test', '', 'test@test1.com', '03abbb08cc5ce43fa169fb7910d3345a', '5645656565656', 'AA', 2, 5, 10, '', '', '302021', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 1, ''),
(27, 'Manoj', 'Sharma', 'manoj@manoj.com', '0ae5f0b487e8966576b458043cb547c1', '9983950555', 'BS', 5, 6, 9, '', '', '302021', '1', '1', '2014-01-15 03:58:30', '0000-00-00 00:00:00', '', '', 1, ''),
(29, 'Test ', 'New', 'testnew@gmail.com', '1218124dfc3909b2c2202454453dd535', '54345358689389', 'BS', 5, 6, 9, '', '', '25425', '1', '1', '2014-01-19 21:57:47', '0000-00-00 00:00:00', '5749-ironman.jpg', '5749-test2.mp4', 1, ''),
(30, 'Rashmi', 'Singh', 'rashmis@aaiplgroup.com', 'e38689674e914d9fc0c9244bc464f6b5', '9983950555', 'IN', 1, 2, 5, '', '', '302025', '1', '1', '2014-01-21 23:32:26', '0000-00-00 00:00:00', '', '7224-4.png', 1, ''),
(34, 'mukul111', 'medatwal', 'mukul111@gmail.com', 'a@1234', '354654768945', 'AA', 2, 5, 10, '', '', '303007', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 1, ''),
(35, 'mukul1111', 'medatwal2', 'mukul11111@gmail.com', '03abbb08cc5ce43fa169fb7910d3345a', '456456456456', 'AA', 2, 5, 10, '', '', '303007', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 1, ''),
(36, 'new testing', 'medatwal', 'john_smith01@gmail.com', '03abbb08cc5ce43fa169fb7910d3345a', '3455645856', 'BS', 5, 6, 9, '', '', '303007', '1', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', 1, ''),
(37, 'latest', 'user', 'john_mts01@gmail.com', '03abbb08cc5ce43fa169fb7910d3345a', '32442342343', 'BS', 5, 6, 9, '', '', '303007', '1', '0', '2014-01-23 22:26:54', '0000-00-00 00:00:00', '', '', 1, ''),
(38, 'latest2', '', 'asdas@adas.com', '03abbb08cc5ce43fa169fb7910d3345a', '34242423432', 'AA', 2, 5, 10, '', '', '303007', '0', '1', '2014-01-23 22:29:42', '0000-00-00 00:00:00', '', '', 1, '');
