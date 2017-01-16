# Host: localhost  (Version: 5.5.47)
# Date: 2016-03-31 16:55:10
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "dym_member_behavior"
#

DROP TABLE IF EXISTS `dym_member_behavior`;
CREATE TABLE `dym_member_behavior` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(128) NOT NULL DEFAULT '' COMMENT '对应商家的微信公众号的openid',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '公司id',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `remark` varchar(255) DEFAULT NULL COMMENT '简介',
  `type` int(11) DEFAULT NULL COMMENT '用户行为类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商家';

#
# Data for table "dym_member_behavior"
#

/*!40000 ALTER TABLE `dym_member_behavior` DISABLE KEYS */;
/*!40000 ALTER TABLE `dym_member_behavior` ENABLE KEYS */;
