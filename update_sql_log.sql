/**
     * @author Fancy
     * 签到添加分享图片，标签
     */

ALTER TABLE `dym_activity_pccheckin`
ADD COLUMN  `tag` varchar(200) DEFAULT NULL COMMENT '活动标签',
ADD COLUMN  `share_img` varchar(255) NOT NULL COMMENT '分享图片'


ALTER TABLE `dym_activity_vote`
ADD COLUMN  `rule` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1表示用户只能投一次票，2表示用户每天都可以投票',
ADD COLUMN  `isshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1表示开启，2表示关闭'


/*
	新增用户注册来源表
*/
DROP TABLE IF EXISTS `dym_member_activity`;
CREATE TABLE `dym_member_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '项目id',
  `model` varchar(255) NOT NULL DEFAULT '' COMMENT '活动模块名称',
  `createtime` int(11) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


/*组件表新增字段*/
ALTER TABLE `dym_activity`
ADD COLUMN `status`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '1启用  0不启用' AFTER `update_time`;

UPDATE dym_activity SET status=0 where id>6;


/*
	最后一次操作记录
*/


ALTER TABLE `dym_activity_bigwheel`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `pid`;


ALTER TABLE `dym_activity_duobao_gz_goods`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `pid`;

ALTER TABLE `dym_activity_pccheckin`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `pid`;


ALTER TABLE `dym_activity_poster`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `pid`;


ALTER TABLE `dym_activity_scratch`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `pid`;


ALTER TABLE `dym_activity_vote`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `pid`;


ALTER TABLE `dym_activity_bigwheel_prize`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `title`;


ALTER TABLE `dym_activity_scratch_prize`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `title`;

ALTER TABLE `dym_activity_vote_form`
ADD COLUMN `mid`  int(11) NOT NULL DEFAULT 0 COMMENT '用户id  主要是记录最后一次谁操作的用户id' AFTER `title`;





/*
微信分享开关
*/

ALTER TABLE `dym_activity_bigwheel`
ADD COLUMN `share_switch`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '分享开关，1开 0关' AFTER `tag`;

ALTER TABLE `dym_activity_scratch`
ADD COLUMN `share_switch`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '分享开关，1开 0关' AFTER `tag`;


/*
	数量显示开关
*/

ALTER TABLE `dym_activity_bigwheel`
ADD COLUMN `prize_number`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '数量开关，1开 0关' AFTER `tag`;




/*
追加活动ID wenlijiang
*/
ALTER TABLE `dym_activity_bigwheel_prize`
ADD COLUMN `aid`  int(11) NOT NULL DEFAULT 0 COMMENT '活动id' AFTER `title`;
ALTER TABLE `dym_activity_scratch_prize`
ADD COLUMN `aid`  int(11) NOT NULL DEFAULT 0 COMMENT '活动id' AFTER `title`;

