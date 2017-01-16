# Host: localhost  (Version: 5.5.47)
# Date: 2016-03-28 13:57:46
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "dym_company"
#

DROP TABLE IF EXISTS `dym_company`;
CREATE TABLE `dym_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `appid` varchar(255) DEFAULT NULL,
  `appkey` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "dym_company"
#

/*!40000 ALTER TABLE `dym_company` DISABLE KEYS */;
INSERT INTO `dym_company` VALUES (1,'腾讯大楚网','1103279082','2D3OBQuaVKLCh7nk','1');
/*!40000 ALTER TABLE `dym_company` ENABLE KEYS */;
