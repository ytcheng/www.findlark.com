-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 01 月 15 日 09:47
-- 服务器版本: 5.5.20
-- PHP 版本: 5.2.9-1

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
-- 表的结构 `lark_extends`
--

CREATE TABLE IF NOT EXISTS `lark_extends` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `path` varchar(200) NOT NULL COMMENT '路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='扩展' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `lark_extends`
--

INSERT INTO `lark_extends` (`id`, `title`, `path`) VALUES
(1, 'JQuery插件-mini提示框', '1355226417'),
(3, 'HTML5 绘制图片直方图', 'histogram');

-- --------------------------------------------------------

--
-- 表的结构 `lark_friend`
--

CREATE TABLE IF NOT EXISTS `lark_friend` (
  `uid` int(11) NOT NULL,
  `f_uid` int(11) NOT NULL,
  `timeline` int(10) NOT NULL COMMENT '成为好友时间',
  `remark` varchar(20) DEFAULT NULL COMMENT '备注',
  `group_id` int(11) DEFAULT '0' COMMENT '分组ID',
  PRIMARY KEY (`uid`,`f_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='好友关系表';

-- --------------------------------------------------------

--
-- 表的结构 `lark_friend_group`
--

CREATE TABLE IF NOT EXISTS `lark_friend_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '组名称',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户对好友的分组' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lark_image`
--

CREATE TABLE IF NOT EXISTS `lark_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `panoramio_id` int(11) NOT NULL COMMENT 'panoramio 网站上对应的图片ID',
  `src` varchar(300) NOT NULL COMMENT '图片链接',
  `title` varchar(200) DEFAULT '' COMMENT '图片标题',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图片' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `lark_image`
--

INSERT INTO `lark_image` (`id`, `panoramio_id`, `src`, `title`) VALUES
(10, 84493955, '/upload/2013/84493955/QXOOWHN.jpg', ''),
(11, 84493955, '/upload/2013/84493955/QXOOWHO.jpg', ''),
(12, 84493955, '/upload/2013/84493955/QXOOWHQ.jpg', '');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='标记' AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- 表的结构 `lark_novel`
--

CREATE TABLE IF NOT EXISTS `lark_novel` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `summary` varchar(300) NOT NULL COMMENT '简介',
  `content` text NOT NULL COMMENT '内容',
  `display` tinyint(1) DEFAULT '0' COMMENT '是否显示 0 否 1 是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lark_picture`
--

CREATE TABLE IF NOT EXISTS `lark_picture` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `title` varchar(100) NOT NULL COMMENT '图片标题',
  `classify` smallint(6) DEFAULT '0' COMMENT '分类，0 未分类',
  `tag` varchar(100) DEFAULT NULL COMMENT '标签',
  `desc` varchar(200) DEFAULT NULL COMMENT '描述',
  `timeline` int(10) NOT NULL COMMENT '添加时间',
  `width` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '图片实际宽度',
  `height` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '图片实际高度',
  `dir` varchar(200) NOT NULL COMMENT '图片保存路径',
  `name` char(8) NOT NULL,
  `ext` char(5) NOT NULL COMMENT '图片扩展名',
  `histogram` text COMMENT '直方图信息',
  `properties` text COMMENT '图片属性',
  `hash` char(16) NOT NULL COMMENT '图片hash值，16进制保存',
  `share_times` int(10) unsigned DEFAULT '0' COMMENT '被分享次数',
  `score` int(10) unsigned DEFAULT '0' COMMENT '图片评分',
  `display` tinyint(4) DEFAULT '0' COMMENT '是否显示， 0 否 1是',
  `original_url` varchar(200) DEFAULT NULL COMMENT '图片源地址',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `tag` (`tag`),
  KEY `hash` (`hash`),
  KEY `ext` (`ext`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图片' AUTO_INCREMENT=184 ;

-- --------------------------------------------------------

--
-- 表的结构 `lark_user`
--

CREATE TABLE IF NOT EXISTS `lark_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'user ID',
  `nickname` varchar(20) DEFAULT NULL COMMENT '昵称',
  `email` varchar(100) NOT NULL COMMENT '邮箱',
  `password` char(32) NOT NULL COMMENT '密码',
  `active` tinyint(1) DEFAULT '0' COMMENT '帐号是否激活，0 否 1 是',
  `jointime` int(10) NOT NULL COMMENT '注册时间',
  `avatar` varchar(100) DEFAULT NULL COMMENT '用户头像',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `lark_user`
--

INSERT INTO `lark_user` (`uid`, `nickname`, `email`, `password`, `active`, `jointime`, `avatar`) VALUES
(3, '老陌', '123@qq.com', 'f020e337d84833cd2e4cbdaa367b64dc', 1, 1358221044, '');

-- --------------------------------------------------------

--
-- 表的结构 `lark_user_data`
--

CREATE TABLE IF NOT EXISTS `lark_user_data` (
  `uid` int(11) NOT NULL,
  `sex` int(11) DEFAULT '0' COMMENT '性别0 保密 1男 2女',
  `longitude` float DEFAULT '0' COMMENT '纬度',
  `latitude` float DEFAULT '0' COMMENT '经度',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户资料';

-- --------------------------------------------------------

--
-- 表的结构 `lark_user_log`
--

CREATE TABLE IF NOT EXISTS `lark_user_log` (
  `uid` int(11) NOT NULL,
  `last_login_time` int(11) DEFAULT '0' COMMENT '最后登录时间',
  `login_failed_time` tinyint(4) DEFAULT '0' COMMENT '登录失败次数',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户日志';

-- --------------------------------------------------------

--
-- 表的结构 `urls`
--

CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `url` varchar(200) NOT NULL,
  `hash` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
