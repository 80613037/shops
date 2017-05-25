1.54;

ALTER TABLE `%DB_PREFIX%deal`
ADD COLUMN `audit_data`  text NOT NULL COMMENT '发起人资料' AFTER `refuse_reason`;

INSERT INTO `%DB_PREFIX%conf` VALUES ('272', 'AVERAGE_USER_STATUS', '0', '6', '1', '0,1', '1', '1', '6');

INSERT INTO `%DB_PREFIX%m_config` VALUES ('38', 'sina_app_key', '新浪APP_KEY', null, '0', '38');
INSERT INTO `%DB_PREFIX%m_config` VALUES ('39', 'sina_app_secret', '新浪APP_SECRET', null, '0', '39');
INSERT INTO `%DB_PREFIX%m_config` VALUES ('40', 'sina_bind_url', '新浪回调地址', null, '0', '40');
INSERT INTO `%DB_PREFIX%m_config` VALUES ('41', 'qq_app_key', 'QQ登录APP_KEY', null, '0', '41');
INSERT INTO `%DB_PREFIX%m_config` VALUES ('42', 'qq_app_secret', 'QQ登录APP_SECRET', null, '0', '42');
INSERT INTO `%DB_PREFIX%m_config` VALUES ('43', 'wx_app_key', '微信(分享)appkey', null, '0', '43');
INSERT INTO `%DB_PREFIX%m_config` VALUES ('44', 'wx_app_secret', '微信(分享)appSecret', null, '0', '44');

DELETE FROM fanwe_conf WHERE id=271;
INSERT INTO `%DB_PREFIX%conf` VALUES ('271', 'INVEST_STATUS', '1', '6', '1', '0,1,2', '1', '1', '0');

