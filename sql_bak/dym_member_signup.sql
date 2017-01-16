/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : chuangye

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-03-31 09:46:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dym_member_signup`
-- ----------------------------
DROP TABLE IF EXISTS `dym_member_signup`;
CREATE TABLE `dym_member_signup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL COMMENT '会员id',
  `pid` int(11) NOT NULL COMMENT '项目id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `type` tinyint(2) DEFAULT NULL COMMENT '报名类型',
  `description` varchar(200) DEFAULT NULL COMMENT '描述',
  `create_time` int(11) NOT NULL COMMENT '报名时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dym_member_signup
-- ----------------------------
