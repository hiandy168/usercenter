/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : chuangye

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-03-31 11:30:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dym_checkin_log`
-- ----------------------------
DROP TABLE IF EXISTS `dym_checkin_log`;
CREATE TABLE `dym_checkin_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志主键',
  `mid` int(11) NOT NULL COMMENT '会员ID',
  `pid` int(11) NOT NULL COMMENT '商户ID',
  `openid` varchar(50) NOT NULL COMMENT '商户openid',
  `point` int(11) DEFAULT '0' COMMENT '签到送积分',
  `type` varchar(4) DEFAULT NULL COMMENT '签到类型',
  `sign_time` int(11) DEFAULT NULL COMMENT '签到时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dym_checkin_log
-- ----------------------------
INSERT INTO `dym_checkin_log` VALUES ('1', '0', '123', '12346', '0', null, null);
INSERT INTO `dym_checkin_log` VALUES ('2', '111', '0', '12312346', '5', null, '1459244079');
INSERT INTO `dym_checkin_log` VALUES ('3', '111', '0', '12312346', '5', null, '1459300844');
