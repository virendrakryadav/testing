-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2014 at 12:33 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `greencomet_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_task`
--

CREATE TABLE IF NOT EXISTS `gc_dta_task` (
  `task_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `creator_user_id` bigint(20) NOT NULL,
  `creator_role` char(1) NOT NULL DEFAULT 't',
  `is_external` bit(1) NOT NULL DEFAULT b'0',
  `language_code` varchar(5) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` varchar(4000) NOT NULL,
  `state` varchar(2) DEFAULT 'o',
  `price` decimal(12,2) DEFAULT NULL,
  `price_currency` varchar(3) DEFAULT 'USD',
  `is_location_region` bit(1) DEFAULT b'1',
  `location_region_id` int(11) DEFAULT NULL,
  `location_street1` varchar(100) DEFAULT NULL,
  `location_street2` varchar(100) DEFAULT NULL,
  `location_country_code` varchar(4) DEFAULT NULL,
  `location_state_id` int(11) DEFAULT NULL,
  `location_city_id` int(11) DEFAULT NULL,
  `location_zipcode` varchar(20) DEFAULT NULL,
  `is_public` bit(1) DEFAULT b'1',
  `bid_start_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bid_close_dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tasker_user_id` bigint(20) DEFAULT NULL,
  `task_finished_on` date DEFAULT NULL,
  `rank` int(2) DEFAULT NULL,
  `attachments` varchar(1000) DEFAULT NULL,
  `work_hrs` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`task_id`),
  KEY `fk_gc_dta_task_created_by` (`created_by`),
  KEY `fk_gc_dta_task_updated_by` (`updated_by`),
  KEY `idx1_gc_dta_task_language_code` (`language_code`,`state`,`location_region_id`),
  KEY `idx2_gc_dta_task_creator_user_id` (`creator_user_id`,`state`,`tasker_user_id`),
  KEY `idx2_gc_dta_task_tasker_user_id` (`tasker_user_id`,`state`,`creator_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `gc_dta_task`
--

INSERT INTO `gc_dta_task` (`task_id`, `creator_user_id`, `creator_role`, `is_external`, `language_code`, `title`, `description`, `state`, `price`, `price_currency`, `is_location_region`, `location_region_id`, `location_street1`, `location_street2`, `location_country_code`, `location_state_id`, `location_city_id`, `location_zipcode`, `is_public`, `bid_start_dt`, `bid_close_dt`, `tasker_user_id`, `task_finished_on`, `rank`, `attachments`, `work_hrs`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`) VALUES
(33, 22, 't', b'0', 'en_us', 'NKNJKNKJ', 'NKNBHBHJBHJBHJBHJBHNJBHBHJ', 'f', '898.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-11 12:32:01', '0000-00-00 00:00:00', NULL, '2016-02-02', NULL, '[{"type":"image","file":"5541\\/22_1392121899_task_uploaded.jpg","upload_on":"2014-02-14 12:33:56"},{"type":"video","file":"5541\\/22_1392121856_task_uploaded.mp4","upload_on":"2014-02-14 12:33:56"}]', '89', '2014-02-11 12:32:01', 22, NULL, NULL, 'a'),
(47, 15, 'p', b'0', 'en_us', 'this was my first task', 'test description', 'f', '100.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-12 11:55:02', '0000-00-00 00:00:00', NULL, '2014-03-02', NULL, '[{"type":"video","file":"9652\\/","upload_on":"2014-02-15 05:02:40"}]', '45', '2014-02-12 11:55:02', 15, NULL, NULL, 'a'),
(59, 13, 't', b'0', 'en_us', 'nhgfhgfgh', 'gvhgfhghfgh', 'f', '456.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 06:45:57', '0000-00-00 00:00:00', NULL, '2015-01-02', NULL, '[{"type":"image","file":"8541\\/13_1392360334_task_uploaded.png","upload_on":"2014-02-14 11:31:46"},{"type":"video","file":"8541\\/13_1392372962_task_uploaded.mp4","upload_on":"2014-02-14 11:31:46"}]', '78', '2014-02-14 06:45:57', 13, '2014-02-14 10:15:31', 13, 'a'),
(60, 24, 'p', b'0', 'en_us', 'Test task', 'This is test description section  ', 'f', '890.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0', '2014-02-14 06:55:06', '0000-00-00 00:00:00', NULL, '2015-03-02', NULL, '[{"type":"image","file":"1569\\/24_1392360728_task_uploaded.jpg","upload_on":"2014-02-14 08:04:09"},{"type":"video","file":"1569\\/24_1392360740_task_uploaded.mp4","upload_on":"2014-02-14 08:04:09"}]', '25', '2014-02-14 06:55:06', 24, '2014-02-14 07:04:09', 24, 'a'),
(70, 24, 'p', b'0', 'en_us', 'test task name for Done by U', 'This is task description  section', 'f', '12324.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 08:28:30', '0000-00-00 00:00:00', NULL, '2014-01-02', NULL, '[{"type":"image","file":"1569\\/24_1392362593_task_uploaded.jpg","upload_on":"2014-02-14 12:12:58"},{"type":"image","file":"1569\\/24_1392373190_task_uploaded.jpg","upload_on":"2014-02-14 12:12:58"},{"type":"image","file":"1569\\/24_1392373200_task_uploaded.jpg","upload_on":"2014-02-14 12:12:58"},{"type":"image","file":"1569\\/24_1392373207_task_uploaded.jpg","upload_on":"2014-02-14 12:12:58"},{"type":"image","file":"1569\\/24_1392373212_task_uploaded.jpg","upload_on":"2014-02-14 12:12:58"},{"type":"video","file":"1569\\/24_1392375134_task_uploaded.mp4","upload_on":"2014-02-14 12:12:58"}]', '123', '2014-02-14 08:28:30', 24, '2014-02-14 08:34:00', 24, 'a'),
(73, 24, 't', b'0', 'en_us', 'test', 'etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e etset setset se se rse se serse seresr e ', 'f', '22344.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 09:11:06', '0000-00-00 00:00:00', NULL, '2014-04-02', NULL, '[{"type":"image","file":"1569\\/24_1392368931_task_uploaded.jpg","upload_on":"2014-02-14 10:11:06"},{"type":"image","file":"1569\\/24_1392368940_task_uploaded.jpg","upload_on":"2014-02-14 10:11:06"},{"type":"image","file":"1569\\/24_1392368957_task_uploaded.jpg","upload_on":"2014-02-14 10:11:06"},{"type":"video","file":"1569\\/","upload_on":"2014-02-14 10:11:06"}]', '34', '2014-02-14 09:11:06', 24, NULL, NULL, 'a'),
(75, 24, 't', b'0', 'en_us', '                               .   ', '                                                                                        .', 'f', '1.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 09:21:57', '0000-00-00 00:00:00', NULL, '2014-05-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 10:21:57"}]', '0.1', '2014-02-14 09:21:57', 24, NULL, NULL, 'a'),
(77, 24, 't', b'0', 'en_us', 'reet', 'eterterte retretre e tert ert ertret', 'f', '3423.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 09:24:08', '0000-00-00 00:00:00', NULL, '2014-05-02', NULL, '[{"type":"image","file":"1569\\/24_1392369786_task_uploaded.jpg","upload_on":"2014-02-14 10:24:35"},{"type":"image","file":"1569\\/24_1392369791_task_uploaded.jpg","upload_on":"2014-02-14 10:24:35"},{"type":"image","file":"1569\\/24_1392369797_task_uploaded.jpg","upload_on":"2014-02-14 10:24:35"},{"type":"video","file":"1569\\/24_1392369816_task_uploaded.mp4","upload_on":"2014-02-14 10:24:35"}]', '45', '2014-02-14 09:24:08', 24, '2014-02-14 09:24:34', 24, 'a'),
(78, 24, 't', b'0', 'en_us', 'rewrwer', 'werewrewrewr', 'f', '121.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 10:30:16', '0000-00-00 00:00:00', NULL, '2014-12-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 11:30:16"}]', '3', '2014-02-14 10:30:16', 24, NULL, NULL, 'a'),
(79, 24, 't', b'0', 'en_us', '34324', '234234235646 546456546', 'f', '234234.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 10:30:49', '0000-00-00 00:00:00', NULL, '2015-01-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 11:30:49"}]', '56', '2014-02-14 10:30:49', 24, NULL, NULL, 'a'),
(80, 24, 't', b'0', 'en_us', 'ghjjghjgj j  jgjgj  jgj', '56456jgj g gjgjgj ', 'f', '675675.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 10:31:33', '0000-00-00 00:00:00', NULL, '2015-02-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 11:31:33"}]', '67', '2014-02-14 10:31:33', 24, NULL, NULL, 'a'),
(81, 24, 't', b'0', 'en_us', 'TRYTRYTRY', 'RTYTRYTRYTRY', 'f', '435435.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 10:32:03', '0000-00-00 00:00:00', NULL, '2015-09-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 11:32:03"}]', '67', '2014-02-14 10:32:03', 24, NULL, NULL, 'a'),
(82, 24, 't', b'0', 'en_us', 'JTGJGJGHJ', 'GJGHJGHJ G GJGJGJ', 'f', '56546.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 10:32:47', '0000-00-00 00:00:00', NULL, '2015-08-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 11:32:47"}]', '56', '2014-02-14 10:32:47', 24, NULL, NULL, 'a'),
(83, 24, 't', b'0', 'en_us', '56546', 'GHFGHFGHF FG FGHFG FGH', 'f', '65466546.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 10:33:20', '0000-00-00 00:00:00', NULL, '2014-07-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 11:33:20"}]', '545', '2014-02-14 10:33:20', 24, NULL, NULL, 'a'),
(84, 24, 't', b'0', 'en_us', 'ETETERT', 'ERTRET ETRETRET RE', 'f', '45435.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 10:34:03', '0000-00-00 00:00:00', NULL, '2014-12-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 11:34:03"}]', '3', '2014-02-14 10:34:03', 24, NULL, NULL, 'a'),
(87, 22, 'p', b'0', 'en_us', 'NKNJKNKJ', 'ghjgjghjkg', 'f', '898.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 10:59:26', '0000-00-00 00:00:00', NULL, '2015-02-02', NULL, '[{"type":"video","file":"5541\\/","upload_on":"2014-02-14 12:23:14"}]', '89', '2014-02-14 10:59:26', 22, '2014-02-14 10:59:41', 22, 'a'),
(89, 22, 'p', b'0', 'en_us', 'fgyhjfghj', '           vhjfghjfghjfghj', 'f', '898.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 11:03:05', '0000-00-00 00:00:00', NULL, '2014-12-02', NULL, '[{"type":"video","file":"5541\\/","upload_on":"2014-02-14 12:03:19"}]', '89', '2014-02-14 11:03:05', 22, '2014-02-14 11:03:19', 22, 'a'),
(90, 24, 't', b'0', 'en_us', 'TEST TRTRT', 'RTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGH RTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGH DFDSFFDSFDSF  DFDSFGSDFDSFE FGDFDSDSGERTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGHRTERTERTERT TERTERTNNVNFG HTHFGHFGH FGHFGH  FGHFGH FGH FGHF GH FHFH  FHFGH FGHF F FHFGHFGH DDRTR DGDFHDH FHFH HFGH FGG F HHJJFGJ DRTERT FGHFGHFGH DSFFDSDSFDSFEFS CXBGTUYIHJGHJ GHJGHJTYUJTFHFHFGH HJHJ GGHJGHJ GHJGH GHJGHJ GHKG GHAWE ET NVNGHGH TYRTERTE QRT RYYTYTYTURT TRTR TR TYRTYRTY HFHFGH YRTYR GHJGHJ WRWERW GDFGD DFGRTYEWE TRT G TRET', 'f', '9999999999.99', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 11:04:56', '0000-00-00 00:00:00', NULL, '2015-09-02', NULL, '[{"type":"image","file":"1569\\/24_1392375788_task_uploaded.jpg","upload_on":"2014-02-14 12:04:56"},{"type":"image","file":"1569\\/24_1392375793_task_uploaded.jpg","upload_on":"2014-02-14 12:04:56"},{"type":"image","file":"1569\\/24_1392375798_task_uploaded.jpg","upload_on":"2014-02-14 12:04:56"},{"type":"image","file":"1569\\/24_1392375804_task_uploaded.jpg","upload_on":"2014-02-14 12:04:56"},{"type":"image","file":"1569\\/24_1392375809_task_uploaded.jpg","upload_on":"2014-02-14 12:04:56"},{"type":"image","file":"1569\\/24_1392375815_task_uploaded.jpg","upload_on":"2014-02-14 12:04:56"},{"type":"image","file":"1569\\/24_1392375819_task_uploaded.jpg","upload_on":"2014-02-14 12:04:56"},{"type":"image","file":"1569\\/24_1392375825_task_uploaded.jpg","upload_on":"2014-02-14 12:04:56"},{"type":"video","file":"1569\\/24_1392375831_task_uploaded.mp4","upload_on":"2014-02-14 12:04:56"}]', '12', '2014-02-14 11:04:56', 24, NULL, NULL, 'a'),
(91, 22, 'p', b'0', 'en_us', 'NKNJKNKJ', 'ghjfvgyhjfghj', 'f', '898.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 11:06:28', '0000-00-00 00:00:00', NULL, '2014-12-02', NULL, '[{"type":"video","file":"5541\\/","upload_on":"2014-02-14 12:06:28"}]', '89', '2014-02-14 11:06:28', 22, NULL, NULL, 'a'),
(92, 24, 't', b'0', 'en_us', '         G', 'G', 'f', '2242.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-14 11:07:49', '0000-00-00 00:00:00', NULL, '2014-12-02', NULL, '[{"type":"video","file":"1569\\/","upload_on":"2014-02-14 12:23:28"}]', '43', '2014-02-14 11:07:49', 24, NULL, NULL, 'a'),
(95, 28, 't', b'0', 'en_us', 'tasking ', 'firstv task ever', 'f', '123123.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'0', '2014-02-14 11:16:56', '0000-00-00 00:00:00', NULL, '2015-07-02', NULL, '[{"type":"image","file":"8171\\/28_1392445869_task_uploaded.png","upload_on":"2014-02-15 09:32:45"},{"type":"video","file":"8171\\/","upload_on":"2014-02-15 09:32:45"}]', '45', '2014-02-14 11:16:56', 28, NULL, NULL, 'a'),
(96, 28, 't', b'0', 'en_us', 'my first task', 'this is my first task', 'f', '343.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-15 10:10:32', '0000-00-00 00:00:00', NULL, '2014-04-02', NULL, '[{"type":"image","file":"8171\\/28_1392458983_task_uploaded.jpg","upload_on":"2014-02-15 11:40:53"},{"type":"video","file":"8171\\/28_1392460529_task_uploaded.mp4","upload_on":"2014-02-15 11:40:53"}]', '32', '2014-02-15 10:10:32', 28, NULL, NULL, 'a'),
(97, 28, 't', b'0', 'en_us', 'online watch selling ', 'this project is use to selling luxury watches and view prices and images with all specifications', 'f', '560.00', 'USD', b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', '2014-02-15 10:47:20', '0000-00-00 00:00:00', NULL, '2014-09-11', NULL, '[{"type":"image","file":"8171\\/28_1392461084_task_uploaded.jpg","upload_on":"2014-02-15 11:47:20"},{"type":"image","file":"8171\\/28_1392461091_task_uploaded.jpg","upload_on":"2014-02-15 11:47:20"},{"type":"image","file":"8171\\/28_1392461106_task_uploaded.jpg","upload_on":"2014-02-15 11:47:20"},{"type":"video","file":"8171\\/","upload_on":"2014-02-15 11:47:20"}]', '40', '2014-02-15 10:47:20', 28, NULL, NULL, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_task_category`
--

CREATE TABLE IF NOT EXISTS `gc_dta_task_category` (
  `task_id` bigint(20) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` bigint(20) DEFAULT NULL,
  `status` char(1) DEFAULT 'o',
  PRIMARY KEY (`language_code`,`category_id`,`task_id`),
  KEY `fk_task_category_task_id` (`task_id`),
  KEY `fk_task_category_category_id` (`category_id`),
  KEY `fk_task_category_created_by` (`created_by`),
  KEY `fk_task_category_updated_by` (`updated_by`),
  KEY `idx_gc_dta_task_lang_catg_status` (`language_code`,`category_id`,`status`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_task_reference`
--

CREATE TABLE IF NOT EXISTS `gc_dta_task_reference` (
  `task_id` bigint(20) NOT NULL,
  `contact_id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `verification_status` char(1) DEFAULT 'p',
  `verified_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `verified_by` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `remarks` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  `ref_email` varchar(100) DEFAULT NULL,
  `ref_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`task_id`,`contact_id`),
  KEY `fk_task_reference_verified_by` (`verified_by`),
  KEY `fk_task_reference_created_by` (`created_by`),
  KEY `fk_task_reference_updated_by` (`updated_by`),
  KEY `idx1_gc_dta_task_reference_verification_status` (`verification_status`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_dta_task_reference`
--

INSERT INTO `gc_dta_task_reference` (`task_id`, `contact_id`, `name`, `verification_status`, `verified_on`, `verified_by`, `rank`, `remarks`, `created_at`, `created_by`, `updated_at`, `updated_by`, `status`, `ref_email`, `ref_phone`) VALUES
(33, '', 'HJBGHJ', 'p', '2014-02-11 12:32:01', NULL, NULL, NULL, '2014-02-11 12:32:01', 22, '2014-02-14 11:07:28', 22, 'a', 'HKJH@FCGF.BH', '5454545454545'),
(47, '', 'tony', 'p', '2014-02-12 11:55:02', NULL, NULL, NULL, '2014-02-12 11:55:02', 15, '2014-02-15 04:02:41', 15, 'a', 'tony@gmail.com', '91898989898989'),
(59, '', 'hjgj', 'p', '2014-02-14 06:45:57', NULL, NULL, NULL, '2014-02-14 06:45:57', 13, '2014-02-14 10:15:31', 13, 'a', 'hjhg@fcxgf.com', '564654654564646'),
(60, '', 'chittii', 'p', '2014-02-14 06:55:06', NULL, NULL, NULL, '2014-02-14 06:55:06', 24, '2014-02-14 07:04:09', 24, 'a', 'chit@gmail.com', '8955530448'),
(70, '', 'test name', 'p', '2014-02-14 08:28:30', NULL, NULL, NULL, '2014-02-14 08:28:30', 24, '2014-02-14 08:34:00', 24, 'a', 'er@gma.cm', '8964326789'),
(73, '', 'frwfsfsdf', 'c', '2014-02-14 09:11:06', NULL, 7, 'qweqwqweweqe', '2014-02-14 09:11:06', 24, NULL, NULL, 'a', 'fg@mail.com', '85686546435'),
(75, '', '                               .', 'p', '2014-02-14 09:21:57', NULL, NULL, NULL, '2014-02-14 09:21:57', 24, NULL, NULL, 'a', 'k.j@k.com', '          7897675675'),
(77, '', 'rtert', 'p', '2014-02-14 09:24:08', NULL, NULL, NULL, '2014-02-14 09:24:08', 24, '2014-02-14 09:24:34', 24, 'a', 'tt@gmail.com', '98757657567'),
(78, '', 'adasdas', 'p', '2014-02-14 10:30:16', NULL, NULL, NULL, '2014-02-14 10:30:16', 24, NULL, NULL, 'a', 'asd@mail.com', '3454354355'),
(79, '', '234234', 'p', '2014-02-14 10:30:49', NULL, NULL, NULL, '2014-02-14 10:30:49', 24, NULL, NULL, 'a', '2343@mail.com', '8967856756'),
(80, '', 'ututyu', 'p', '2014-02-14 10:31:33', NULL, NULL, NULL, '2014-02-14 10:31:33', 24, NULL, NULL, 'a', 'tyu@MAIL.COM', '43535354545555'),
(81, '', 'RTYRTY', 'p', '2014-02-14 10:32:03', NULL, NULL, NULL, '2014-02-14 10:32:03', 24, NULL, NULL, 'a', 'ERT@GMAIL.COM', '89789789789'),
(82, '', 'HFGHFGH', 'p', '2014-02-14 10:32:47', NULL, NULL, NULL, '2014-02-14 10:32:47', 24, NULL, NULL, 'a', 'TYRY@GMAIL.COM', '968678768768'),
(83, '', 'TYRYRYRTYTRY', 'p', '2014-02-14 10:33:20', NULL, NULL, NULL, '2014-02-14 10:33:20', 24, NULL, NULL, 'a', 'TYRY@GMAIL.COM', '75474574555'),
(84, '', 'DGDFGD', 'p', '2014-02-14 10:34:03', NULL, NULL, NULL, '2014-02-14 10:34:03', 24, NULL, NULL, 'a', 'SWR@GMAIL.COM', '34234234444'),
(87, '', 'HJBGHJ', 'p', '2014-02-14 10:59:26', NULL, NULL, NULL, '2014-02-14 10:59:26', 22, '2014-02-14 10:59:41', 22, 'a', 'HKJH@FCGF.BH', '5454545454545'),
(89, '', 'HJBGHJ', 'p', '2014-02-14 11:03:05', NULL, NULL, NULL, '2014-02-14 11:03:05', 22, '2014-02-14 11:03:19', 22, 'a', 'HKJH@FCGF.BH', '5454545454545'),
(90, '', '6786786', 'p', '2014-02-14 11:04:56', NULL, NULL, NULL, '2014-02-14 11:04:56', 24, NULL, NULL, 'a', 'YUII@GMAIL.COM', '8768678678678'),
(91, '', 'HJBGHJ', 'p', '2014-02-14 11:06:28', NULL, NULL, NULL, '2014-02-14 11:06:28', 22, NULL, NULL, 'a', 'HKJH@FCGF.BH', '5454545454545'),
(92, '', 'SFSDFSDF', 'p', '2014-02-14 11:07:49', NULL, NULL, NULL, '2014-02-14 11:07:49', 24, '2014-02-14 11:09:00', 24, 'a', 'GH@GMAIL.COM', '735223423342'),
(95, '', 'sfdsf', 'c', '2014-02-14 11:16:56', NULL, 6, 'dgdfgdfgdffdgdfgdfgdfgg', '2014-02-14 11:16:56', 28, '2014-02-14 11:19:52', 28, 'a', 'asdasdas@asd.com', '96584135456'),
(96, '', 'herry', 'p', '2014-02-15 10:10:32', NULL, NULL, NULL, '2014-02-15 10:10:32', 28, '2014-02-15 10:33:49', 28, 'a', 'jerryherry@gmail.com', '0124587125635'),
(97, '', 'kim', 'p', '2014-02-15 10:47:20', NULL, NULL, NULL, '2014-02-15 10:47:20', 28, NULL, NULL, 'a', 'kim@gmail.com', '95863214785');

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_task_speciality`
--

CREATE TABLE IF NOT EXISTS `gc_dta_task_speciality` (
  `task_id` bigint(20) NOT NULL,
  `speciality_id` int(11) NOT NULL,
  `is_required` bit(1) DEFAULT b'1',
  `required_rank` int(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`task_id`,`speciality_id`),
  KEY `fk_task_speciality_created_by` (`created_by`),
  KEY `fk_task_speciality_updated_by` (`updated_by`),
  KEY `idx1_gc_dta_task_speciality_id` (`speciality_id`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_user`
--

CREATE TABLE IF NOT EXISTS `gc_dta_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_type` char(1) DEFAULT 'g',
  `is_verified` bit(1) NOT NULL DEFAULT b'0',
  `gender` char(1) DEFAULT NULL,
  `marrital_status` char(2) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `tagline` varchar(200) DEFAULT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `preferred_language_code` varchar(5) NOT NULL,
  `country_code` char(2) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `state_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `region_id` int(11) DEFAULT NULL,
  `region_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `city_id` int(11) DEFAULT NULL,
  `city_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `zipcode` varchar(20) NOT NULL DEFAULT '',
  `profile_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `profile_info` varchar(2000) DEFAULT NULL,
  `contact_info` varchar(2000) NOT NULL,
  `billaddr_street1` varchar(100) DEFAULT NULL,
  `billaddr_street2` varchar(100) DEFAULT NULL,
  `billaddr_city_id` int(11) DEFAULT NULL,
  `billaddr_city_isprivate` bit(1) DEFAULT NULL,
  `billaddr_region_id` int(11) DEFAULT NULL,
  `billaddr_region_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `billaddr_state_id` int(11) DEFAULT NULL,
  `billaddr_state_ispublic` bit(1) DEFAULT NULL,
  `billaddr_country_code` char(2) DEFAULT NULL,
  `billaddr_zipcode` varchar(20) DEFAULT NULL,
  `geoaddr_issame` bit(1) NOT NULL DEFAULT b'1',
  `geoaddr_street1` varchar(100) DEFAULT NULL,
  `geoaddr_street2` varchar(100) DEFAULT NULL,
  `geoaddr_city_id` int(11) DEFAULT NULL,
  `geoaddr_city_isprivate` bit(1) DEFAULT NULL,
  `geoaddr_state_id` int(11) DEFAULT NULL,
  `geoaddr_state_ispublic` bit(1) DEFAULT NULL,
  `geoaddr_region_id` int(11) DEFAULT NULL,
  `geoaddr_region_ispublic` bit(1) NOT NULL DEFAULT b'1',
  `geoaddr_zipcode` varchar(20) DEFAULT NULL,
  `geoaddr_country_code` char(2) DEFAULT NULL,
  `about_me` varchar(4000) DEFAULT NULL,
  `work_start_year` int(4) DEFAULT NULL,
  `prefereces_setting` varchar(2000) DEFAULT NULL,
  `timezone` varchar(20) NOT NULL,
  `startup_page` varchar(100) NOT NULL,
  `notify_by_sms` tinyint(4) NOT NULL DEFAULT '0',
  `notify_by_email` tinyint(4) NOT NULL DEFAULT '1',
  `notify_by_chat` tinyint(4) NOT NULL DEFAULT '1',
  `notify_by_fb` tinyint(4) NOT NULL DEFAULT '1',
  `notify_by_tw` tinyint(4) NOT NULL DEFAULT '1',
  `notify_by_gplus` bit(1) NOT NULL DEFAULT b'1',
  `credit_account_setting` varchar(2000) DEFAULT NULL,
  `task_last_post_at` datetime DEFAULT NULL,
  `task_post_cnt` int(11) DEFAULT '0',
  `task_post_total_price` int(11) DEFAULT '0',
  `task_post_total_hours` int(11) DEFAULT '0',
  `task_post_cancel_cnt` int(11) DEFAULT '0',
  `task_post_cancel_price` int(11) DEFAULT '0',
  `task_post_cancel_hours` int(11) DEFAULT '0',
  `task_post_rank` int(11) DEFAULT '0',
  `task_post_review_cnt` int(11) DEFAULT '0',
  `task_last_done_at` datetime DEFAULT NULL,
  `task_done_cnt` int(11) DEFAULT '0',
  `task_pending_cnt` int(11) DEFAULT '0',
  `task_done_total_price` int(11) DEFAULT '0',
  `task_done_total_hours` int(11) DEFAULT '0',
  `task_done_rank` int(11) DEFAULT '0',
  `task_done_review_cnt` int(11) DEFAULT '0',
  `connections_cnt` int(11) DEFAULT '0',
  `references_cnt` int(11) DEFAULT '0',
  `group_cnt` int(11) DEFAULT '0',
  `fb_isconnected` bit(1) NOT NULL DEFAULT b'1',
  `tw_isconnected` bit(1) NOT NULL DEFAULT b'1',
  `gplus_isconnected` bit(1) NOT NULL DEFAULT b'1',
  `in_isconnected` bit(1) NOT NULL DEFAULT b'1',
  `social_sites_auth_dtl` varchar(2000) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `last_accessed_at` timestamp NULL DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  `profile_folder_name` varchar(20) DEFAULT NULL,
  `instant_available` bit(1) DEFAULT b'1',
  PRIMARY KEY (`user_id`),
  KEY `gc_dta_user_contact_idx1` (`state_id`),
  KEY `gc_dta_user_contact_idx2` (`city_id`),
  KEY `gc_dta_user_contact_idx3` (`region_id`),
  KEY `gc_dta_user_contact_codex4` (`country_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `gc_dta_user`
--

INSERT INTO `gc_dta_user` (`user_id`, `user_type`, `is_verified`, `gender`, `marrital_status`, `firstname`, `lastname`, `password`, `tagline`, `date_of_birth`, `preferred_language_code`, `country_code`, `state_id`, `state_ispublic`, `region_id`, `region_ispublic`, `city_id`, `city_ispublic`, `zipcode`, `profile_ispublic`, `profile_info`, `contact_info`, `billaddr_street1`, `billaddr_street2`, `billaddr_city_id`, `billaddr_city_isprivate`, `billaddr_region_id`, `billaddr_region_ispublic`, `billaddr_state_id`, `billaddr_state_ispublic`, `billaddr_country_code`, `billaddr_zipcode`, `geoaddr_issame`, `geoaddr_street1`, `geoaddr_street2`, `geoaddr_city_id`, `geoaddr_city_isprivate`, `geoaddr_state_id`, `geoaddr_state_ispublic`, `geoaddr_region_id`, `geoaddr_region_ispublic`, `geoaddr_zipcode`, `geoaddr_country_code`, `about_me`, `work_start_year`, `prefereces_setting`, `timezone`, `startup_page`, `notify_by_sms`, `notify_by_email`, `notify_by_chat`, `notify_by_fb`, `notify_by_tw`, `notify_by_gplus`, `credit_account_setting`, `task_last_post_at`, `task_post_cnt`, `task_post_total_price`, `task_post_total_hours`, `task_post_cancel_cnt`, `task_post_cancel_price`, `task_post_cancel_hours`, `task_post_rank`, `task_post_review_cnt`, `task_last_done_at`, `task_done_cnt`, `task_pending_cnt`, `task_done_total_price`, `task_done_total_hours`, `task_done_rank`, `task_done_review_cnt`, `connections_cnt`, `references_cnt`, `group_cnt`, `fb_isconnected`, `tw_isconnected`, `gplus_isconnected`, `in_isconnected`, `social_sites_auth_dtl`, `created_at`, `last_updated_at`, `last_accessed_at`, `status`, `profile_folder_name`, `instant_available`) VALUES
(1, 'g', b'1', 'M', NULL, 'mukul', 'medawat', 'a22ed9cf60d4f0b6fb68f89e2c3e22be', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"phs":[{"p":"9610040782","type":"p"},{"p":"7737766554","type":"s"}],"emails":[{"e":"mukul22medatwal@gmail.com","type":"p"},{"e":"222@adsd.com","type":"s"}],"chatids":[{"id":"asdasdasd","type":"Skype"},{"id":"asdasdasd","type":"Skype"}],"socialids":[{"id":"adasd","type":"Facebook"},{"id":"asdasd","type":"Facebook"},{"id":"asdasds","type":"Facebook"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-27 04:27:01', '2014-01-27 04:27:01', '2014-01-27 04:27:01', 'a', '5863', b'1'),
(6, 'g', b'1', NULL, NULL, 'Mukul2', 'jiji', '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '', 'Test New', 'dsrfgsdergdserg', 16, b'1', 14, b'1', 8, b'1', 'IN', '20545', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'0', '', '', NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-27 06:23:15', '2014-01-27 08:32:10', NULL, 'a', '8745', b'1'),
(7, 'g', b'1', NULL, NULL, '', NULL, '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-27 06:24:13', NULL, NULL, 'a', '9856', b'1'),
(8, 'g', b'1', NULL, NULL, '', NULL, '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', 'IN', 8, b'1', 14, b'1', 16, b'1', '', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-27 12:17:25', NULL, NULL, 'a', '8521', b'1'),
(10, 'g', b'1', NULL, NULL, '', NULL, '7e53510dd0a898cf2e26b0cc654ac23d', NULL, NULL, '', 'IN', 8, b'1', 14, b'1', 16, b'1', '', b'1', '', '{"emails":[{"e":"archana@gmail.com","type":"p"}]}', NULL, NULL, 16, NULL, 14, b'1', 8, NULL, 'IN', NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-27 12:32:31', NULL, NULL, 'a', '1236', b'1'),
(11, 'g', b'1', NULL, NULL, 'Test', 'Lastname1', '1218124dfc3909b2c2202454453dd535', NULL, NULL, '', 'IN', 8, b'1', 14, b'1', 16, b'1', '', b'1', '', '{"phs":[{"p":"96100000000","type":"p"}],"emails":[{"e":"test@gmail.com","type":"p"}],"chatids":[{"id":"abc","type":"Skype"}],"socialids":[{"id":"aaaa","type":"Facebook"}]}', 'Test Add', 'Test', 5, b'1', 2, b'1', 1, b'1', 'IN', '3', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'0', '', '', NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-27 12:46:39', '2014-01-27 12:55:42', NULL, 'a', '5214', b'1'),
(12, 'g', b'1', NULL, NULL, '', '', '1218124dfc3909b2c2202454453dd535', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"phs":[{"p":"3454534534535","type":"p"},{"p":"11111111111","type":"s"}],"emails":[{"e":"mukul3@gmail.com","type":"p"}],"chatids":[{"id":"xZXZx","type":"Skype"}],"socialids":[{"id":"dfgdgf","type":"Google+"},{"id":"dfggf","type":"Flicker"},{"id":"gdfgdfg","type":"Orkut"},{"id":"dfgdfg","type":"Orkut"},{"id":"dfgdfgdf","type":"Google+"},{"id":"gdgdfgdf","type":"Facebook"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-28 07:24:33', NULL, NULL, 'a', '8965', b'1'),
(13, 'g', b'1', NULL, NULL, 'Amit', 'Singh', '1218124dfc3909b2c2202454453dd535', 'Tag line11', NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '{"pic":"8541\\/13_1392359264_uploaded.jpg","video":"","url":"","weburl":"","url_ispublic":"0","weburl_ispublic":"0","video_ispublic":"","pic_ispublic":""}', '{"emails":[{"e":"testmew@gmail.com","type":"p"}],"chatids":[{"id":"ll","type":"Skype"}]}', 'Test Add1', 'Test Add2', 5, b'0', 2, b'1', 1, b'0', 'IN', '20545', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'0', '', '', '{"aboutme":"Description Description Description","certificateVal":[{"certificate":"Certificate1","certificateidof":"1940"},{"certificate":"Certificate2","certificateidof":"1948"}]}', 1955, '{"contact_by":"","ref_check_by":"","work_hrs":[[{"day":"fri","hrs":"06:40-10:40"},{"day":"sat","hrs":"06:40-10:40"},{"day":"sun","hrs":"06:40-10:40"}]]}', 'Africa/Abidjan', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-28 12:14:50', '2014-02-03 12:16:55', NULL, 'a', '8541', b'1'),
(14, 'g', b'1', NULL, NULL, 'test name', 'test last name', '9656ea4c8792e9528d8015e96856e803', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"phs":[{"p":"8966423418","type":"p"},{"p":"98777634209","type":"s"}],"emails":[{"e":"test1@mail.com","type":"p"},{"e":"test23@mail.com3","type":"s"}],"chatids":[{"id":" cc","type":"Gmail"},{"id":"skype@gmail.com","type":"Skype"},{"id":"gmail@gmail.com","type":"Skype"},{"id":"yahoo@yahoo.com","type":"Skype"},{"id":"outlook@gmail.com","type":"Skype"}],"socialids":[{"id":"Orkut@gmail. ","type":"Facebook"},{"id":"facebook@gmail.com","type":"Facebook"},{"id":"flicker@gmail.com","type":"Facebook"},{"id":"Gplus@gmail.com","type":"Flicker"},{"id":"Orkut@gmail.com","type":"Facebook"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-29 03:43:22', '2014-01-29 05:04:26', NULL, 'a', '8521', b'1'),
(15, 'g', b'1', NULL, NULL, 'manoj', 'sharma', 'e38689674e914d9fc0c9244bc464f6b5', 'Race has not finished, I have not won yet !!', NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '{"pic":"9652\\/15_1392458456_uploaded.jpg","video":"","url":"","weburl":"","url_ispublic":"","weburl_ispublic":"","video_ispublic":"","pic_ispublic":""}', '{"chatids":[{"id":"manus299","type":"Skype"}],"socialids":[{"id":"manojs","type":"Flicker"}]}', 'F-1/276', '', 5, b'1', 2, b'1', 1, b'1', 'IN', '302021', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'0', '', '', '{"aboutme":"I am php developer and have 5+ exp.","certificateVal":[{"certificate":"php certification","certificateidof":"2010"},{"certificate":"php certification","certificateidof":"2009"},{"certificate":"php certification","certificateidof":"1940"}]}', 1990, '', 'Asia/Kolkata', 'dashboard', 0, 1, 1, 1, 1, b'0', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-29 03:50:57', '2014-01-29 12:34:30', NULL, 'a', '9652', b'1'),
(16, 'g', b'1', NULL, NULL, '', '', '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"phs":[{"p":"9610040782","type":"p"}],"emails":[{"e":"aditi@gmail.com","type":"p"}],"chatids":[{"id":"asdasd","type":"Yahoo"},{"id":"asass","type":"Gmail"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-01-30 10:28:36', NULL, NULL, 'a', '1563', b'1'),
(17, 'g', b'1', NULL, NULL, '', '', '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', 'IN', 8, b'1', 14, b'1', 16, b'1', '', b'1', '', '{"emails":[{"e":"sadas11@asd.com","type":"p"}]}', NULL, NULL, 16, NULL, 14, b'1', 8, NULL, 'IN', NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-01 11:41:12', NULL, NULL, 'a', '1478', b'1'),
(18, 'g', b'1', NULL, NULL, 'test', 'One', '9656ea4c8792e9528d8015e96856e803', '123211212312', NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"phs":[{"p":"75676756777","type":"p"}],"emails":[{"e":"you1@gmail.com","type":"p"}]}', '11345443++++', '..................................IIIIIIII', 5, b'0', 2, b'0', 1, b'0', 'IN', '1321231', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'0', '', '', '{"aboutme":"","certificateVal":[{"certificate":"131223","certificateidof":"1940"}]}', 2000, '', 'Asia/Tehran', 'dashboard', 0, 0, 1, 0, 0, b'0', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-01 11:43:42', '2014-02-01 13:40:19', NULL, 'a', '2569', b'1'),
(19, 'g', b'1', NULL, NULL, '', '', '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', 'IN', 8, b'1', 14, b'1', 16, b'1', '', b'1', '', '{"emails":[{"e":"mmmmm@gmail.com","type":"p"}]}', NULL, NULL, 16, NULL, 14, b'1', 8, NULL, 'IN', NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-01 11:44:14', NULL, NULL, 'a', '2541', b'1'),
(20, 'g', b'1', NULL, NULL, '', '', '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"emails":[{"e":"archana23@gmail.com","type":"p"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-01 11:47:11', NULL, NULL, 'a', '3256', b'1'),
(21, 'g', b'1', NULL, NULL, 'muuk', 'ghjgh', '03abbb08cc5ce43fa169fb7910d3345a', '', NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"phs":[{"p":"1111111111","type":"p"},{"p":"11111111111","type":"s"}],"emails":[{"e":"mukul6@gmail.com","type":"p"},{"e":"mukul6@gmail.com1","type":"s"}],"chatids":[{"id":"test","type":"Skype"},{"id":"test","type":"Gmail"},{"id":"test","type":"Outlook"},{"id":"test","type":"Yahoo"}],"socialids":[{"id":"qqqq","type":"Facebook"},{"id":"qqqq","type":"Flicker"},{"id":"qqq","type":"Facebook"},{"id":"qqqq","type":"Google+"},{"id":"qqqq","type":"Orkut"},{"id":"qqqqq","type":"Orkut"},{"id":"asdasd","type":"Facebook"},{"id":"qqqq1","type":"Facebook"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, '{"aboutme":"sdfdsfdsffds","certificateVal":[{"certificate":"qqqq","certificateidof":"1940"}]}', NULL, '', 'Africa/Abidjan', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-01 12:16:39', '2014-02-01 12:30:09', NULL, 'a', '2574', b'1'),
(22, 'g', b'1', NULL, NULL, 'Test', '', '1218124dfc3909b2c2202454453dd535', 'Tag line', NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '{"pic":"5541\\/22_1392091146_uploaded.jpg","video":"","url":"","weburl":"","url_ispublic":"","weburl_ispublic":"","video_ispublic":"","pic_ispublic":""}', '{"emails":[{"e":"testabc@gmail.com","type":"p"}],"chatids":[{"id":"dfgdf","type":"Skype"},{"id":"fgyjhu","type":"Skype"}]}', 'test new 222', 'Test Add2', 5, b'0', 2, b'1', 1, b'1', 'IN', '20545', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'0', '', '', '{"aboutme":"fgyjftyjftuyjtyuktyuktyuoilyuiy89pUUUUUGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFoilyuiDXFDFFGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFoilyuiDXFDFFGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFoilyuiDXFDFFGGGGGGGGGGGGGGGGGGGGGGGGGGGGGGFFFFFFFFFFFfgyjftyjftuyjtyuktyuktyuoilyuiDXFDFFBBVBVBVBVBVBBBBBBBBBBBBBBBBBBBBBBBBGGGGGIIIII","certificateVal":[{"certificate":"Certificate1","certificateidof":"1940"}]}', 1942, '{"contact_by":["c","e"],"ref_check_by":["c","e"],"work_hrs":[[{"day":"mon","hrs":"13:50-15:50"},{"day":"tue","hrs":"13:50-15:50"},{"day":"wed","hrs":"13:50-15:50"}]]}', 'Africa/Abidjan', '', 0, 0, 1, 0, 1, b'0', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-01 12:39:00', '2014-02-07 10:34:12', NULL, 'n', '5541', b'1'),
(23, 'g', b'1', NULL, NULL, 'mkl', 'mukul', '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"phs":[{"p":"1111111111","type":"p"}],"emails":[{"e":"mukul7@gmail.com","type":"p"}],"chatids":[{"id":"abc","type":"Skype"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-01 13:18:09', '2014-02-03 09:22:45', NULL, 'a', '6547', b'1'),
(24, 'g', b'1', NULL, NULL, 'chitti', 'Bishi', '9656ea4c8792e9528d8015e96856e803', 'tag line ', NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '{"pic":"1569\\/24_1392455977_uploaded.png","video":"","url":"","weburl":"","url_ispublic":"","weburl_ispublic":"","video_ispublic":"","pic_ispublic":""}', '{"phs":[{"p":"8955530447","type":"p"}],"emails":[{"e":"Chitti@gmail.com","type":"p"},{"e":"chitti@gmail.com","type":"s"}],"chatids":[{"id":"aaaa","type":"Skype"},{"id":"aaaa","type":"Gmail"}],"socialids":[{"id":"wwww","type":"Flicker"},{"id":"wwww","type":"Facebook"},{"id":"w","type":"Facebook"},{"id":"ww","type":"Facebook"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, '{"aboutme":"this is Description","certificateVal":[{"certificate":"qqq","certificateidof":"1940"},{"certificate":"qqq","certificateidof":"1941"}]}', 1940, '', 'Africa/Abidjan', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-03 09:11:30', '2014-02-03 09:33:48', NULL, 'a', '1569', b'1'),
(25, 'g', b'1', NULL, NULL, 'A', 'B', '9656ea4c8792e9528d8015e96856e803', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"emails":[{"e":"chitti1@gmail.com","type":"p"}],"chatids":[{"id":"rrrrr","type":"Skype"}],"socialids":[{"id":"rrrrr","type":"Facebook"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-03 09:18:31', '2014-02-03 09:30:06', NULL, 'a', '6852', b'1'),
(26, 'g', b'1', NULL, NULL, 'da', 's', '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"emails":[{"e":"mukul8@gmail.com","type":"p"}],"chatids":[{"id":"qqqq","type":"Skype"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-03 09:32:24', '2014-02-03 09:59:26', NULL, 'a', '1256', b'1'),
(27, 'g', b'1', NULL, NULL, 'mukul', 'me', '03abbb08cc5ce43fa169fb7910d3345a', 'asdasdasdas', NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"chatids":[{"id":"sfdsd","type":"Skype"},{"id":"qqqq","type":"Skype"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, '{"aboutme":"dasdasdasdasdasdasdasdasXZx","certificateVal":[{"certificate":"qqqq","certificateidof":"1940"},{"certificate":"qqqq","certificateidof":"1941"}]}', 1940, '', 'Africa/Abidjan', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-04 06:58:23', '2014-02-04 10:27:36', NULL, 'a', '1679', b'1'),
(28, 'g', b'1', NULL, NULL, 'mukul', 'medatwal', '03abbb08cc5ce43fa169fb7910d3345a', 'Php developer', NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '{"pic":"8171\\/28_1392459134_uploaded.jpg","video":"8171\\/28_1392351404_uploaded.mp4","url":"","weburl":"","url_ispublic":"0","weburl_ispublic":"0","video_ispublic":"","pic_ispublic":""}', '{"phs":[{"p":"9610040782","type":"p"}],"emails":[{"e":"mukul10@gmail.com","type":"p"},{"e":"mukul22medatwal@gmail.com","type":"s"}],"chatids":[{"id":"mukulmedatwal","type":"Skype"}],"socialids":[{"id":"MUKULMEDATWAL","type":"Facebook"}]}', 'nehru bazar', 'sabji mandi', 5, b'0', 2, b'1', 1, b'0', 'IN', '303007', b'1', '', '', NULL, NULL, NULL, NULL, NULL, b'0', '', '', '{"aboutme":"Good knowledge of PHP , MAGENTO , WORDPRESS , ZEND , YII , HTML , CSS","certificateVal":[{"certificate":"B.tech","certificateidof":"2012"},{"certificate":"PHP","certificateidof":"2012"}]}', 2012, '{"work_hrs":[[{"day":"mon","hrs":"09:35-18:35"},{"day":"tue","hrs":"09:35-18:35"},{"day":"wed","hrs":"09:35-18:35"},{"day":"thu","hrs":"09:35-18:35"},{"day":"fri","hrs":"09:35-18:35"}],[{"day":"sat","hrs":"09:35-12:35"},{"day":"sun","hrs":"09:35-12:35"}]],"contact_by":["c","e","p"],"ref_check_by":["c","e","p"]}', 'Africa/Algiers', '', 1, 1, 1, 1, 1, b'1', '{"card":[{"name":"Mukul Meadawal","number":"5250832680342674","month":"12","year":"2014","type":"MasterCard","preference":"0"},{"name":"Mukul Meadawal","number":"4572740315007378","month":"9","year":"2023","type":"Visa","preference":"0"}],"paypal":[{"email":"mukul22medatwal@gmail.com","preference":"1"},{"email":"mukulmedatwal@hotmail.com","preference":"0"}]}', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-06 11:45:39', '2014-02-10 08:23:09', NULL, 'a', '8171', b'1'),
(29, 'g', b'1', NULL, NULL, '', '', '88f3b62ed82fad6b375c4e45a6f2b268', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"phs":[{"p":"3022222222","type":"p"}],"emails":[{"e":"todd@integritystaffing.com","type":"p"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', 'America/Glace_Bay', 'dashboard', 1, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-07 19:06:10', NULL, NULL, 'a', '4595', b'1'),
(30, 'g', b'1', NULL, NULL, '', '', 'a1dd3fa8695f8fe7562b0a81e67d2c62', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"emails":[{"e":"ras@gmail.com","type":"p"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-08 03:29:10', NULL, NULL, 'a', '2167', b'1'),
(31, 'g', b'1', NULL, NULL, '', '', '03abbb08cc5ce43fa169fb7910d3345a', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', '', '{"emails":[{"e":"testing@gmail.com","type":"p"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, '', '', '', 0, 1, 1, 1, 1, b'1', '', NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-08 03:48:36', NULL, NULL, 'a', '6851', b'1'),
(32, 'g', b'1', NULL, NULL, '', '', '9c21626246ce644535d6941bc2391a56', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', NULL, '{"emails":[{"e":"archana1@gmail.com","type":"p"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, '', '', 0, 1, 1, 1, 1, b'1', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-15 04:50:26', NULL, NULL, 'a', '6689', b'1'),
(33, 'g', b'1', NULL, NULL, '', '', '1218124dfc3909b2c2202454453dd535', NULL, NULL, '', NULL, NULL, b'1', NULL, b'1', NULL, b'1', '', b'1', NULL, '{"emails":[{"e":"test@test.com","type":"p"}]}', NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, b'1', NULL, NULL, NULL, NULL, NULL, '', '', 0, 1, 1, 1, 1, b'1', NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, b'1', b'1', b'1', b'1', '', '2014-02-15 04:53:34', NULL, NULL, 'a', '9476', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_user_contact`
--

CREATE TABLE IF NOT EXISTS `gc_dta_user_contact` (
  `contact_id` varchar(250) NOT NULL DEFAULT '',
  `contact_type` char(1) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `is_primary` bigint(20) NOT NULL,
  `is_login_allowed` bit(1) NOT NULL DEFAULT b'1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`contact_id`),
  KEY `gc_dta_user_contact_idx1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_dta_user_contact`
--

INSERT INTO `gc_dta_user_contact` (`contact_id`, `contact_type`, `user_id`, `is_primary`, `is_login_allowed`, `created_at`, `last_updated_at`, `status`) VALUES
('aditi@gmail.com', 'E', 16, 1, b'1', '2014-01-30 10:28:36', NULL, 'a'),
('archana1@gmail.com', 'E', 32, 1, b'1', '2014-02-15 04:50:26', NULL, 'a'),
('archana23@gmail.com', 'E', 20, 1, b'1', '2014-02-01 11:47:11', NULL, 'a'),
('archana@gmail.com', 'E', 10, 1, b'1', '2014-01-27 12:32:31', NULL, 'a'),
('chitti1@gmail.com', 'E', 25, 1, b'1', '2014-02-03 09:18:31', NULL, 'a'),
('Chitti@gmail.com', 'E', 24, 1, b'1', '2014-02-03 09:11:30', NULL, 'a'),
('john_smith01@gmail.com', 'E', 7, 1, b'1', '2014-01-27 06:24:13', NULL, 'a'),
('manojs@gmail.com', 'E', 15, 1, b'1', '2014-01-29 03:50:57', NULL, 'a'),
('mmmmm@gmail.com', 'E', 19, 1, b'1', '2014-02-01 11:44:14', NULL, 'a'),
('mukul10@gmail.com', 'E', 28, 1, b'1', '2014-02-06 11:45:39', NULL, 'a'),
('mukul2@gmail.com', 'E', 6, 1, b'1', '2014-01-27 06:23:15', NULL, 'a'),
('mukul3@gmail.com', 'E', 12, 1, b'1', '2014-01-28 07:24:33', NULL, 'a'),
('mukul6@gmail.com', 'E', 21, 1, b'1', '2014-02-01 12:16:39', NULL, 'a'),
('mukul7@gmail.com', 'E', 23, 1, b'1', '2014-02-01 13:18:10', NULL, 'a'),
('mukul8@gmail.com', 'E', 26, 1, b'1', '2014-02-03 09:32:24', NULL, 'a'),
('mukul9@gmail.com', 'E', 27, 1, b'1', '2014-02-04 06:58:23', NULL, 'a'),
('mukul@gmail.com', 'E', 1, 1, b'1', '2014-01-27 04:27:35', '2014-01-27 04:27:35', 'a'),
('ras@gmail.com', 'E', 30, 1, b'1', '2014-02-08 03:29:10', NULL, 'a'),
('sadas11@asd.com', 'E', 17, 1, b'1', '2014-02-01 11:41:13', NULL, 'a'),
('sadas@asd.com', 'E', 8, 1, b'1', '2014-01-27 12:17:25', NULL, 'a'),
('test1@mail.com', 'E', 14, 1, b'1', '2014-01-29 03:43:22', NULL, 'a'),
('test@gmail.com', 'E', 11, 1, b'1', '2014-01-27 12:46:39', NULL, 'a'),
('test@test.com', 'E', 33, 1, b'1', '2014-02-15 04:53:34', NULL, 'a'),
('testabc@gmail.com', 'E', 22, 1, b'1', '2014-02-01 12:39:00', NULL, 'a'),
('testing@gmail.com', 'E', 31, 1, b'1', '2014-02-08 03:48:36', NULL, 'a'),
('testnew@gmail.com', 'E', 13, 1, b'1', '2014-01-28 12:14:50', NULL, 'a'),
('todd@integritystaffing.com', 'E', 29, 1, b'1', '2014-02-07 19:06:11', NULL, 'a'),
('you1@gmail.com', 'E', 18, 1, b'1', '2014-02-01 11:43:42', NULL, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_user_contact_pending`
--

CREATE TABLE IF NOT EXISTS `gc_dta_user_contact_pending` (
  `tran_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contact_id` varchar(250) DEFAULT NULL,
  `contact_type` char(1) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `is_primary` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated_at` timestamp NULL DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`tran_id`),
  UNIQUE KEY `contact_type` (`contact_type`),
  KEY `fk_dtausercontactpending_userid` (`user_id`),
  KEY `gc_dta_user_contact_pending_idx1` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gc_dta_user_speciality`
--

CREATE TABLE IF NOT EXISTS `gc_dta_user_speciality` (
  `user_id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `country_code` char(2) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`user_id`,`category_id`),
  KEY `fk_dtauserspeciality_categoryid` (`category_id`),
  KEY `gc_dta_user_speciality_idx1` (`state_id`),
  KEY `gc_dta_user_speciality_idx2` (`city_id`),
  KEY `gc_dta_user_speciality_idx3` (`region_id`),
  KEY `gc_dta_user_speciality_idx4` (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_dta_user_speciality`
--

INSERT INTO `gc_dta_user_speciality` (`user_id`, `category_id`, `country_code`, `state_id`, `region_id`, `city_id`, `created_at`, `status`) VALUES
(13, 1, 'IN', 1, 2, 5, '2014-01-30 10:57:12', 'a'),
(13, 19, 'IN', 1, 2, 5, '2014-02-05 04:56:27', 'a'),
(13, 21, 'IN', 1, 2, 5, '2014-02-10 04:16:08', 'a'),
(15, 19, 'IN', 1, 2, 5, '2014-02-05 04:24:15', 'a'),
(15, 20, 'IN', 1, 2, 5, '2014-02-05 11:01:58', 'a'),
(15, 21, 'IN', 1, 2, 5, '2014-02-05 11:00:32', 'a'),
(15, 22, 'IN', 1, 2, 5, '2014-02-05 11:02:33', 'a'),
(15, 23, 'IN', 1, 2, 5, '2014-02-05 11:01:58', 'a'),
(15, 24, 'IN', 1, 2, 5, '2014-02-05 10:59:56', 'a'),
(15, 25, 'IN', 1, 2, 5, '2014-02-05 11:01:59', 'a'),
(15, 26, 'IN', 1, 2, 5, '2014-02-05 11:02:16', 'a'),
(15, 35, 'IN', 1, 2, 5, '2014-02-05 11:03:40', 'a'),
(15, 36, 'IN', 1, 2, 5, '2014-02-05 11:02:55', 'a'),
(18, 4, 'IN', 1, 2, 5, '2014-02-01 13:00:06', 'a'),
(21, 1, NULL, NULL, NULL, NULL, '2014-02-03 11:08:37', 'a'),
(21, 19, NULL, NULL, NULL, NULL, '2014-02-04 06:14:04', 'a'),
(21, 20, NULL, NULL, NULL, NULL, '2014-02-05 10:49:50', 'a'),
(21, 23, NULL, NULL, NULL, NULL, '2014-02-05 05:32:26', 'a'),
(21, 24, NULL, NULL, NULL, NULL, '2014-02-05 10:51:34', 'a'),
(22, 19, 'IN', 1, 2, 5, '2014-02-07 12:27:13', 'a'),
(22, 20, 'IN', 1, 2, 5, '2014-02-10 08:29:22', 'a'),
(24, 1, NULL, NULL, NULL, NULL, '2014-02-03 12:11:41', 'a'),
(27, 19, NULL, NULL, NULL, NULL, '2014-02-04 11:01:46', 'a'),
(28, 19, NULL, NULL, NULL, NULL, '2014-02-12 11:04:12', 'a'),
(28, 23, 'IN', 1, 2, 5, '2014-02-15 10:14:37', 'a'),
(28, 24, 'IN', 1, 2, 5, '2014-02-15 10:14:37', 'a'),
(28, 25, 'IN', 1, 2, 5, '2014-02-15 10:14:37', 'a'),
(28, 26, 'IN', 1, 2, 5, '2014-02-15 10:14:37', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_adminuser`
--

CREATE TABLE IF NOT EXISTS `gc_mst_adminuser` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(75) NOT NULL,
  `login_password` varchar(100) NOT NULL,
  `user_salutation` varchar(5) NOT NULL DEFAULT 'Mr.',
  `user_phone` varchar(20) NOT NULL,
  `user_firstname` varchar(40) NOT NULL,
  `user_lastname` varchar(40) DEFAULT NULL,
  `user_roleid` int(11) DEFAULT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_gender` char(1) NOT NULL DEFAULT 'M',
  `last_logindate` datetime DEFAULT NULL,
  `is_admin` bit(1) NOT NULL DEFAULT b'0',
  `is_active` bit(1) NOT NULL DEFAULT b'1',
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uk_adminuser_loginname` (`login_name`),
  KEY `fk_adminuser_role` (`user_roleid`),
  KEY `fk_adminuser_createdby` (`created_by`),
  KEY `fk_adminuser_updatedby` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gc_mst_adminuser`
--

INSERT INTO `gc_mst_adminuser` (`user_id`, `login_name`, `login_password`, `user_salutation`, `user_phone`, `user_firstname`, `user_lastname`, `user_roleid`, `user_email`, `user_gender`, `last_logindate`, `is_admin`, `is_active`, `create_timestamp`, `created_by`, `update_timestamp`, `updated_by`) VALUES
(1, 'superadmin', 'a22ed9cf60d4f0b6fb68f89e2c3e22be', 'Mr.', '9898989898', 'supera', '1111111111111111111111111111111111111111', NULL, 'admin@admin.com11111', 'M', '2014-02-12 16:42:09', b'1', b'1', '2014-01-17 18:21:42', 1, NULL, NULL),
(2, 'Foredit', '03abbb08cc5ce43fa169fb7910d3345a', 'Mr.', '12345678923', 'editora', 'ii', 2, 'edit@gmail.com', 'M', NULL, b'0', b'1', '2014-01-23 07:28:52', 1, '2014-01-23 07:30:58', 1),
(3, 'alsosuper', '03abbb08cc5ce43fa169fb7910d3345a', 'Mr.', '123456789236', 'i am also ', 'superadmin', NULL, 'likesuper@gmail.com', 'M', NULL, b'1', b'1', '2014-01-23 07:31:58', 1, '2014-01-23 07:32:12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_category`
--

CREATE TABLE IF NOT EXISTS `gc_mst_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `gc_mst_category`
--

INSERT INTO `gc_mst_category` (`category_id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_category_locale`
--

CREATE TABLE IF NOT EXISTS `gc_mst_category_locale` (
  `category_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `language_code` varchar(5) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_image` varchar(500) DEFAULT NULL,
  `category_desc` varchar(1000) DEFAULT NULL,
  `category_status` bit(1) NOT NULL DEFAULT b'1',
  `category_priority` int(11) DEFAULT NULL,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`language_code`,`category_id`),
  KEY `fk_categorylocale_categoryid` (`category_id`),
  KEY `fk_categorylocale_parentid` (`parent_id`),
  KEY `fk_categorylocale_createdby` (`created_by`),
  KEY `fk_categorylocale_updatedby` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_mst_category_locale`
--

INSERT INTO `gc_mst_category_locale` (`category_id`, `parent_id`, `language_code`, `category_name`, `category_image`, `category_desc`, `category_status`, `category_priority`, `create_timestamp`, `created_by`, `update_timestamp`, `updated_by`) VALUES
(19, NULL, 'en_us', 'Handyman', NULL, NULL, b'1', 4, '2014-02-03 13:15:55', NULL, NULL, NULL),
(20, NULL, 'en_us', 'Delivery', NULL, NULL, b'1', 5, '2014-02-03 13:16:29', NULL, NULL, NULL),
(21, 20, 'en_us', 'Restaurant Delivery', NULL, NULL, b'1', 6, '2014-02-03 13:16:47', NULL, NULL, NULL),
(22, 20, 'en_us', 'Shipping', NULL, NULL, b'1', 7, '2014-02-03 13:17:03', NULL, NULL, NULL),
(23, NULL, 'en_us', 'Computer', NULL, NULL, b'1', 8, '2014-02-03 13:17:30', NULL, NULL, NULL),
(24, 23, 'en_us', 'Website Design', NULL, NULL, b'1', 9, '2014-02-03 13:17:43', NULL, NULL, NULL),
(25, 23, 'en_us', 'HTML Coding', NULL, NULL, b'1', 10, '2014-02-03 13:17:57', NULL, NULL, NULL),
(26, 23, 'en_us', 'Computer Engineering', NULL, NULL, b'1', 11, '2014-02-03 13:18:13', NULL, NULL, NULL),
(27, NULL, 'en_us', 'Yard Work', NULL, NULL, b'1', 12, '2014-02-03 13:18:32', NULL, NULL, NULL),
(28, 27, 'en_us', 'Snow Removal', NULL, NULL, b'1', 13, '2014-02-03 13:18:48', NULL, NULL, NULL),
(29, 27, 'en_us', 'Gardening', NULL, NULL, b'1', 14, '2014-02-03 13:19:04', NULL, NULL, NULL),
(30, 27, 'en_us', 'Landscaping', NULL, NULL, b'1', 15, '2014-02-03 13:19:20', NULL, NULL, NULL),
(31, NULL, 'en_us', 'Pet Care', NULL, NULL, b'1', 16, '2014-02-03 13:20:00', NULL, NULL, NULL),
(32, 31, 'en_us', 'Dog Walking', NULL, NULL, b'1', 17, '2014-02-03 13:20:16', NULL, NULL, NULL),
(33, 31, 'en_us', 'Pet Sitting', NULL, NULL, b'1', 18, '2014-02-03 13:20:31', NULL, NULL, NULL),
(34, NULL, 'en_us', 'Instruction', NULL, NULL, b'1', 19, '2014-02-03 13:20:50', NULL, NULL, NULL),
(35, 34, 'en_us', 'Tutor', NULL, NULL, b'1', 20, '2014-02-03 13:21:04', NULL, NULL, NULL),
(36, 34, 'en_us', 'Yoga', NULL, NULL, b'1', 21, '2014-02-03 13:21:21', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_category_question`
--

CREATE TABLE IF NOT EXISTS `gc_mst_category_question` (
  `question_id` bigint(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_category_question_locale`
--

CREATE TABLE IF NOT EXISTS `gc_mst_category_question_locale` (
  `category_id` int(11) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `question_desc` bigint(200) NOT NULL,
  `question_type` char(1) NOT NULL DEFAULT 'l',
  `question_for` char(1) NOT NULL DEFAULT 't',
  `is_answer_must` bit(1) NOT NULL DEFAULT b'0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`category_id`,`language_code`,`question_id`),
  KEY `fk_category_question_locale_language_code` (`language_code`),
  KEY `fk_category_question_locale_created_by` (`created_by`),
  KEY `fk_category_question_locale_updated_by` (`updated_by`),
  KEY `idx_gc_mst_category_question_locale_question_id` (`question_id`,`language_code`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_city`
--

CREATE TABLE IF NOT EXISTS `gc_mst_city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `gc_mst_city`
--

INSERT INTO `gc_mst_city` (`city_id`) VALUES
(5),
(7),
(16);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_city_locale`
--

CREATE TABLE IF NOT EXISTS `gc_mst_city_locale` (
  `city_id` int(11) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `region_id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `city_status` bit(1) NOT NULL DEFAULT b'1',
  `city_priority` int(11) NOT NULL,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`language_code`,`city_id`),
  KEY `fk_citylocale_regionid` (`region_id`),
  KEY `fk_citylocale_createdby` (`created_by`),
  KEY `fk_citylocale_updatedby` (`updated_by`),
  KEY `fk_citylocale_cityid` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_mst_city_locale`
--

INSERT INTO `gc_mst_city_locale` (`city_id`, `language_code`, `region_id`, `city_name`, `city_status`, `city_priority`, `create_timestamp`, `created_by`, `update_timestamp`, `updated_by`) VALUES
(5, 'en_us', 2, 'jaipur city', b'1', 1, '2014-01-21 09:53:25', 1, NULL, NULL),
(16, 'en_us', 14, 'New Delhi', b'1', 4, '2014-01-27 11:58:49', 1, NULL, NULL),
(5, 'es', 2, 'jaipur_es', b'1', 5, '2014-01-21 10:28:03', NULL, '2014-01-21 10:28:03', NULL),
(5, 'fr', 2, 'jaipur_fr', b'1', 5, '2014-01-21 10:28:03', NULL, '2014-01-21 10:28:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_country`
--

CREATE TABLE IF NOT EXISTS `gc_mst_country` (
  `country_code` varchar(2) NOT NULL,
  PRIMARY KEY (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_mst_country`
--

INSERT INTO `gc_mst_country` (`country_code`) VALUES
('BS'),
('BT'),
('BV'),
('BW'),
('BZ'),
('CA'),
('CC'),
('CD'),
('CF'),
('CG'),
('CH'),
('CI'),
('CK'),
('CL'),
('CM'),
('CN'),
('CO'),
('CR'),
('CS'),
('CU'),
('CV'),
('CW'),
('CX'),
('CY'),
('CZ'),
('DE'),
('DJ'),
('DK'),
('DM'),
('DO'),
('DZ'),
('EC'),
('EE'),
('EG'),
('EH'),
('ER'),
('ES'),
('ET'),
('FI'),
('FJ'),
('FK'),
('FM'),
('FO'),
('FR'),
('GA'),
('GB'),
('GD'),
('GE'),
('GF'),
('GG'),
('GH'),
('GI'),
('GL'),
('GM'),
('GN'),
('GP'),
('GQ'),
('GR'),
('GS'),
('GT'),
('GW'),
('GY'),
('HK'),
('HM'),
('HN'),
('HR'),
('HT'),
('HU'),
('ID'),
('IE'),
('IL'),
('IM'),
('IN'),
('IO'),
('IQ'),
('IR'),
('IS'),
('IT'),
('JE'),
('JM'),
('JO'),
('JP'),
('KE'),
('KG'),
('KH'),
('KI'),
('KK'),
('KM'),
('KN'),
('KP'),
('KR'),
('KW'),
('KY'),
('KZ'),
('LA'),
('LB'),
('LC'),
('LI'),
('LK'),
('LR'),
('LS'),
('LT'),
('LU'),
('LV'),
('LY'),
('MA'),
('MC'),
('MD'),
('ME'),
('MF'),
('MG'),
('MH'),
('MK'),
('ML'),
('MM'),
('MN'),
('MO'),
('MP'),
('MQ'),
('MR'),
('MS'),
('MT'),
('MU'),
('MV'),
('MW'),
('MX'),
('MY'),
('MZ'),
('NA'),
('NC'),
('NE'),
('NF'),
('NG'),
('NI'),
('NL'),
('NO'),
('NP'),
('NR'),
('NU'),
('NZ'),
('OM'),
('PA'),
('PE'),
('PF'),
('PG'),
('PH'),
('PK'),
('PL'),
('PM'),
('PN'),
('PR'),
('PS'),
('PT'),
('PW'),
('PY'),
('QA'),
('RE'),
('RO'),
('RS'),
('RU'),
('RW'),
('SA'),
('SB'),
('SC'),
('SD'),
('SE'),
('SG'),
('SH'),
('SI'),
('SJ'),
('SK'),
('SL'),
('SM'),
('SN'),
('SO'),
('SR'),
('SS'),
('ST'),
('SV'),
('SY'),
('SZ'),
('TC'),
('TD'),
('TF'),
('TG'),
('TH'),
('TJ'),
('TK'),
('TL'),
('TM'),
('TN'),
('TO'),
('TR'),
('TT'),
('TV'),
('TW'),
('TZ'),
('UA'),
('UG'),
('UK'),
('UM'),
('US'),
('UU'),
('UY'),
('UZ'),
('VA'),
('VC'),
('VE'),
('VG'),
('VI'),
('VN'),
('VU'),
('WF'),
('WS'),
('YE'),
('YT'),
('ZA');

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_country_locale`
--

CREATE TABLE IF NOT EXISTS `gc_mst_country_locale` (
  `country_code` varchar(2) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `country_status` bit(1) NOT NULL DEFAULT b'1',
  `country_priority` int(11) NOT NULL,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`language_code`,`country_code`),
  KEY `fk_countrylocale_countrycode` (`country_code`),
  KEY `fk_countrylocale_createdby` (`created_by`),
  KEY `fk_countrylocale_updatedby` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_mst_country_locale`
--

INSERT INTO `gc_mst_country_locale` (`country_code`, `language_code`, `country_name`, `country_status`, `country_priority`, `create_timestamp`, `created_by`, `update_timestamp`, `updated_by`) VALUES
('BS', 'en_us', 'Bahamas', b'1', 6, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('BT', 'en_us', 'Bhutan', b'1', 7, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('BV', 'en_us', 'Bouvet Island', b'1', 8, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('BW', 'en_us', 'Botswana', b'1', 9, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('BZ', 'en_us', 'Belize', b'1', 11, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('CA', 'en_us', 'Canada', b'1', 5, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('CC', 'en_us', 'Cocos (Keeling) Islands', b'1', 12, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('CD', 'en_us', 'Congo, Democratic Republic of the', b'1', 13, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('CF', 'en_us', 'Central African Republic', b'1', 14, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:26', 1),
('CG', 'en_us', 'Congo, Republic of the', b'1', 15, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CH', 'en_us', 'Switzerland', b'1', 16, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CI', 'en_us', 'Cote d''Ivoire', b'1', 17, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CK', 'en_us', 'Cook Islands', b'1', 18, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CL', 'en_us', 'Chile', b'1', 19, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CM', 'en_us', 'Cameroon', b'1', 20, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CN', 'en_us', 'China', b'1', 21, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CO', 'en_us', 'Colombia', b'1', 22, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CR', 'en_us', 'Costa Rica', b'1', 23, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CS', 'en_us', 'Serbia and Montenegro', b'1', 24, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CU', 'en_us', 'Cuba', b'1', 25, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:27', 1),
('CV', 'en_us', 'Cape Verde', b'1', 26, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('CW', 'en_us', 'CURACAO', b'1', 27, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('CX', 'en_us', 'Christmas Island', b'1', 28, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('CY', 'en_us', 'Cyprus', b'1', 29, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('CZ', 'en_us', 'Czech Republic', b'1', 30, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('DE', 'en_us', 'Germany', b'1', 31, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('DJ', 'en_us', 'Djibouti', b'1', 32, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('DK', 'en_us', 'Denmark', b'1', 33, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('DM', 'en_us', 'Dominica', b'1', 34, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('DO', 'en_us', 'Dominican Republic', b'1', 35, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('DZ', 'en_us', 'Algeria', b'1', 36, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('EC', 'en_us', 'Ecuador', b'1', 37, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('EE', 'en_us', 'Estonia', b'1', 38, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('EG', 'en_us', 'Egypt', b'1', 39, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:28', 1),
('EH', 'en_us', 'Western Sahara', b'1', 40, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('ER', 'en_us', 'Eritrea', b'1', 41, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('ES', 'en_us', 'Spain', b'1', 42, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('ET', 'en_us', 'Ethiopia', b'1', 43, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('FI', 'en_us', 'Finland', b'1', 44, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('FJ', 'en_us', 'Fiji', b'1', 45, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('FK', 'en_us', 'Falkland Islands (Malvinas)', b'1', 46, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('FM', 'en_us', 'Micronesia', b'1', 47, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('FO', 'en_us', 'Faroe Islands', b'1', 48, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('FR', 'en_us', 'France', b'1', 49, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('GA', 'en_us', 'Gabon', b'1', 50, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('GB', 'en_us', 'United Kingdom', b'1', 51, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('GD', 'en_us', 'Grenada', b'1', 52, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('GE', 'en_us', 'Georgia', b'1', 53, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('GF', 'en_us', 'French Guiana', b'1', 54, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('GG', 'en_us', 'Guernsey', b'1', 55, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:29', 1),
('GH', 'en_us', 'Ghana', b'1', 56, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GI', 'en_us', 'Gibraltar', b'1', 57, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GL', 'en_us', 'Greenland', b'1', 58, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GM', 'en_us', 'Gambia', b'1', 59, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GN', 'en_us', 'Guinea', b'1', 60, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GP', 'en_us', 'Guadeloupe', b'1', 61, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GQ', 'en_us', 'Equatorial Guinea', b'1', 62, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GR', 'en_us', 'Greece', b'1', 63, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GS', 'en_us', 'South Georgia and the South Sandwich Islands', b'1', 64, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GT', 'en_us', 'Guatemala', b'1', 65, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GW', 'en_us', 'Guinea-Bissau', b'1', 66, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:30', 1),
('GY', 'en_us', 'Guyana', b'1', 67, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('HK', 'en_us', 'Hong Kong', b'1', 68, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('HM', 'en_us', 'Heard Island and Mcdonald Islands', b'1', 69, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('HN', 'en_us', 'Honduras', b'1', 70, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('HR', 'en_us', 'Croatia', b'1', 71, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('HT', 'en_us', 'Haiti', b'1', 72, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('HU', 'en_us', 'Hungary', b'1', 73, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('ID', 'en_us', 'Indonesia', b'1', 74, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('IE', 'en_us', 'Ireland', b'1', 75, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('IL', 'en_us', 'Israel', b'1', 76, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:31', 1),
('IM', 'en_us', 'Isle of Man', b'1', 77, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('IN', 'en_us', 'India', b'1', 78, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('IO', 'en_us', 'British Indian Ocean', b'1', 79, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('IQ', 'en_us', 'Iraq', b'1', 80, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('IR', 'en_us', 'Iran, Islamic Republic of', b'1', 81, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('IS', 'en_us', 'Iceland', b'1', 82, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('IT', 'en_us', 'Italy', b'1', 83, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('JE', 'en_us', 'Jersey', b'1', 84, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('JM', 'en_us', 'Jamaica', b'1', 85, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('JO', 'en_us', 'Jordan', b'1', 86, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('JP', 'en_us', 'Japan', b'1', 87, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('KE', 'en_us', 'Kenya', b'1', 88, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('KG', 'en_us', 'Kyrgyzstan', b'1', 89, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('KH', 'en_us', 'Cambodia', b'1', 90, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('KI', 'en_us', 'Kiribati', b'1', 91, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:32', 1),
('KK', 'en_us', 'kentuky', b'1', 92, '2014-01-20 10:07:02', 1, '2014-01-20 11:28:33', 1),
('KM', 'en_us', 'Comoros', b'1', 93, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('KN', 'en_us', 'Saint Kitts and Nevis', b'1', 94, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('KP', 'en_us', 'Korea, Democratic People''s Republic of', b'1', 95, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('KR', 'en_us', 'Korea, South', b'1', 96, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('KW', 'en_us', 'Kuwait', b'1', 97, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('KY', 'en_us', 'Cayman Islands', b'1', 98, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('KZ', 'en_us', 'Kazakhstan', b'1', 99, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('LA', 'en_us', 'Laos', b'1', 100, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('LB', 'en_us', 'Lebanon', b'1', 101, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('LC', 'en_us', 'Saint Lucia', b'1', 102, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:33', 1),
('LI', 'en_us', 'Liechtenstein', b'1', 103, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('LK', 'en_us', 'Sri Lanka', b'1', 104, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('LR', 'en_us', 'Liberia', b'1', 105, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('LS', 'en_us', 'Lesotho', b'1', 106, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('LT', 'en_us', 'Lithuania', b'1', 107, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('LU', 'en_us', 'Luxembourg', b'1', 108, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('LV', 'en_us', 'Latvia', b'1', 109, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('LY', 'en_us', 'Libya', b'1', 110, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('MA', 'en_us', 'Morocco', b'1', 111, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('MC', 'en_us', 'Monaco', b'1', 112, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('MD', 'en_us', 'Moldova', b'1', 113, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('ME', 'en_us', 'Montenegro', b'1', 114, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('MF', 'en_us', 'Saint-Martin', b'1', 115, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('MG', 'en_us', 'Madagascar', b'1', 116, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('MH', 'en_us', 'Marshall Islands', b'1', 117, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:34', 1),
('MK', 'en_us', 'Macedonia, Republic of', b'1', 118, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('ML', 'en_us', 'Mali', b'1', 119, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MM', 'en_us', 'Myanmar', b'1', 120, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MN', 'en_us', 'Mongolia', b'1', 121, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MO', 'en_us', 'Macau', b'1', 122, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MP', 'en_us', 'Northern Mariana Islands', b'1', 123, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MQ', 'en_us', 'Martinique', b'1', 124, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MR', 'en_us', 'Mauritania', b'1', 125, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MS', 'en_us', 'Montserrat', b'1', 126, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MT', 'en_us', 'Malta', b'1', 127, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MU', 'en_us', 'Mauritius', b'1', 128, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:35', 1),
('MV', 'en_us', 'Maldives', b'1', 129, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:36', 1),
('MW', 'en_us', 'Malawi', b'1', 130, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:36', 1),
('MX', 'en_us', 'Mexico', b'1', 131, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:36', 1),
('MY', 'en_us', 'Malaysia', b'1', 132, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:36', 1),
('MZ', 'en_us', 'Mozambique', b'1', 133, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:36', 1),
('NA', 'en_us', 'Namibia', b'1', 134, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NC', 'en_us', 'New Caledonia', b'1', 135, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NE', 'en_us', 'Niger', b'1', 136, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NF', 'en_us', 'Norfolk Island', b'1', 137, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NG', 'en_us', 'Nigeria', b'1', 138, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NI', 'en_us', 'Nicaragua', b'1', 139, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NL', 'en_us', 'Netherlands', b'1', 140, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NO', 'en_us', 'Norway', b'1', 141, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NP', 'en_us', 'Nepal', b'1', 142, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NR', 'en_us', 'Nauru', b'1', 143, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NU', 'en_us', 'Niue', b'1', 144, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('NZ', 'en_us', 'New Zealand', b'1', 145, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('OM', 'en_us', 'Oman', b'1', 146, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:37', 1),
('PA', 'en_us', 'Panama', b'1', 147, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PE', 'en_us', 'Peru', b'1', 148, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PF', 'en_us', 'French Polynesia', b'1', 149, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PG', 'en_us', 'Papua New Guinea', b'1', 150, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PH', 'en_us', 'Philippines', b'1', 151, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PK', 'en_us', 'Pakistan', b'1', 152, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PL', 'en_us', 'Poland', b'1', 153, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PM', 'en_us', 'Saint Pierre and Miquelon', b'1', 154, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PN', 'en_us', 'Pitcairn Island', b'1', 155, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PR', 'en_us', 'Puerto Rico', b'1', 156, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PS', 'en_us', 'Palestinian Territory', b'1', 157, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PT', 'en_us', 'Portugal', b'1', 158, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:38', 1),
('PW', 'en_us', 'Palau', b'1', 159, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('PY', 'en_us', 'Paraguay', b'1', 160, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('QA', 'en_us', 'Qatar', b'1', 161, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('RE', 'en_us', 'Reunion', b'1', 162, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('RO', 'en_us', 'Romania', b'1', 163, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('RS', 'en_us', 'Serbia', b'1', 164, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('RU', 'en_us', 'Russia', b'1', 165, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('RW', 'en_us', 'Rwanda', b'1', 166, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('SA', 'en_us', 'Saudi Arabia', b'1', 167, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('SB', 'en_us', 'Solomon Islands', b'1', 168, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('SC', 'en_us', 'Seychelles', b'1', 169, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('SD', 'en_us', 'Sudan', b'1', 170, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('SE', 'en_us', 'Sweden', b'1', 171, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:39', 1),
('SG', 'en_us', 'Singapore', b'1', 172, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SH', 'en_us', 'Saint Helena', b'1', 173, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SI', 'en_us', 'Slovenia', b'1', 174, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SJ', 'en_us', 'Svalbard and Jan Mayen', b'1', 175, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SK', 'en_us', 'Slovakia', b'1', 176, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SL', 'en_us', 'Sierra Leone', b'1', 177, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SM', 'en_us', 'San Marino', b'1', 178, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SN', 'en_us', 'Senegal', b'1', 179, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SO', 'en_us', 'Somalia', b'1', 180, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SR', 'en_us', 'Suriname', b'1', 181, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SS', 'en_us', 'South Sudan', b'1', 182, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('ST', 'en_us', 'Sao Tome and Principe', b'1', 183, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SV', 'en_us', 'El Salvador', b'1', 184, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SY', 'en_us', 'Syria', b'1', 185, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('SZ', 'en_us', 'Swaziland', b'1', 186, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:40', 1),
('TC', 'en_us', 'Turks and Caicos Islands', b'1', 187, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:41', 1),
('TD', 'en_us', 'Chad', b'1', 188, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:41', 1),
('TF', 'en_us', 'French Southern Territories', b'1', 189, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:41', 1),
('TG', 'en_us', 'Togo', b'1', 190, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:41', 1),
('TH', 'en_us', 'Thailand', b'1', 191, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:41', 1),
('TJ', 'en_us', 'Tajikistan', b'1', 192, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:41', 1),
('TK', 'en_us', 'Tokelau', b'1', 193, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:41', 1),
('TL', 'en_us', 'East Timor', b'1', 194, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:41', 1),
('TM', 'en_us', 'Turkmenistan', b'1', 195, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('TN', 'en_us', 'Tunisia', b'1', 196, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('TO', 'en_us', 'Tonga', b'1', 197, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('TR', 'en_us', 'Turkey', b'1', 198, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('TT', 'en_us', 'Trinidad and Tobago', b'1', 199, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('TV', 'en_us', 'Tuvalu', b'1', 200, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('TW', 'en_us', 'Taiwan', b'1', 201, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('TZ', 'en_us', 'Tanzania', b'1', 202, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('UA', 'en_us', 'Ukraine', b'1', 203, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('UG', 'en_us', 'Uganda', b'1', 204, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:42', 1),
('UK', 'en_us', 'United King', b'1', 2, '2014-01-20 12:10:58', 1, '2014-01-20 12:13:18', 1),
('UM', 'en_us', 'United States Minor Outlying Islands', b'1', 205, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('US', 'en_us', 'United States', b'1', 1, '2014-01-17 18:21:43', 1, '2014-01-20 12:06:10', 1),
('UU', 'en_us', 'new uk', b'1', 3, '2014-01-21 07:01:29', 1, NULL, NULL),
('UY', 'en_us', 'Uruguay', b'1', 206, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('UZ', 'en_us', 'Uzbekistan', b'1', 207, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('VA', 'en_us', 'Vatican City', b'1', 208, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('VC', 'en_us', 'Saint Vincent and the Grenadines', b'1', 209, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('VE', 'en_us', 'Venezuela', b'1', 210, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('VG', 'en_us', 'Virgin Islands, British', b'1', 211, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('VI', 'en_us', 'Virgin Islands, US', b'1', 212, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('VN', 'en_us', 'Vietnam', b'1', 213, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('VU', 'en_us', 'Vanuatu', b'1', 214, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('WF', 'en_us', 'Wallis and Futuna', b'1', 215, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('WS', 'en_us', 'Samoa', b'1', 216, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('YE', 'en_us', 'Yemen', b'1', 217, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:43', 1),
('YT', 'en_us', 'Mayotte', b'1', 218, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:44', 1),
('ZA', 'en_us', 'South Africa', b'1', 219, '2014-01-17 18:21:43', 1, '2014-01-20 11:28:44', 1),
('BS', 'es', 'Bahamas_spanish', b'1', 16, '2014-01-20 08:54:36', NULL, '2014-01-20 08:54:36', NULL),
('BS', 'fr', 'Bahamas_fr', b'1', 16, '2014-01-20 09:58:04', NULL, '2014-01-20 09:58:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_language`
--

CREATE TABLE IF NOT EXISTS `gc_mst_language` (
  `language_code` varchar(5) NOT NULL,
  `language_name` varchar(75) NOT NULL,
  `language_status` bit(1) NOT NULL DEFAULT b'1',
  `language_priority` int(11) DEFAULT NULL,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`language_code`),
  UNIQUE KEY `uk_language_languagename` (`language_name`),
  KEY `fk_language_createdby` (`created_by`),
  KEY `fk_language_updatedby` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_mst_language`
--

INSERT INTO `gc_mst_language` (`language_code`, `language_name`, `language_status`, `language_priority`, `create_timestamp`, `created_by`, `update_timestamp`, `updated_by`) VALUES
('ch', '中國的', b'0', 1, '2014-01-22 07:13:40', 1, '2014-01-22 08:20:38', 1),
('en_us', 'English US', b'1', 2, '2014-01-17 18:21:42', 1, '2014-01-22 08:17:04', 1),
('es', 'español', b'0', 5, '2014-01-17 18:21:42', 1, '0000-00-00 00:00:00', 1),
('fr', 'français', b'0', 8, '2014-01-17 18:21:42', 1, '0000-00-00 00:00:00', 1),
('it', 'italiano', b'0', 6, '2014-01-22 07:28:48', 1, '2014-01-22 07:34:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_region`
--

CREATE TABLE IF NOT EXISTS `gc_mst_region` (
  `region_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `gc_mst_region`
--

INSERT INTO `gc_mst_region` (`region_id`) VALUES
(2),
(14);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_region_locale`
--

CREATE TABLE IF NOT EXISTS `gc_mst_region_locale` (
  `region_id` int(11) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `state_id` int(11) NOT NULL,
  `region_name` varchar(100) NOT NULL,
  `region_status` bit(1) NOT NULL DEFAULT b'1',
  `region_priority` int(11) NOT NULL,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`language_code`,`region_id`),
  KEY `fk_regionlocale_stateid` (`state_id`),
  KEY `fk_regionlocale_createdby` (`created_by`),
  KEY `fk_regionlocale_updatedby` (`updated_by`),
  KEY `fk_regionlocale_regionid` (`region_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_mst_region_locale`
--

INSERT INTO `gc_mst_region_locale` (`region_id`, `language_code`, `state_id`, `region_name`, `region_status`, `region_priority`, `create_timestamp`, `created_by`, `update_timestamp`, `updated_by`) VALUES
(2, 'en_us', 1, 'Jaipur', b'1', 2, '2014-01-21 06:33:02', 1, '2014-01-21 06:34:03', 1),
(14, 'en_us', 8, 'Delhi', b'1', 6, '2014-01-27 11:58:20', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_state`
--

CREATE TABLE IF NOT EXISTS `gc_mst_state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `gc_mst_state`
--

INSERT INTO `gc_mst_state` (`state_id`) VALUES
(1),
(8);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_state_locale`
--

CREATE TABLE IF NOT EXISTS `gc_mst_state_locale` (
  `state_id` int(11) NOT NULL,
  `language_code` varchar(5) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `state_status` bit(1) NOT NULL DEFAULT b'1',
  `state_priority` int(11) NOT NULL,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`language_code`,`state_id`),
  KEY `fk_statelocale_countrycode` (`country_code`),
  KEY `fk_statelocale_createdby` (`created_by`),
  KEY `fk_statelocale_updatedby` (`updated_by`),
  KEY `fk_statelocale_stateid` (`state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_mst_state_locale`
--

INSERT INTO `gc_mst_state_locale` (`state_id`, `language_code`, `country_code`, `state_name`, `state_status`, `state_priority`, `create_timestamp`, `created_by`, `update_timestamp`, `updated_by`) VALUES
(1, 'en_us', 'IN', 'Rajasthan', b'1', 1, '2014-01-21 04:35:35', NULL, '2014-01-21 04:35:35', NULL),
(8, 'en_us', 'IN', 'Delhi', b'1', 8, '2014-01-27 11:58:00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_timezone`
--

CREATE TABLE IF NOT EXISTS `gc_mst_timezone` (
  `timezone` varchar(50) NOT NULL,
  `timezone_display` varchar(150) NOT NULL,
  `status` char(1) DEFAULT 'a',
  PRIMARY KEY (`timezone`),
  UNIQUE KEY `timezone` (`timezone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gc_mst_timezone`
--

INSERT INTO `gc_mst_timezone` (`timezone`, `timezone_display`, `status`) VALUES
('Africa/Abidjan', '(GMT) Monrovia, Reykjavik', 'a'),
('Africa/Addis_Ababa', '(GMT+03:00) Nairobi', 'a'),
('Africa/Algiers', '(GMT+01:00) West Central Africa', 'a'),
('Africa/Blantyre', '(GMT+02:00) Harare, Pretoria', 'a'),
('Africa/Cairo', '(GMT+02:00) Cairo', 'a'),
('Africa/Windhoek', '(GMT+01:00) Windhoek', 'a'),
('America/Adak', '(GMT-10:00) Hawaii-Aleutian', 'a'),
('America/Anchorage', '(GMT-09:00) Alaska', 'a'),
('America/Araguaina', '(GMT-03:00) UTC-3', 'a'),
('America/Argentina/Buenos_Aires', '(GMT-03:00) Buenos Aires', 'a'),
('America/Belize', '(GMT-06:00) Saskatchewan, Central America', 'a'),
('America/Bogota', '(GMT-05:00) Bogota, Lima, Quito, Rio Branco', 'a'),
('America/Campo_Grande', '(GMT-04:00) Brazil', 'a'),
('America/Cancun', '(GMT-06:00) Guadalajara, Mexico City, Monterrey', 'a'),
('America/Caracas', '(GMT-04:30) Caracas', 'a'),
('America/Chicago', '(GMT-06:00) Central Time (US & Canada)', 'a'),
('America/Chihuahua', '(GMT-07:00) Chihuahua, La Paz, Mazatlan', 'a'),
('America/Dawson_Creek', '(GMT-07:00) Arizona', 'a'),
('America/Denver', '(GMT-07:00) Mountain Time (US & Canada)', 'a'),
('America/Ensenada', '(GMT-08:00) Tijuana, Baja California', 'a'),
('America/Glace_Bay', '(GMT-04:00) Atlantic Time (Canada)', 'a'),
('America/Godthab', '(GMT-03:00) Greenland', 'a'),
('America/Goose_Bay', '(GMT-04:00) Atlantic Time (Goose Bay)', 'a'),
('America/Havana', '(GMT-05:00) Cuba', 'a'),
('America/La_Paz', '(GMT-04:00) La Paz', 'a'),
('America/Los_Angeles', '(GMT-08:00) Pacific Time (US & Canada)', 'a'),
('America/Miquelon', '(GMT-03:00) Miquelon, St. Pierre', 'a'),
('America/Montevideo', '(GMT-03:00) Montevideo', 'a'),
('America/New_York', '(GMT-05:00) Eastern Time (US & Canada)', 'a'),
('America/Noronha', '(GMT-02:00) Mid-Atlantic', 'a'),
('America/Santiago', '(GMT-04:00) Santiago', 'a'),
('America/Sao_Paulo', '(GMT-03:00) Brasilia', 'a'),
('America/St_Johns', '(GMT-03:30) Newfoundland', 'a'),
('Asia/Anadyr', '(GMT+12:00) Anadyr, Kamchatka', 'a'),
('Asia/Bangkok', '(GMT+07:00) Bangkok, Hanoi, Jakarta', 'a'),
('Asia/Beirut', '(GMT+02:00) Beirut', 'a'),
('Asia/Damascus', '(GMT+02:00) Syria', 'a'),
('Asia/Dhaka', '(GMT+06:00) Astana, Dhaka', 'a'),
('Asia/Dubai', '(GMT+04:00) Abu Dhabi, Muscat', 'a'),
('Asia/Gaza', '(GMT+02:00) Gaza', 'a'),
('Asia/Hong_Kong', '(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi', 'a'),
('Asia/Irkutsk', '(GMT+08:00) Irkutsk, Ulaan Bataar', 'a'),
('Asia/Jerusalem', '(GMT+02:00) Jerusalem', 'a'),
('Asia/Kabul', '(GMT+04:30) Kabul', 'a'),
('Asia/Katmandu', '(GMT+05:45) Kathmandu', 'a'),
('Asia/Kolkata', '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi', 'a'),
('Asia/Krasnoyarsk', '(GMT+07:00) Krasnoyarsk', 'a'),
('Asia/Magadan', '(GMT+11:00) Magadan', 'a'),
('Asia/Novosibirsk', '(GMT+06:00) Novosibirsk', 'a'),
('Asia/Rangoon', '(GMT+06:30) Yangon (Rangoon)', 'a'),
('Asia/Seoul', '(GMT+09:00) Seoul', 'a'),
('Asia/Tashkent', '(GMT+05:00) Tashkent', 'a'),
('Asia/Tehran', '(GMT+03:30) Tehran', 'a'),
('Asia/Tokyo', '(GMT+09:00) Osaka, Sapporo, Tokyo', 'a'),
('Asia/Vladivostok', '(GMT+10:00) Vladivostok', 'a'),
('Asia/Yakutsk', '(GMT+09:00) Yakutsk', 'a'),
('Asia/Yekaterinburg', '(GMT+05:00) Ekaterinburg', 'a'),
('Asia/Yerevan', '(GMT+04:00) Yerevan', 'a'),
('Atlantic/Azores', '(GMT-01:00) Azores', 'a'),
('Atlantic/Cape_Verde', '(GMT-01:00) Cape Verde Is', 'a'),
('Atlantic/Stanley', '(GMT-04:00) Faukland Islands', 'a'),
('Australia/Adelaide', '(GMT+09:30) Adelaide', 'a'),
('Australia/Brisbane', '(GMT+10:00) Brisbane', 'a'),
('Australia/Darwin', '(GMT+09:30) Darwin', 'a'),
('Australia/Eucla', '(GMT+08:45) Eucla', 'a'),
('Australia/Hobart', '(GMT+10:00) Hobart', 'a'),
('Australia/Lord_Howe', '(GMT+10:30) Lord Howe Island', 'a'),
('Australia/Perth', '(GMT+08:00) Perth', 'a'),
('Chile/EasterIsland', '(GMT-06:00) Easter Island', 'a'),
('Etc/GMT+10', '(GMT-10:00) Hawaii', 'a'),
('Etc/GMT+8', '(GMT-08:00) Pitcairn Islands', 'a'),
('Etc/GMT-11', '(GMT+11:00) Solomon Is., New Caledonia', 'a'),
('Etc/GMT-12', '(GMT+12:00) Fiji, Kamchatka, Marshall Is', 'a'),
('Europe/Amsterdam', '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna', 'a'),
('Europe/Belfast', '(GMT) Greenwich Mean Time : Belfast', 'a'),
('Europe/Belgrade', '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague', 'a'),
('Europe/Brussels', '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris', 'a'),
('Europe/Dublin', '(GMT) Greenwich Mean Time : Dublin', 'a'),
('Europe/Lisbon', '(GMT) Greenwich Mean Time : Lisbon', 'a'),
('Europe/London', '(GMT) Greenwich Mean Time : London', 'a'),
('Europe/Minsk', '(GMT+02:00) Minsk', 'a'),
('Europe/Moscow', '(GMT+03:00) Moscow, St. Petersburg, Volgograd', 'a'),
('Pacific/Auckland', '(GMT+12:00) Auckland, Wellington', 'a'),
('Pacific/Chatham', '(GMT+12:45) Chatham Islands', 'a'),
('Pacific/Gambier', '(GMT-09:00) Gambier Islands', 'a'),
('Pacific/Kiritimati', '(GMT+14:00) Kiritimati', 'a'),
('Pacific/Marquesas', '(GMT-09:30) Marquesas Islands', 'a'),
('Pacific/Midway', '(GMT-11:00) Midway Island, Samoa', 'a'),
('Pacific/Norfolk', '(GMT+11:30) Norfolk Island', 'a'),
('Pacific/Tongatapu', '(GMT+13:00) Nuku''alofa', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `gc_mst_userrole`
--

CREATE TABLE IF NOT EXISTS `gc_mst_userrole` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(40) NOT NULL,
  `role_permission` longtext,
  `create_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_timestamp` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `uk_userrole_rolename` (`role_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gc_mst_userrole`
--

INSERT INTO `gc_mst_userrole` (`role_id`, `role_name`, `role_permission`, `create_timestamp`, `created_by`, `update_timestamp`, `updated_by`) VALUES
(1, 'forcountry', 'a:1:{s:7:"Country";a:3:{s:13:"create,update";s:1:"1";s:6:"delete";s:1:"1";s:4:"list";s:1:"1";}}', '2014-01-23 07:25:13', 1, NULL, NULL),
(2, 'editor', 'a:7:{s:5:"Admin";a:2:{s:13:"create,update";s:1:"1";s:4:"list";s:1:"1";}s:7:"Country";a:2:{s:13:"create,update";s:1:"1";s:4:"list";s:1:"1";}s:5:"State";a:2:{s:13:"create,update";s:1:"1";s:4:"list";s:1:"1";}s:6:"Region";a:2:{s:13:"create,update";s:1:"1";s:4:"list";s:1:"1";}s:4:"City";a:2:{s:13:"create,update";s:1:"1";s:4:"list";s:1:"1";}s:8:"Category";a:2:{s:13:"create,update";s:1:"1";s:4:"list";s:1:"1";}s:16:"CategoryQuestion";a:3:{s:13:"create,update";s:1:"1";s:6:"delete";s:1:"1";s:4:"list";s:1:"1";}}', '2014-01-23 07:25:34', 1, '2014-02-05 12:19:01', 1),
(3, 'forlocation', 'a:4:{s:7:"Country";a:3:{s:13:"create,update";s:1:"1";s:6:"delete";s:1:"1";s:4:"list";s:1:"1";}s:5:"State";a:3:{s:13:"create,update";s:1:"1";s:6:"delete";s:1:"1";s:4:"list";s:1:"1";}s:6:"Region";a:3:{s:13:"create,update";s:1:"1";s:6:"delete";s:1:"1";s:4:"list";s:1:"1";}s:4:"City";a:3:{s:13:"create,update";s:1:"1";s:6:"delete";s:1:"1";s:4:"list";s:1:"1";}}', '2014-01-23 07:25:57', 1, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gc_dta_task`
--
ALTER TABLE `gc_dta_task`
  ADD CONSTRAINT `fk_gc_dta_task_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gc_dta_task_language_code` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_gc_dta_task_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_dta_task_category`
--
ALTER TABLE `gc_dta_task_category`
  ADD CONSTRAINT `fk_task_category_category_id` FOREIGN KEY (`category_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_category_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_category_language_code` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_category_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_category_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_dta_task_reference`
--
ALTER TABLE `gc_dta_task_reference`
  ADD CONSTRAINT `fk_task_reference_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_reference_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_reference_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_reference_verified_by` FOREIGN KEY (`verified_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_dta_task_speciality`
--
ALTER TABLE `gc_dta_task_speciality`
  ADD CONSTRAINT `fk_task_speciality_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_speciality_speciality_id` FOREIGN KEY (`speciality_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_speciality_task_id` FOREIGN KEY (`task_id`) REFERENCES `gc_dta_task` (`task_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_task_speciality_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_dta_user`
--
ALTER TABLE `gc_dta_user`
  ADD CONSTRAINT `fk_dtauser_cityid` FOREIGN KEY (`city_id`) REFERENCES `gc_mst_city` (`city_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dtauser_countrycode` FOREIGN KEY (`country_code`) REFERENCES `gc_mst_country` (`country_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dtauser_regionid` FOREIGN KEY (`region_id`) REFERENCES `gc_mst_region` (`region_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dtauser_stateid` FOREIGN KEY (`state_id`) REFERENCES `gc_mst_state` (`state_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_dta_user_contact`
--
ALTER TABLE `gc_dta_user_contact`
  ADD CONSTRAINT `fk_dtausercontact_userid` FOREIGN KEY (`user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_dta_user_contact_pending`
--
ALTER TABLE `gc_dta_user_contact_pending`
  ADD CONSTRAINT `fk_dtausercontactpending_userid` FOREIGN KEY (`user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_dta_user_speciality`
--
ALTER TABLE `gc_dta_user_speciality`
  ADD CONSTRAINT `fk_dtauserspeciality_categoryid` FOREIGN KEY (`category_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dtauserspeciality_cityid` FOREIGN KEY (`city_id`) REFERENCES `gc_mst_city` (`city_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dtauserspeciality_countrycode` FOREIGN KEY (`country_code`) REFERENCES `gc_mst_country` (`country_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dtauserspeciality_regionid` FOREIGN KEY (`region_id`) REFERENCES `gc_mst_region` (`region_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dtauserspeciality_stateid` FOREIGN KEY (`state_id`) REFERENCES `gc_mst_state` (`state_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dtauserspeciality_userid` FOREIGN KEY (`user_id`) REFERENCES `gc_dta_user` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_mst_adminuser`
--
ALTER TABLE `gc_mst_adminuser`
  ADD CONSTRAINT `gc_mst_adminuser_ibfk_1` FOREIGN KEY (`user_roleid`) REFERENCES `gc_mst_userrole` (`role_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_adminuser_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_adminuser_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_mst_category_locale`
--
ALTER TABLE `gc_mst_category_locale`
  ADD CONSTRAINT `gc_mst_category_locale_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_category_locale_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_category_locale_ibfk_3` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_category_locale_ibfk_4` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_category_locale_ibfk_5` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_mst_category_question_locale`
--
ALTER TABLE `gc_mst_category_question_locale`
  ADD CONSTRAINT `fk_category_question_locale_category_id` FOREIGN KEY (`category_id`) REFERENCES `gc_mst_category` (`category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_question_locale_created_by` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`created_by`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_question_locale_language_code` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_question_locale_question_id` FOREIGN KEY (`question_id`) REFERENCES `gc_mst_category_question` (`question_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_category_question_locale_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`updated_by`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_mst_city_locale`
--
ALTER TABLE `gc_mst_city_locale`
  ADD CONSTRAINT `gc_mst_city_locale_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `gc_mst_region` (`region_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_city_locale_ibfk_2` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_city_locale_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_city_locale_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_city_locale_ibfk_5` FOREIGN KEY (`city_id`) REFERENCES `gc_mst_city` (`city_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_mst_country_locale`
--
ALTER TABLE `gc_mst_country_locale`
  ADD CONSTRAINT `gc_mst_country_locale_ibfk_1` FOREIGN KEY (`country_code`) REFERENCES `gc_mst_country` (`country_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_country_locale_ibfk_2` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_country_locale_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_country_locale_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_mst_language`
--
ALTER TABLE `gc_mst_language`
  ADD CONSTRAINT `gc_mst_language_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_language_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_mst_region_locale`
--
ALTER TABLE `gc_mst_region_locale`
  ADD CONSTRAINT `gc_mst_region_locale_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `gc_mst_state` (`state_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_region_locale_ibfk_2` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_region_locale_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_region_locale_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_region_locale_ibfk_5` FOREIGN KEY (`region_id`) REFERENCES `gc_mst_region` (`region_id`) ON UPDATE CASCADE;

--
-- Constraints for table `gc_mst_state_locale`
--
ALTER TABLE `gc_mst_state_locale`
  ADD CONSTRAINT `gc_mst_state_locale_ibfk_1` FOREIGN KEY (`country_code`) REFERENCES `gc_mst_country` (`country_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_state_locale_ibfk_2` FOREIGN KEY (`language_code`) REFERENCES `gc_mst_language` (`language_code`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_state_locale_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_state_locale_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `gc_mst_adminuser` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gc_mst_state_locale_ibfk_5` FOREIGN KEY (`state_id`) REFERENCES `gc_mst_state` (`state_id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
