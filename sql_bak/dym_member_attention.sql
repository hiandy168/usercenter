# Host: localhost  (Version: 5.5.47)
# Date: 2016-03-30 17:42:49
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "dym_member_attention"
#

DROP TABLE IF EXISTS `dym_member_attention`;
CREATE TABLE `dym_member_attention` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '关注人id',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '被关注人id',
  `state` varchar(25) NOT NULL DEFAULT '0' COMMENT '状态',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "dym_member_attention"
#

/*!40000 ALTER TABLE `dym_member_attention` DISABLE KEYS */;
/*!40000 ALTER TABLE `dym_member_attention` ENABLE KEYS */;
