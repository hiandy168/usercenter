/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : chuangye

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-03-31 16:53:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dym_lottery_log`
-- ----------------------------
DROP TABLE IF EXISTS `dym_lottery_log`;
CREATE TABLE `dym_lottery_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL COMMENT '会员ID',
  `pid` int(11) NOT NULL COMMENT '项目ID',
  `tro_level` tinyint(1) NOT NULL COMMENT '奖品等级',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:表示大转盘;1:表示刮刮乐',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:表示未中奖;1:表示中奖',
  `create_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '抽奖时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dym_lottery_log
-- ----------------------------
