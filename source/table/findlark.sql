/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : yiiblog

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2012-12-11 20:03:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `lark_extends`
-- ----------------------------
DROP TABLE IF EXISTS `lark_extends`;
CREATE TABLE `lark_extends` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `path` varchar(200) NOT NULL COMMENT '路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lark_extends
-- ----------------------------

-- ----------------------------
-- Table structure for `lark_novel`
-- ----------------------------
DROP TABLE IF EXISTS `lark_novel`;
CREATE TABLE `lark_novel` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `title` varchar(200) NOT NULL COMMENT '标题',
  `summary` varchar(300) NOT NULL COMMENT '简介',
  `content` text NOT NULL COMMENT '内容',
  `display` tinyint(1) DEFAULT '0' COMMENT '是否显示 0 否 1 是',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=229 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lark_novel
-- ----------------------------

-- ----------------------------
-- Table structure for `lark_picture`
-- ----------------------------
DROP TABLE IF EXISTS `lark_picture`;
CREATE TABLE `lark_picture` (
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
) ENGINE=MyISAM AUTO_INCREMENT=184 DEFAULT CHARSET=utf8 COMMENT='图片';

-- ----------------------------
-- Records of lark_picture
-- ----------------------------

-- ----------------------------
-- Table structure for `urls`
-- ----------------------------
DROP TABLE IF EXISTS `urls`;
CREATE TABLE `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '编号',
  `url` varchar(200) NOT NULL,
  `hash` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=380 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of urls
-- ----------------------------
insert into lark_extends (`title`, `path`) VALUES ('JQuery插件-mini提示框', '1355226417');
