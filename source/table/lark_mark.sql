-- phpMyAdmin SQL Dump
-- version 3.5.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 01 月 13 日 12:59
-- 服务器版本: 5.5.27
-- PHP 版本: 5.3.19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `findlark`
--

-- --------------------------------------------------------

--
-- 表的结构 `lark_mark`
--

CREATE TABLE IF NOT EXISTS `lark_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `content` text COMMENT '内容',
  `latitude` float NOT NULL COMMENT '纬度',
  `longitude` float NOT NULL COMMENT '经度',
  `display` tinyint(4) NOT NULL DEFAULT '1',
  `timeline` int(10) NOT NULL COMMENT '发表时间',
  `author` varchar(20) DEFAULT NULL COMMENT '作者',
  `icon` varchar(10) DEFAULT 'say' COMMENT '标记图标',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
