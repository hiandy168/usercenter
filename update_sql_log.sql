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



/*

大转盘 分享地址
*/

ALTER TABLE `dym_activity_bigwheel`
ADD COLUMN `share_url`  varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分享地址' AFTER `add_time`;

/*
刮刮卡  分享地址
*/
ALTER TABLE `dym_activity_scratch`
ADD COLUMN `share_url`  varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分享地址' AFTER `share_desc`;

/*
投票&报名  分享地址
*/
ALTER TABLE `dym_activity_vote`
ADD COLUMN `share_url`  varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分享地址' AFTER `share_desc`;


/*
签到  分享地址
*/
ALTER TABLE `dym_activity_pccheckin`
ADD COLUMN `share_url`  varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '分享地址' AFTER `share_desc`;
/*
刮刮卡修改字段名称
*/
ALTER TABLE `dym_activity_scratch`
CHANGE COLUMN `desc_img` `myprize_img`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '我的奖品图片' AFTER `scratch_img`;


/*
用户表新增新字段
*/
ALTER TABLE `dym_member`
ADD COLUMN  `realname` varchar(200) NOT NULL DEFAULT '' COMMENT '用户真实姓名',
ADD COLUMN  `realcard` varchar(200) NOT NULL DEFAULT '' COMMENT '身份证号码',
ADD COLUMN  `wxstatus` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1表示已同步，2表示未同步',


/*
增加活动组件数据统计表
*/
DROP TABLE IF EXISTS `dym_activity_browse`;
CREATE TABLE `dym_activity_browse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '项目应用id',
  `model` varchar(255) NOT NULL DEFAULT '' COMMENT '活动模块名称',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '1-浏览 2-独立浏览',
  `ip` varchar(255) NOT NULL DEFAULT '' COMMENT '用户IP地址',
  `count_num` int(11) NOT NULL DEFAULT '0' COMMENT '总数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*
	最后一次操作记录
	
*/


/*
砸金蛋  
*/



DROP TABLE IF EXISTS `dym_activity_playegg`;
CREATE TABLE `dym_activity_playegg` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `pid` int(10) NOT NULL COMMENT '所属的应用的id',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id  主要是记录最后一次谁操作的用户id',
  `prize_id` varchar(255) DEFAULT NULL COMMENT '奖品id',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `start_time` int(11) DEFAULT NULL COMMENT '开始时间',
  `end_time` int(11) DEFAULT NULL COMMENT '结束时间',
  `win_num` int(11) DEFAULT NULL COMMENT '可以中奖的次数',
  `day_count` int(11) DEFAULT NULL COMMENT '每人每天可刮奖次数',
  `share_num` int(11) DEFAULT NULL COMMENT '有效分享次数（指分享后可活动刮奖机会的次数，多余的分享为无效分享）',
  `share_add_num` int(11) DEFAULT NULL COMMENT '分享一次获得刮奖次数',
  `win_msg` varchar(255) DEFAULT NULL COMMENT '中奖提示',
  `rule` varchar(255) DEFAULT NULL COMMENT '砸金蛋活动规则',
  `lingjiang` varchar(255) DEFAULT NULL COMMENT '领奖方式',
  `end_num_msg` varchar(255) DEFAULT NULL COMMENT '次数结束提醒',
  `end_msg` varchar(255) DEFAULT NULL COMMENT '结束提醒',
  `jishu` int(11) DEFAULT NULL COMMENT '概率基数',
  `share_img` varchar(255) DEFAULT NULL COMMENT '分享图片',
  `banner_img` varchar(255) DEFAULT NULL COMMENT 'banner图片',
  `scratch_img` varchar(255) DEFAULT NULL COMMENT '砸金蛋刮奖区图片',
  `myprize_img` varchar(255) DEFAULT NULL COMMENT '我的奖品图片',
  `status` int(11) DEFAULT '1' COMMENT '砸金蛋活动状态(0表示结束，1表示正在进行）',
  `add_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `share_desc` varchar(255) DEFAULT NULL COMMENT '分享描述',
  `share_url` varchar(255) NOT NULL DEFAULT '' COMMENT '分享地址',
  `img` varchar(200) DEFAULT NULL,
  `tag` varchar(200) DEFAULT NULL COMMENT '活动标签',
  `share_switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '分享开关，1开 2关',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=290 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dym_activity_playegg
-- ----------------------------


-- ----------------------------
-- Table structure for `dym_activity_playegg_prize`
-- ----------------------------
DROP TABLE IF EXISTS `dym_activity_playegg_prize`;
CREATE TABLE `dym_activity_playegg_prize` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `title` varchar(255) DEFAULT NULL COMMENT '奖品等级标题（自定义名称如：一等奖，二等奖）',
  `aid` int(11) NOT NULL DEFAULT '0' COMMENT '活动id',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id  主要是记录最后一次谁操作的用户id',
  `name` varchar(255) DEFAULT '' COMMENT '奖品名称（具体的奖品）',
  `count` int(11) DEFAULT '0' COMMENT '奖品数量',
  `probability` int(11) DEFAULT '0' COMMENT '中奖概率',
  `remainder` int(11) DEFAULT '0' COMMENT '剩余奖品',
  `img` varchar(255) DEFAULT '' COMMENT '奖品图片',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态值',
  `updatetime` int(11) NOT NULL DEFAULT '0',
  `createtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=406 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dym_activity_playegg_prize
-- ----------------------------


