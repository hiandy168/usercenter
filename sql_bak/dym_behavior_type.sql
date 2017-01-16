# Host: localhost  (Version: 5.5.47)
# Date: 2016-03-31 17:00:12
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "dym_behavior_type"
#

DROP TABLE IF EXISTS `dym_behavior_type`;
CREATE TABLE `dym_behavior_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '行为名称',
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户行为类型';

#
# Data for table "dym_behavior_type"
#

/*!40000 ALTER TABLE `dym_behavior_type` DISABLE KEYS */;
INSERT INTO `dym_behavior_type` VALUES (1,0,'抽奖',1,0);
/*!40000 ALTER TABLE `dym_behavior_type` ENABLE KEYS */;
