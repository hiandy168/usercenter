/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : chuangye

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2016-03-30 15:29:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dym_member`
-- ----------------------------
DROP TABLE IF EXISTS `dym_member`;
CREATE TABLE `dym_member` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `tel` varchar(50) NOT NULL DEFAULT '0' COMMENT '用户手机号',
  `username` varchar(50) NOT NULL DEFAULT '0',
  `points` int(11) DEFAULT '0' COMMENT '用户积分',
  `group_id` int(8) unsigned NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '0',
  `headimgurl` varchar(255) NOT NULL DEFAULT '0' COMMENT '头像',
  `vip_level` int(11) NOT NULL DEFAULT '1' COMMENT '会员等级',
  `sex` varchar(32) NOT NULL DEFAULT '1' COMMENT '1为男性，2为女性',
  `email` varchar(50) NOT NULL DEFAULT '0',
  `province` varchar(64) NOT NULL DEFAULT '0',
  `city` varchar(64) NOT NULL DEFAULT '0',
  `country` varchar(64) NOT NULL DEFAULT '0',
  `address` varchar(100) NOT NULL DEFAULT '0',
  `authentication` int(1) NOT NULL DEFAULT '0' COMMENT '1认证 0未认证',
  `regip` char(15) NOT NULL DEFAULT '127.0.0.1',
  `regtime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastlogintime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastloginip` char(15) NOT NULL DEFAULT '0',
  `logincount` int(11) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remark` varchar(255) NOT NULL DEFAULT '0',
  `source` varchar(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dym_member
-- ----------------------------
INSERT INTO `dym_member` VALUES ('18', 'wenlijiang', '', '', null, '0', '50201dd75483f7d724dbc53a744579be', '', '1', '', '', '', '', '', '', '0', '', '0', '0', '', '0', '1', '', 'gye7j');
INSERT INTO `dym_member` VALUES ('28', '15997567510', '', '', null, '1', '3982045fab225be9d2b5c111b6a9f823', '', '1', '', '', '', '', '', '', '0', '127.0.0.1', '1458283566', '0', '', '0', '1', '', 'rwfet');
INSERT INTO `dym_member` VALUES ('43', '15827019619', '0', '0', null, '1', '5110d748139acc45eea02f8cbedc2d45', '0', '1', '1', '0', '0', '0', '0', '0', '0', '127.0.0.1', '1458807723', '0', '0', '0', '1', '0', 'oke2j');
INSERT INTO `dym_member` VALUES ('44', '18888888888', '0', '0', null, '1', '717c2e8b1c732ed76342df8ba7161c44', '0', '1', '1', '0', '0', '0', '0', '0', '0', '127.0.0.1', '1458888437', '0', '0', '0', '1', '0', 'ckz2d');
INSERT INTO `dym_member` VALUES ('45', '18888888889', '0', '0', null, '1', 'c3a6efacb57569c0eb1a4b8e4cfac337', '0', '1', '1', '0', '0', '0', '0', '0', '0', '127.0.0.1', '1458888893', '0', '0', '0', '1', '0', 'xwu03');
INSERT INTO `dym_member` VALUES ('46', '15827019618', '0', '0', null, '1', 'dd36b13815f08130619cd87eda4aef2d', '0', '1', '1', '0', '0', '0', '0', '0', '0', '127.0.0.1', '1458889377', '0', '0', '0', '1', '0', 'ojpm0');
INSERT INTO `dym_member` VALUES ('47', '15827019626', '0', '0', null, '1', '913018a22256c3bc8d595c1dbfc8e940', '0', '1', '1', '0', '0', '0', '0', '0', '0', '127.0.0.1', '1458889411', '0', '0', '0', '1', '0', 'cmd5q');
INSERT INTO `dym_member` VALUES ('48', '15827019610', '0', '0', null, '1', '8f87a2f013c4109c9a0f9b5424a5ff13', '0', '1', '1', '0', '0', '0', '0', '0', '0', '127.0.0.1', '1458892318', '0', '0', '0', '1', '0', 'dxd0g');