-- ----------------------------
-- Table structure for `dym_activity_playegg_user`
-- ----------------------------
DROP TABLE IF EXISTS `dym_activity_playegg_user`;
CREATE TABLE `dym_activity_playegg_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `playegg_id` int(11) NOT NULL COMMENT '砸金蛋活动ID',
  `day_count` int(11) DEFAULT '0' COMMENT '每天可抽奖数量',
  `mid` int(11) NOT NULL DEFAULT '0',
  `openid` varchar(55) DEFAULT NULL COMMENT '微信用户的openid',
  `time` int(11) DEFAULT NULL COMMENT '刮卡时间',
  `is_win` int(11) DEFAULT NULL COMMENT '是否中奖',
  `prize_id` int(11) DEFAULT NULL COMMENT '如果中奖了显示奖品id，没有中奖则为空',
  `code` int(11) DEFAULT NULL COMMENT '中奖领取码,没中奖为空',
  `accept` int(11) DEFAULT '0' COMMENT '中奖者是否领奖',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=568 DEFAULT CHARSET=utf8 COMMENT='砸金蛋活动用户';



/*
问答活动相关表
*/
DROP TABLE IF EXISTS `dym_activity_wenda`;
CREATE TABLE `dym_activity_wenda` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL DEFAULT '0' COMMENT '项目id',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id  主要是记录最后一次谁操作的用户id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '活动标题',
  `wenda_prize_num` int(11) NOT NULL DEFAULT '0' COMMENT '获奖资格-用户答对题目才有机会抽奖',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `day_count` int(11) NOT NULL DEFAULT '0' COMMENT '每天可玩次数',
  `share_num` int(11) NOT NULL DEFAULT '0' COMMENT '有效分享次数',
  `share_add_num` int(11) NOT NULL DEFAULT '0' COMMENT '分享一次获得答题次数',
  `lose_msg` varchar(255) NOT NULL DEFAULT '很遗憾您没有中奖' COMMENT '没中奖提示',
  `win_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '中奖提示',
  `rule` text NOT NULL COMMENT '活动规则',
  `end_num_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '次数结束提醒',
  `end_msg` varchar(255) NOT NULL DEFAULT '' COMMENT '结束提醒',
  `share_img` varchar(255) NOT NULL DEFAULT '' COMMENT '分享图片',
  `banner_img` varchar(255) NOT NULL DEFAULT '' COMMENT 'banner 图片',
  `bg_img` varchar(255) NOT NULL DEFAULT '' COMMENT '问答活动背景图片',
  `desc_img` varchar(255) NOT NULL DEFAULT '' COMMENT '详情图片',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '问答活动状态(0表示结束，1表示正在进行）',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `share_url` varchar(255) NOT NULL DEFAULT '' COMMENT '分享地址',
  `share_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '分享描述',
  `tag` varchar(200) NOT NULL DEFAULT '' COMMENT '活动标签',
  `is_prize` int(2) NOT NULL DEFAULT '0' COMMENT '是否参与抽奖 1-抽奖 0-不抽奖',
  `activity_type` int(2) NOT NULL DEFAULT '0' COMMENT '抽奖组件类型 2-大转盘 1-刮刮卡',
  `activity_id` int(11) NOT NULL DEFAULT '0' COMMENT '参与抽奖组件id',
  `share_switch` int(2) NOT NULL DEFAULT '0' COMMENT '微信分享开启关闭 1-开 0-关',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `dym_activity_wenda_answer`;
CREATE TABLE `dym_activity_wenda_answer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questionid` int(11) NOT NULL DEFAULT '0' COMMENT '题目文案id',
  `answer` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '答案字符',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '正确答案状态 1-正确 0-错误',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(255) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='问答答案表单';


DROP TABLE IF EXISTS `dym_activity_wenda_question`;
CREATE TABLE `dym_activity_wenda_question` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'sort',
  `wendaid` int(11) NOT NULL DEFAULT '0' COMMENT '问答活动id',
  `question` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '题目文案',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id  主要是记录最后一次谁操作的用户id',
  `createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `body` text CHARACTER SET utf8 NOT NULL COMMENT '题目内容字段',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序字段',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '伪删除字段 0-删除 1-正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='问答问题表';


DROP TABLE IF EXISTS `dym_activity_wenda_user`;
CREATE TABLE `dym_activity_wenda_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wendaid` int(11) NOT NULL DEFAULT '0' COMMENT '活动ID',
  `mid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `openid` varchar(55) NOT NULL DEFAULT '' COMMENT '微信用户的openid',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '答题时间',
  `answer_bingo_num` int(11) NOT NULL DEFAULT '0' COMMENT '用户答对题数',
  `answer_bingo_id` varchar(255) NOT NULL DEFAULT '' COMMENT '用户答对的题目id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='问答活动参与用户表';



/*单点登录表  修改*/

ALTER TABLE `dym_sso_broker`
MODIFY COLUMN `agentid`  int(11) NOT NULL DEFAULT 0 COMMENT '接入方 appid' AFTER `id`,
MODIFY COLUMN `secret`  varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '接入方密钥' AFTER `agentid`,
MODIFY COLUMN `url`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '回调地址' AFTER `secret`,
MODIFY COLUMN `name`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '接入方名称' AFTER `url`,
MODIFY COLUMN `description`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述' AFTER `type`,
MODIFY COLUMN `createtime`  int(11) NOT NULL DEFAULT 0 COMMENT '创建时间' AFTER `description`,
MODIFY COLUMN `updatetime`  int(11) NOT NULL DEFAULT 0 COMMENT '修改时间' AFTER `createtime`;
MODIFY COLUMN `status`  tinyint(1) NOT NULL DEFAULT 1 COMMENT '1：正常;0:违规；' AFTER `updatetime`;


