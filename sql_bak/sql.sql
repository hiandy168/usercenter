/**ALTER TABLE `dym_member` ADD COLUMN `mobile` varchar(32) NULL DEFAULT '0' AFTER `phone`**/


CREATE TABLE `dym_sign_log` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志主键',  `mid` int(11) NOT NULL COMMENT '会员ID',  `pid` int(11) NOT NULL COMMENT '商户ID',  `openid` varchar(50) NOT NULL COMMENT '商户openid',  `point` int(11) DEFAULT '0' COMMENT '签到送积分',  `type` varchar(4) DEFAULT NULL COMMENT '签到类型',  `sign_time` int(11) DEFAULT NULL COMMENT '签到时间',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8