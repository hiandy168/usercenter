/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : chuangye

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-03-31 09:21:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dym_member_extension`
-- ----------------------------
DROP TABLE IF EXISTS `dym_member_extension`;
CREATE TABLE `dym_member_extension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL COMMENT '项目ID',
  `openid` varchar(100) NOT NULL COMMENT '会员openid',
  `mid` int(11) NOT NULL COMMENT '会员ID',
  `type` tinyint(2) NOT NULL COMMENT '商户类型',
  `content` varchar(200) NOT NULL COMMENT '内容',
  `remark` varchar(100) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) NOT NULL COMMENT '创建时间(时间戳)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dym_member_extension
-- ----------------------------
