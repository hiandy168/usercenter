/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : chuangye

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-03-31 16:53:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dym_trophy_list`
-- ----------------------------
DROP TABLE IF EXISTS `dym_trophy_list`;
CREATE TABLE `dym_trophy_list` (
  `id` int(11) NOT NULL COMMENT '奖品名称',
  `pid` int(11) NOT NULL COMMENT '项目ID',
  `name` varchar(100) CHARACTER SET utf8 NOT NULL COMMENT '奖品名称',
  `prize_level` tinyint(1) NOT NULL COMMENT '奖品等级',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:正常;0:奖品已下线',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of dym_trophy_list
-- ----------------------------