ALTER TABLE `%DB_PREFIX%index_image`
ADD COLUMN `type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 表示首页轮播 1表示产品页轮播 2表示股权轮播';

ALTER TABLE `%DB_PREFIX%deal`
ADD COLUMN `is_hot`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '热门';

CREATE TABLE `%DB_PREFIX%user_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '体现人（标识ID）',
  `bank_id` int(11) NOT NULL COMMENT '银行(标识ID)',
  `bank_name` varchar(255) NOT NULL,
  `bankcard` varchar(30) NOT NULL COMMENT '卡号',
  `real_name` varchar(20) NOT NULL COMMENT '姓名',
  `region_lv1` varchar(50) NOT NULL,
  `region_lv2` varchar(50) NOT NULL,
  `region_lv3` varchar(50) NOT NULL,
  `region_lv4` varchar(50) NOT NULL,
  `bankzone` varchar(255) NOT NULL COMMENT '开户网点',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `bank_id` (`bank_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;



CREATE TABLE `%DB_PREFIX%bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '银行名称',
  `is_rec` tinyint(1) NOT NULL COMMENT '是否推荐',
  `day` int(11) NOT NULL COMMENT '处理时间',
  `sort` int(11) NOT NULL COMMENT '银行排序',
  `icon` varchar(255) DEFAULT NULL COMMENT '图标',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

INSERT INTO `%DB_PREFIX%bank` VALUES ('1', '中国工商银行', '1', '3', '0', './public/bank/1.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('2', '中国农业银行', '1', '3', '0', './public/bank/2.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('3', '中国建设银行', '1', '3', '0', './public/bank/3.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('4', '招商银行', '1', '3', '0', './public/bank/4.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('5', '中国光大银行', '1', '3', '0', './public/bank/5.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('6', '中国邮政储蓄银行', '1', '3', '0', './public/bank/6.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('7', '兴业银行', '1', '3', '0', './public/bank/7.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('8', '中国银行', '0', '3', '0', './public/bank/8.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('9', '交通银行', '0', '3', '3', './public/bank/9.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('10', '中信银行', '0', '3', '0', './public/bank/10.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('11', '华夏银行', '0', '3', '0', './public/bank/11.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('12', '上海浦东发展银行', '0', '3', '1', './public/bank/12.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('13', '城市信用社', '0', '3', '0', './public/bank/13.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('14', '恒丰银行', '0', '3', '0', './public/bank/14.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('15', '广东发展银行', '0', '3', '0', './public/bank/15.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('16', '深圳发展银行', '0', '3', '2', './public/bank/16.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('17', '中国民生银行', '0', '3', '0', './public/bank/17.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('18', '中国农业发展银行', '0', '3', '0', './public/bank/18.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('19', '农村商业银行', '0', '3', '0', './public/bank/19.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('20', '农村信用社', '0', '3', '0', './public/bank/20.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('21', '城市商业银行', '0', '3', '0', './public/bank/21.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('22', '农村合作银行', '0', '3', '0', './public/bank/22.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('23', '浙商银行', '0', '3', '0', './public/bank/23.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('24', '上海农商银行', '0', '3', '0', './public/bank/24.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('25', '中国进出口银行', '0', '3', '0', './public/bank/25.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('26', '渤海银行', '0', '3', '0', './public/bank/26.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('27', '国家开发银行', '0', '3', '0', './public/bank/27.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('28', '村镇银行', '0', '3', '0', './public/bank/28.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('29', '徽商银行股份有限公司', '0', '3', '0', './public/bank/29.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('30', '南洋商业银行', '0', '3', '0', './public/bank/30.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('31', '韩亚银行', '0', '3', '0', './public/bank/31.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('32', '花旗银行', '0', '3', '0', './public/bank/32.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('33', '渣打银行', '0', '3', '0', './public/bank/33.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('34', '华一银行', '0', '3', '0', './public/bank/34.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('35', '东亚银行', '1', '3', '0', './public/bank/35.jpg');
INSERT INTO `%DB_PREFIX%bank` VALUES ('36', '苏格兰皇家银行', '1', '1', '26', './public/bank/36.jpg');


INSERT INTO `%DB_PREFIX%role_module` VALUES ('138', 'Bank', '提现银行设置', '1', '0');

INSERT INTO `%DB_PREFIX%role_node` VALUES ('6868', 'index', '提现银行设置', '1', '0', '5', '138');

ALTER TABLE `%DB_PREFIX%link_group`
ADD COLUMN `type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 文字描述 1图片描述';

ALTER TABLE `%DB_PREFIX%user`
ADD COLUMN `paypassword`  varchar(255) NOT NULL COMMENT '提现和支付密码';

ALTER TABLE `%DB_PREFIX%user_refund`
ADD COLUMN `user_bank_id`  int(11) NOT NULL COMMENT '银行ID';

ALTER TABLE `%DB_PREFIX%mobile_verify_code`
ADD COLUMN `email`  varchar(255) NOT NULL COMMENT '邮件' ;

ALTER TABLE `%DB_PREFIX%user`
ADD COLUMN `source_url`  varchar(255) NOT NULL COMMENT '来源url';

delete from `%DB_PREFIX%msg_template` where id=3;
INSERT INTO `%DB_PREFIX%msg_template` VALUES ('3', 'TPL_MAIL_USER_VERIFY', '<table cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"\" width=\"100%\" style=\"background:#ffffff;\" class=\"baidu_pass\">\r\n<tbody>\r\n	<tr>\r\n		<td>\r\n		<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n        <tbody>\r\n		<tr>\r\n			<td style=\"background:#ffffff;border-bottom:2px solid #dfdfdf;width:15px;\">&nbsp;</td>\r\n			<td style=\"background:#ffffff;border-bottom:2px solid #ffffff;width:10px;\">&nbsp;</td>\r\n			<td style=\"background:#ffffff;width:137px;\"><img src=\"{$user.logo}\" class=\"logo\" ellpadding=\"0\" cellspacing=\"0\"></td>\r\n			<td style=\"background:#ffffff;border-bottom:2px solid #ffffff;width:10px;\">&nbsp;</td>\r\n			<td style=\"background:#ffffff;border-bottom:2px solid #dfdfdf;\">&nbsp;</td>\r\n		</tr>\r\n        </tbody>\r\n		</table>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td>\r\n		<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\r\n        <tbody>\r\n		<tr>\r\n			<td width=\"25px;\" style=\"width:25px;\"></td>\r\n			<td align=\"\">\r\n				<div style=\"line-height:40px;height:40px;\"></div>\r\n				<p style=\"margin:0px;padding:0px;\"><strong style=\"font-size:14px;line-height:24px;color:#333333;font-family:arial,sans-serif;\">亲爱的用户：</strong></p>\r\n				<p style=\"margin:0px;padding:0px;line-height:24px;font-size:12px;color:#333333;font-family:\'宋体\',arial,sans-serif;\">您好！</p>\r\n				<p style=\"margin:0px;padding:0px;line-height:24px;font-size:12px;color:#333333;font-family:\'宋体\',arial,sans-serif;\">您于 {$user.send_time_ms} 帐号 发送验证码：</p>\r\n				<p style=\"margin:0px;padding:0px;\">验证码：{$user.send_code}</p>\r\n 				 \r\n				<div style=\"line-height:80px;height:80px;\"></div>\r\n				<p style=\"margin:0px;padding:0px;line-height:24px;font-size:12px;color:#333333;font-family:\'宋体\',arial,sans-serif;\">{$user.site_name}帐号团队</p>\r\n				<p style=\"margin:0px;padding:0px;line-height:24px;font-size:12px;color:#333333;font-family:\'宋体\',arial,sans-serif;\"><span style=\"border-bottom:1px dashed #ccc;\" t=\"5\" times=\"\">{$user.send_time}</span></p>\r\n			</td>\r\n		</tr>\r\n		</tbody>\r\n		</table>\r\n		</td>\r\n	</tr>\r\n	<tr>\r\n		<td>\r\n			<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-top:1px solid #dfdfdf\">\r\n			<tbody>\r\n			<tr>\r\n				<td width=\"25px;\" style=\"width:25px;\"></td>\r\n				<td align=\"\">\r\n					<div style=\"line-height:40px;height:40px;\"></div>\r\n					<p style=\"margin:0px;padding:0px;line-height:24px;font-size:12px;color:#979797;font-family:\'宋体\',arial,sans-serif;\">若您没有注册过{$user.site_name}帐号，请忽略此邮件，此帐号将不会被激活，由此给您带来的不便请谅解。</p>\r\n				</td>\r\n			</tr>\r\n			</tbody>\r\n			</table>\r\n		</td>\r\n	</tr>\r\n</tbody>\r\n</table>', '1', '1');


UPDATE `%DB_PREFIX%conf` set `value` = '1.53' where name = 'DB_VERSION'; 