-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- 主機: localhost
-- 產生日期: 2013 年 11 月 02 日 01:50
-- 伺服器版本: 5.5.27
-- PHP 版本: 5.4.7

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `ntec`
--

-- --------------------------------------------------------

-- 
-- 表的結構 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `member_serial` int(11) NOT NULL,
  `name` varchar(32) NOT NULL DEFAULT '',
  `id` varchar(32) NOT NULL DEFAULT '',
  `pw` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `affiliation` varchar(32) DEFAULT NULL,
  `position` varchar(32) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `fax` varchar(32) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `address` varchar(64) DEFAULT NULL
  --PRIMARY KEY (`Member_serial`),
  --UNIQUE KEY `Member_serial` (`Member_serial`)
);

-- --------------------------------------------------------

--
-- 表的結構 `paper_distribute`
--

CREATE TABLE IF NOT EXISTS `paper_distribute` (
  `paper` int(11) NOT NULL DEFAULT '0',
  `referee1` char(31) NOT NULL DEFAULT '',
  `referee2` char(31) DEFAULT NULL,
  `referee3` char(31) DEFAULT NULL,
  `finish1` enum('y','n') NOT NULL DEFAULT 'n',
  `finish2` enum('y','n') NOT NULL DEFAULT 'n',
  `finish3` enum('y','n') NOT NULL DEFAULT 'n',
  `result1` tinyint(4) DEFAULT NULL,
  `result2` tinyint(4) DEFAULT NULL,
  `result3` tinyint(4) DEFAULT NULL
  --PRIMARY KEY (`paper`)
);

-- --------------------------------------------------------

--
-- 表的結構 `receipt`
--

CREATE TABLE IF NOT EXISTS `receipt` (
  `s` int(11) NOT NULL,
  `memberid` varchar(32) NOT NULL,
  `paper` varchar(32) NOT NULL,
  `contact` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `memo` text,
  `uploadtime` varchar(64) NOT NULL,
  `confirmed` varchar(2) NOT NULL DEFAULT 'N'
  --PRIMARY KEY (`s`)
);

-- --------------------------------------------------------

--
-- 表的結構 `referee`
--

CREATE TABLE IF NOT EXISTS `referee` (
  `id` char(31) NOT NULL DEFAULT '',
  `password` char(31) NOT NULL DEFAULT '',
  `name` char(31) NOT NULL DEFAULT '',
  `location` enum('oral','network') NOT NULL DEFAULT 'oral',
  `affiliation` char(127) NOT NULL DEFAULT '',
  `profession` varchar(64) NOT NULL,
  `phone` char(31) NOT NULL DEFAULT '',
  `email` char(63) NOT NULL DEFAULT '',
  `address` char(127) NOT NULL DEFAULT '',
  `distribute` tinyint(1) NOT NULL DEFAULT '0',
  `alart` enum('y','n') NOT NULL DEFAULT 'n'
  --PRIMARY KEY (`ID`)
);

-- --------------------------------------------------------

--
-- 表的結構 `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `serial` varchar(34) NOT NULL DEFAULT '',
  `item1` tinyint(1) DEFAULT NULL,
  `item2` tinyint(1) DEFAULT NULL,
  `item3` tinyint(1) DEFAULT NULL,
  `item4` tinyint(1) DEFAULT NULL,
  `item5` tinyint(1) DEFAULT NULL,
  `item6` tinyint(1) DEFAULT NULL,
  `item7` tinyint(1) DEFAULT NULL,
  `item8` tinyint(1) DEFAULT NULL,
  `item9` tinyint(1) NOT NULL DEFAULT '0',
  `toauthor` text,
  `tohoster` text
  --PRIMARY KEY (`serial`)
);

-- --------------------------------------------------------

--
-- 表的結構 `upload`
--

CREATE TABLE IF NOT EXISTS `upload` (
  `paper_serial` int(11) NOT NULL,
  `member` varchar(32) NOT NULL DEFAULT '',
  `topic` varchar(255) NOT NULL,
  `class` varchar(32) NOT NULL DEFAULT '',
  `group` varchar(32) NOT NULL DEFAULT '',
  `contact` varchar(32) NOT NULL DEFAULT '',
  `affiliation` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `phone` varchar(32) DEFAULT NULL,
  `fax` varchar(32) DEFAULT NULL,
  `author1` varchar(32) DEFAULT NULL,
  `author1_email` varchar(96) DEFAULT NULL,
  `author2` varchar(32) DEFAULT NULL,
  `author2_email` varchar(96) DEFAULT NULL,
  `author3` varchar(32) DEFAULT NULL,
  `author3_email` varchar(96) DEFAULT NULL,
  `author4` varchar(32) DEFAULT NULL,
  `author4_email` varchar(96) DEFAULT NULL,
  `author5` varchar(32) DEFAULT NULL,
  `author5_email` varchar(96) DEFAULT NULL,
  `author6` varchar(32) DEFAULT NULL,
  `author6_email` varchar(96) DEFAULT NULL,
  `file_paper` varchar(32) DEFAULT NULL,
  `file_abstract` varchar(32) DEFAULT NULL,
  `receive` enum('a','r','n') NOT NULL DEFAULT 'n',
  `camready` enum('y','n') NOT NULL DEFAULT 'n'
  --PRIMARY KEY (`Paper_serial`),
  --UNIQUE KEY `Paper_serial` (`Paper_serial`)
);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
