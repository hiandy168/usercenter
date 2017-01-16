# Host: localhost  (Version: 5.5.47)
# Date: 2016-03-28 17:52:28
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "dym_project_token"
#

DROP TABLE IF EXISTS `dym_project_token`;
CREATE TABLE `dym_project_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '商家id',
  `access_token` varchar(128) NOT NULL DEFAULT '0' COMMENT 'access_token',
  `expires_in` int(11) NOT NULL DEFAULT '0' COMMENT 'access_token生成时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "dym_project_token"
#

/*!40000 ALTER TABLE `dym_project_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `dym_project_token` ENABLE KEYS */;
