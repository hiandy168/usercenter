/**ALTER TABLE `dym_member` ADD COLUMN `mobile` varchar(32) NULL DEFAULT '0' AFTER `phone`**/


CREATE TABLE `dym_sign_log` (  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '��־����',  `mid` int(11) NOT NULL COMMENT '��ԱID',  `pid` int(11) NOT NULL COMMENT '�̻�ID',  `openid` varchar(50) NOT NULL COMMENT '�̻�openid',  `point` int(11) DEFAULT '0' COMMENT 'ǩ���ͻ���',  `type` varchar(4) DEFAULT NULL COMMENT 'ǩ������',  `sign_time` int(11) DEFAULT NULL COMMENT 'ǩ��ʱ��',  PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8