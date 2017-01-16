/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : chuangye

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-03-31 09:21:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dym_member_grade`
-- ----------------------------
DROP TABLE IF EXISTS `dym_member_grade`;
CREATE TABLE `dym_member_grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '积分最小值',
  `min` int(11) NOT NULL COMMENT '积分最小值',
  `max` int(11) NOT NULL COMMENT '积分最大值',
  `name` varchar(50) NOT NULL COMMENT '等级名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dym_member_grade
-- ----------------------------
INSERT INTO `dym_member_grade` VALUES ('1', '0', '100', 'vip1');
INSERT INTO `dym_member_grade` VALUES ('2', '101', '200', 'vip2');
INSERT INTO `dym_member_grade` VALUES ('3', '201', '300', 'vip3');
INSERT INTO `dym_member_grade` VALUES ('4', '301', '400', 'vip4');