/*
 奖品表wenlijiang
*/
ALTER TABLE `dym_activity_scratch_prize`
MODIFY COLUMN `name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '奖品名称（具体的奖品）' AFTER `mid`,
MODIFY COLUMN `count`  int(11) NULL DEFAULT 0 COMMENT '奖品数量' AFTER `name`,
MODIFY COLUMN `probability`  int(11) NULL DEFAULT 0 COMMENT '中奖概率' AFTER `count`,
MODIFY COLUMN `remainder`  int(11) NULL DEFAULT 0 COMMENT '剩余奖品' AFTER `probability`,
MODIFY COLUMN `img`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '奖品图片' AFTER `remainder`;

/*
 奖品表wenlijiang
*/

ALTER TABLE `dym_activity_bigwheel_prize`
ADD COLUMN `status`  int(1) NOT NULL DEFAULT 0 COMMENT '状态值' AFTER `img`,
ADD COLUMN `updatetime`  int(11) NOT NULL DEFAULT 0 AFTER `status`,
ADD COLUMN `createtime`  int(11) NOT NULL DEFAULT 0 AFTER `updatetime`;

/*
 奖品表wenlijiang
*/
ALTER TABLE `dym_activity_scratch_prize`
ADD COLUMN `status`  int(1) NOT NULL DEFAULT 0 COMMENT '状态值' AFTER `img`,
ADD COLUMN `updatetime`  int(11) NOT NULL DEFAULT 0 AFTER `status`,
ADD COLUMN `createtime`  int(11) NOT NULL DEFAULT 0 AFTER `updatetime`;


/*
投票-用户持有票数
*/
ALTER TABLE `dym_activity_vote`
ADD COLUMN `hold_vote`  tinyint(3) NOT NULL DEFAULT 1 COMMENT '用户持有票数' AFTER `phone`;

/*
会员分组权限字段
*/
ALTER TABLE `dym_membergroup`
ADD COLUMN `permission_id`  int(2) NOT NULL DEFAULT 3 COMMENT '所见权限id 1-全部 2-部分 3-个人' AFTER  `status`;


/* 投票组件，绑定抽奖字段*/
ALTER TABLE `dym_activity_vote`
ADD COLUMN `is_lucky`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否参与抽奖 0：否  1:是' AFTER `phone`;
ALTER TABLE `dym_activity_vote`
ADD COLUMN `activity_type`  tinyint(1) NOT NULL DEFAULT 2 COMMENT '抽奖组件，1刮刮卡2大转盘' AFTER `is_lucky`;
ALTER TABLE `dym_activity_vote`
ADD COLUMN `activity_id`  int NOT NULL DEFAULT 0 COMMENT '组件活动id' ;
ALTER TABLE `dym_activity_vote`
ADD COLUMN `callback`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '抽奖完之后是否回调到投票页面 0否  1是' AFTER `activity_type`;


ALTER TABLE `dym_activity_vote_form`
MODIFY COLUMN `type`  varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '数据类型' AFTER `status`;

ALTER TABLE `dym_activity_vote_form`
ADD COLUMN `list`  int NOT NULL DEFAULT 1 COMMENT '排序' AFTER `title`;


/* 权限分组关联表*/

DROP TABLE IF EXISTS `dym_membergroup_admin`;
CREATE TABLE `dym_membergroup_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组id',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '1-组长 0-组员',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `updatetime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


/*wenlijiang 20170116*/
ALTER TABLE `dym_attachment`
MODIFY COLUMN `file_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件名，不带后缀' AFTER `mid`;
ALTER TABLE `dym_attachment`
MODIFY COLUMN `original_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '原始名称' AFTER `ext`;
ALTER TABLE `dym_attachment`
ADD COLUMN `ratio`  varchar(255) NOT NULL DEFAULT '' COMMENT '分辨率' AFTER `ext`;
ALTER TABLE `dym_attachment`
ADD COLUMN `uid`  int(11) NOT NULL DEFAULT '' COMMENT '后台操作的id' AFTER `mid`;
ALTER TABLE `dym_attachment`
ADD COLUMN `uid`  int(11) NOT NULL DEFAULT 0 COMMENT '后台操作的用户ID' AFTER `mid`


/*优化表字段*/
ALTER TABLE `dym_activity_project_relation`
MODIFY COLUMN `pid`  int(11) NOT NULL DEFAULT 0 COMMENT '应用id' FIRST ,
MODIFY COLUMN `activity_id`  int(11) NOT NULL DEFAULT 0 COMMENT '组件id' AFTER `pid`,
MODIFY COLUMN `status`  int(2) NOT NULL DEFAULT 0 COMMENT '启用 默认1=启用 2=不启用' AFTER `activity_id`,
MODIFY COLUMN `create_time`  int(10) NOT NULL DEFAULT 0 COMMENT '创建时间' AFTER `status`,
MODIFY COLUMN `update_time`  int(10) NOT NULL DEFAULT 0 AFTER `create_time`

/*海报修改字段*/
ALTER TABLE `dym_activity_poster`
CHANGE COLUMN `starttime` `start_time`  int(11) NULL DEFAULT 0 COMMENT '开始时间' AFTER `share_img`,
CHANGE COLUMN `endtime` `end_time`  int(11) NULL DEFAULT 0 COMMENT '结束时间' AFTER `start_time`




/*推荐图片*/
ALTER TABLE `dym_activity_recommend`
ADD COLUMN `listimg`  varchar(200) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '接口列表图片' AFTER `describe`;