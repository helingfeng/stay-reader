/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50641
 Source Host           : localhost
 Source Database       : stay_reader

 Target Server Type    : MySQL
 Target Server Version : 50641
 File Encoding         : utf-8

 Date: 12/04/2018 15:25:12 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `sr_book`
-- ----------------------------
DROP TABLE IF EXISTS `sr_book`;
CREATE TABLE `sr_book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '图书名称',
  `author` varchar(30) NOT NULL DEFAULT '' COMMENT '作者',
  `image` varchar(255) NOT NULL DEFAULT '',
  `abstract` varchar(500) NOT NULL DEFAULT '' COMMENT '书籍简介，500字以内',
  `category` varchar(20) NOT NULL DEFAULT '' COMMENT '图书分类',
  `is_download` int(11) NOT NULL DEFAULT '0' COMMENT '是否下载',
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
--  Table structure for `sr_book_contents`
-- ----------------------------
DROP TABLE IF EXISTS `sr_book_contents`;
CREATE TABLE `sr_book_contents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `book_id` int(10) unsigned NOT NULL DEFAULT '0',
  `chapter` varchar(255) NOT NULL DEFAULT '' COMMENT '章节',
  `contents` text NOT NULL COMMENT '章节内容',
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25218 DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
