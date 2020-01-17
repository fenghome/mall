/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50536
Source Host           : 127.0.0.1:3306
Source Database       : tp5_db

Target Server Type    : MYSQL
Target Server Version : 50536
File Encoding         : 65001

Date: 2016-11-02 14:27:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for think_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_group`;
CREATE TABLE `think_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_auth_group
-- ----------------------------
INSERT INTO `think_auth_group` VALUES ('1', '默认分组', '1', '1');

-- ----------------------------
-- Table structure for think_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_group_access`;
CREATE TABLE `think_auth_group_access` (
  `uid` bigint(20) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_auth_group_access
-- ----------------------------
INSERT INTO `think_auth_group_access` VALUES ('1', '1');
INSERT INTO `think_auth_group_access` VALUES ('2', '1');

-- ----------------------------
-- Table structure for think_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_rule`;
CREATE TABLE `think_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_auth_rule
-- ----------------------------
INSERT INTO `think_auth_rule` VALUES ('1', 'show_button', 'show_button', '1', '1', '{score}>100 and {score}<200');

-- ----------------------------
-- Table structure for think_member
-- ----------------------------
DROP TABLE IF EXISTS `think_member`;
CREATE TABLE `think_member` (
  `user_id` bigint(20) NOT NULL,
  `type` tinyint(2) DEFAULT '0' COMMENT '0：个人，1：企业',
  `username` varchar(255) DEFAULT NULL COMMENT '开发者账号',
  `email` varchar(100) DEFAULT NULL COMMENT '开发者邮箱',
  `telephone` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `url` varchar(255) DEFAULT NULL COMMENT '网站',
  `province` int(11) DEFAULT NULL COMMENT '省',
  `city` int(11) DEFAULT NULL COMMENT '市',
  `login_num` int(11) DEFAULT '0' COMMENT '登录次数',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` bigint(20) DEFAULT NULL COMMENT '最后登录ip',
  `score` int(10) DEFAULT NULL COMMENT '积分',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(2) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of think_member
-- ----------------------------
INSERT INTO `think_member` VALUES ('1', '0', 'admin', 'xiaobo.sun@123.com', '0535-2106911', 'http://www.zzstudio.net', '370000', '370600', '0', null, null, '0', '1466391021', '1466391021', '1');
INSERT INTO `think_member` VALUES ('2', '1', '开发者', 'xiaobo.sun@qq.com', '15589600175', 'http://www.zzstudio.net', '370000', '370600', '0', null, null, '110', '1466127548', '1468889770', '1');
