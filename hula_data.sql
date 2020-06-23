/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50614
Source Host           : localhost:3306
Source Database       : hulacwms

Target Server Type    : MYSQL
Target Server Version : 50614
File Encoding         : 65001

Date: 2020-06-23 14:28:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `zz_admin_action`
-- ----------------------------
DROP TABLE IF EXISTS `zz_admin_action`;
CREATE TABLE `zz_admin_action` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` char(30) NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '行为说明',
  `remark` char(140) NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text COMMENT '行为规则',
  `log` text COMMENT '日志规则',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统行为表';

-- ----------------------------
-- Records of zz_admin_action
-- ----------------------------
INSERT INTO `zz_admin_action` VALUES ('1', 'user_login', '用户登录', '', '', '', '1', '1', '1387181220');
INSERT INTO `zz_admin_action` VALUES ('17', 'member_login_success', '管理员登录成功', '', '', '', '1', '1', '1571748718');
INSERT INTO `zz_admin_action` VALUES ('18', 'member_login_error', '管理员登录失败', '', '', '', '1', '1', '1574650631');
INSERT INTO `zz_admin_action` VALUES ('23', 'document_article_edit', '编辑文章', '编辑文章', '', '', '1', '1', '1571900242');
INSERT INTO `zz_admin_action` VALUES ('24', 'document_article_add', '添加文章', '添加文章', '', '', '1', '1', '1571900248');
INSERT INTO `zz_admin_action` VALUES ('25', 'document_article_del', '删除文章', '删除文章', '', '', '1', '1', '1571900258');
INSERT INTO `zz_admin_action` VALUES ('26', 'document_display_yin', '隐藏文章', '隐藏文章', '', '', '1', '1', '1571886185');
INSERT INTO `zz_admin_action` VALUES ('27', 'document_display_xian', '显示文章', '显示文章', '', '', '1', '1', '1571886219');
INSERT INTO `zz_admin_action` VALUES ('28', 'document_sort', '文章排序', '文章排序', '', '', '1', '1', '1574652761');
INSERT INTO `zz_admin_action` VALUES ('29', 'documentcategory_add', '添加子分类', '添加子分类', '', '', '1', '1', '1571889610');
INSERT INTO `zz_admin_action` VALUES ('30', 'documentcategory_edit', '编辑文章分类', '编辑文章分类', '', '', '1', '1', '1571888952');
INSERT INTO `zz_admin_action` VALUES ('31', 'documentcategory_del', '删除文章分类', '删除文章分类', '', '', '1', '1', '1571889015');
INSERT INTO `zz_admin_action` VALUES ('33', 'documentcategory_sort', '文章分类排序', '文章分类排序', '', '', '1', '1', '1571900516');
INSERT INTO `zz_admin_action` VALUES ('34', 'friendlink_add', '添加友情链接', '添加友情链接', '', '', '1', '1', '1571901233');
INSERT INTO `zz_admin_action` VALUES ('35', 'friendlink_edit', '编辑友情链接', '编辑友情链接', '', '', '1', '1', '1571901263');
INSERT INTO `zz_admin_action` VALUES ('36', 'friendlink_del', '删除友情链接', '删除友情链接', '', '', '1', '1', '1571901299');
INSERT INTO `zz_admin_action` VALUES ('37', 'friendlink_status_jin', '禁用友情链接', '禁用友情链接', '', '', '1', '1', '1571901342');
INSERT INTO `zz_admin_action` VALUES ('38', 'friendlink_status_qi', '启用友情链接', '启用友情链接', '', '', '1', '1', '1571901362');
INSERT INTO `zz_admin_action` VALUES ('39', 'friendlink_sort', '友情链接排序', '友情链接排序', '', '', '1', '1', '1571901694');
INSERT INTO `zz_admin_action` VALUES ('40', 'messageform_del', '删除留言', '删除留言', '', '', '1', '1', '1571901937');
INSERT INTO `zz_admin_action` VALUES ('41', 'adminmember_add', '添加后台用户', '添加后台用户', '', '', '1', '1', '1571902207');
INSERT INTO `zz_admin_action` VALUES ('42', 'adminmember_edit', '编辑后台用户', '编辑后台用户', '', '', '1', '1', '1571902230');
INSERT INTO `zz_admin_action` VALUES ('43', 'adminmember_del', '删除后台用户', '删除后台用户', '', '', '1', '1', '1571902384');
INSERT INTO `zz_admin_action` VALUES ('44', 'adminmember_auth', '后台用户授权', '后台用户授权', '', '', '1', '1', '1571903642');
INSERT INTO `zz_admin_action` VALUES ('45', 'adminmember_status_qi', '启用后台用户', '启用后台用户', '', '', '1', '1', '1571903689');
INSERT INTO `zz_admin_action` VALUES ('46', 'adminmember_status_jin', '禁用后台用户', '禁用后台用户', '', '', '1', '1', '1571903715');
INSERT INTO `zz_admin_action` VALUES ('47', 'adminauthgroup_add', '新增权限', '新增权限', '', '', '1', '1', '1571904760');
INSERT INTO `zz_admin_action` VALUES ('48', 'adminauthgroup_edit', '编辑权限', '编辑权限', '', '', '1', '1', '1571904781');
INSERT INTO `zz_admin_action` VALUES ('49', 'adminauthgroup_del', '删除权限', '删除权限', '', '', '1', '1', '1571904797');
INSERT INTO `zz_admin_action` VALUES ('50', 'adminauthgroup_status_jin', '禁用权限', '禁用权限', '', '', '1', '1', '1571904864');
INSERT INTO `zz_admin_action` VALUES ('51', 'adminauthgroup_status_qi', '启用权限', '启用权限', '', '', '1', '1', '1571904879');
INSERT INTO `zz_admin_action` VALUES ('52', 'adminauthgroup_access', '访问授权', '访问授权', '', '', '1', '1', '1571905096');
INSERT INTO `zz_admin_action` VALUES ('53', 'adminauthgroup_user', '成员授权', '成员授权', '', '', '1', '1', '1571905112');
INSERT INTO `zz_admin_action` VALUES ('54', 'adminauthgroup_user_cancel', '取消成员授权', '取消成员授权', '', '', '1', '1', '1571905290');
INSERT INTO `zz_admin_action` VALUES ('55', 'adminaction_add', '新增用户行为', '新增用户行为', '', '', '1', '1', '1571906260');
INSERT INTO `zz_admin_action` VALUES ('56', 'adminaction_edit', '编辑用户行为', '编辑用户行为', '', '', '1', '1', '1571906281');
INSERT INTO `zz_admin_action` VALUES ('57', 'adminaction_del', '删除用户行为', '删除用户行为', '', '', '1', '1', '1571906297');
INSERT INTO `zz_admin_action` VALUES ('58', 'adminaction_status_qi', '启用用户行为', '启用用户行为', '', '', '1', '1', '1571906477');
INSERT INTO `zz_admin_action` VALUES ('59', 'adminaction_status_jin', '禁用用户行为', '禁用用户行为', '', '', '1', '1', '1571906498');
INSERT INTO `zz_admin_action` VALUES ('60', 'adminactionlog_del', '删除行为日志', '删除行为日志', '', '', '1', '1', '1571906655');
INSERT INTO `zz_admin_action` VALUES ('61', 'config_set', '修改网站设置', '修改网站设置', '', '', '1', '1', '1571907098');
INSERT INTO `zz_admin_action` VALUES ('62', 'config_add', '新增配置', '新增配置', '', '', '1', '1', '1571907154');
INSERT INTO `zz_admin_action` VALUES ('63', 'config_edit', '编辑配置', '编辑配置', '', '', '1', '1', '1571907176');
INSERT INTO `zz_admin_action` VALUES ('64', 'config_del', '删除配置', '删除配置', '', '', '1', '1', '1571907259');
INSERT INTO `zz_admin_action` VALUES ('65', 'config_sort', '配置排序', '配置排序', '', '', '1', '1', '1571907343');
INSERT INTO `zz_admin_action` VALUES ('66', 'adminmenu_add', '新增菜单', '新增菜单', '', '', '1', '1', '1571907568');
INSERT INTO `zz_admin_action` VALUES ('67', 'adminmenu_edit', '编辑菜单', '编辑菜单', '', '', '1', '1', '1571907601');
INSERT INTO `zz_admin_action` VALUES ('68', 'adminmenu_del', '删除菜单', '删除菜单', '', '', '1', '1', '1571907632');
INSERT INTO `zz_admin_action` VALUES ('69', 'adminmenu_sort', '菜单排序', '菜单排序', '', '', '1', '1', '1571908040');
INSERT INTO `zz_admin_action` VALUES ('70', 'adminmenu_status_yin', '隐藏菜单', '隐藏菜单', '', '', '1', '1', '1571908330');
INSERT INTO `zz_admin_action` VALUES ('71', 'adminmenu_status_xian', '显示菜单', '显示菜单', '', '', '1', '1', '1571908358');
INSERT INTO `zz_admin_action` VALUES ('72', 'databases_optimdize', '优化表', '优化表', '', '', '1', '1', '1571908465');
INSERT INTO `zz_admin_action` VALUES ('73', 'databases_repair', '修复表', '修复表', '', '', '1', '1', '1571908691');
INSERT INTO `zz_admin_action` VALUES ('74', 'databases_del', '删除备份文件', '删除备份文件', '', '', '1', '1', '1571908782');
INSERT INTO `zz_admin_action` VALUES ('75', 'databases_export', '备份数据库', '备份数据库', '', '', '1', '1', '1571908852');
INSERT INTO `zz_admin_action` VALUES ('76', 'databases_import', '还原数据库', '还原数据库', '', '', '1', '1', '1571908893');
INSERT INTO `zz_admin_action` VALUES ('84', 'adminmember_resetpwd', '重置密码', '', null, null, '1', '1', '1574759758');

-- ----------------------------
-- Table structure for `zz_admin_action_log`
-- ----------------------------
DROP TABLE IF EXISTS `zz_admin_action_log`;
CREATE TABLE `zz_admin_action_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '行为id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行用户id',
  `action_ip` varchar(50) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '触发行为的数据id',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '执行行为的时间',
  PRIMARY KEY (`id`),
  KEY `action_ip_ix` (`action_ip`),
  KEY `action_id_ix` (`action_id`),
  KEY `user_id_ix` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1765 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='行为日志表';

-- ----------------------------
-- Records of zz_admin_action_log
-- ----------------------------

-- ----------------------------
-- Table structure for `zz_admin_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `zz_admin_auth_group`;
CREATE TABLE `zz_admin_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `module` varchar(20) NOT NULL DEFAULT '' COMMENT '用户组所属模块',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '组类型',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zz_admin_auth_group
-- ----------------------------
INSERT INTO `zz_admin_auth_group` VALUES ('1', 'admin', '1', '默认用户组', '默认用户组', '1', '1,2,195,196,68,70,75,86,87,88,89');

-- ----------------------------
-- Table structure for `zz_admin_member`
-- ----------------------------
DROP TABLE IF EXISTS `zz_admin_member`;
CREATE TABLE `zz_admin_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `nickname` char(10) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` char(32) NOT NULL COMMENT '密码',
  `group_id` int(10) NOT NULL DEFAULT '0' COMMENT '权限分组id',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户状态',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of zz_admin_member
-- ----------------------------
INSERT INTO `zz_admin_member` VALUES ('1', 'admin', '超级管理员', '4b8368b0f4786175f97d8706a957ae4a', '0', '1530325649', '0', '1592882318', '::1', '1591668249', '1');

-- ----------------------------
-- Table structure for `zz_admin_menu`
-- ----------------------------
DROP TABLE IF EXISTS `zz_admin_menu`;
CREATE TABLE `zz_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `tip` varchar(255) NOT NULL DEFAULT '' COMMENT '提示',
  `is_dev` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否仅开发者模式可见',
  `icon` char(50) DEFAULT NULL COMMENT '菜单图标',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=210 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zz_admin_menu
-- ----------------------------
INSERT INTO `zz_admin_menu` VALUES ('1', '后台首页', '0', '1', 'index/main', '0', '', '0', 'layui-icon-home', '1');
INSERT INTO `zz_admin_menu` VALUES ('2', '内容管理', '0', '2', '', '0', '', '0', 'layui-icon-template-1', '1');
INSERT INTO `zz_admin_menu` VALUES ('16', '后台管理', '0', '3', '', '0', '', '0', 'layui-icon-auz', '1');
INSERT INTO `zz_admin_menu` VALUES ('17', '管理员信息', '16', '1', 'adminmember/index', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('140', '友情链接', '2', '4', 'friendlink/index', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('19', '用户行为', '16', '3', 'adminaction/action', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('27', '权限管理', '16', '2', 'adminauthgroup/index', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('68', '系统管理', '0', '4', '', '0', '', '0', 'layui-icon-set', '1');
INSERT INTO `zz_admin_menu` VALUES ('69', '网站设置', '68', '1', 'config/groups', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('70', '配置管理', '68', '2', 'config/index', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('75', '菜单管理', '68', '3', 'adminmenu/index', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('86', '数据库管理', '68', '4', 'databases/index?type=export', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('87', '备份', '86', '0', 'databases/export', '0', '备份数据库', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('88', '优化表', '86', '0', 'databases/optimize', '0', '优化数据表', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('89', '修复表', '86', '0', 'databases/repair', '0', '修复数据表', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('106', '行为日志', '16', '4', 'adminactionlog/actionlog', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('195', '修改密码', '17', '99', 'adminmember/edit', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('194', '启用禁用', '17', '99', 'adminmember/set_status', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('141', '留言管理', '2', '5', 'messageform/index', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('136', '文章列表', '2', '1', 'document/index', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('137', '栏目分类', '2', '2', 'documentcategory/index', '0', '文章分类', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('138', '新增文章', '136', '1', 'document/add_document', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('139', '编辑文章', '136', '2', 'document/edit_document', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('191', '启用禁用', '140', '99', 'friendlink/set_status', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('143', '添加分类', '137', '2', 'documentcategory/add_category', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('144', '编辑分类', '137', '3', 'documentcategory/edit_category', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('192', '排序', '140', '99', 'friendlink/sort', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('146', '新增', '140', '1', 'friendlink/add_link', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('147', '编辑', '140', '2', 'friendlink/edit_link', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('148', '留言详情', '141', '1', 'messageform/message_details', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('149', '新增管理员', '17', '1', 'adminmember/add', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('150', '授权', '17', '2', 'adminmember/auth', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('151', '新增', '27', '1', 'adminauthgroup/add', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('152', '编辑', '27', '2', 'adminauthgroup/edit', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('153', '新增', '19', '1', 'adminaction/add_action', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('154', '编辑', '19', '2', 'adminaction/edit_action', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('155', '清空', '106', '1', 'adminactionlog/clear', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('156', '详情', '106', '2', 'adminactionlog/edit_action_log', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('157', '新增', '70', '1', 'config/add', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('158', '编辑', '70', '2', 'config/edit', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('159', '新增', '75', '1', 'adminmenu/add', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('160', '编辑', '75', '2', 'adminmenu/edit', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('161', '访问授权', '27', '3', 'adminauthgroup/access', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('162', '成员授权', '27', '4', 'adminauthgroup/user', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('166', '删除文章', '136', '3', 'document/del_document', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('167', '删除分类', '137', '5', 'documentcategory/del_category', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('168', '删除', '140', '3', 'friendlink/del_link', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('169', '删除留言', '141', '2', 'messageform/del_message', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('170', '删除管理员', '17', '3', 'adminmember/del', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('171', '删除权限', '27', '5', 'adminauthgroup/del', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('172', '删除行为', '19', '3', 'adminaction/delaction', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('173', '删除日志', '106', '3', 'adminactionlog/delactionlog', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('174', '删除配置', '70', '993', 'config/del', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('175', '删除菜单', '75', '3', 'adminmenu/del', '0', '', '0', '', '1');
INSERT INTO `zz_admin_menu` VALUES ('177', '产品列表', '2', '3', 'documentproduct/index', '1', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('179', '新增', '177', '99', 'documentproduct/add', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('180', '编辑', '177', '99', 'documentproduct/edit', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('181', '删除', '177', '99', 'documentproduct/del', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('182', '显示隐藏', '177', '99', 'documentproduct/set_display', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('183', '排序', '177', '99', 'documentproduct/sort', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('184', '显示隐藏', '136', '99', 'document/set_display', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('185', '排序', '136', '99', 'document/sort', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('190', '显示隐藏', '137', '99', 'documentcategory/set_display', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('196', '修改昵称', '17', '99', 'adminmember/nickname', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('197', '启用禁用', '27', '99', 'adminauthgroup/set_status', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('198', '启用禁用', '19', '99', 'adminaction/set_action_status', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('199', '显示隐藏', '75', '99', 'adminmenu/hide', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('200', '排序', '75', '99', 'adminmenu/sort', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('201', '还原', '86', '99', 'databases/import', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('202', '删除', '86', '99', 'databases/del', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('203', '上传附件', '16', '99', '', '1', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('204', '上传视频', '203', '99', 'upload/video', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('205', '上传文件', '203', '99', 'upload/file', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('206', '编辑器上传', '16', '99', 'ueditor/index', '1', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('207', '上传图片', '206', '99', 'ueditor/picture', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('208', '上传文件', '206', '99', 'ueditor/file', '0', '', '0', null, '1');
INSERT INTO `zz_admin_menu` VALUES ('209', '上传视频', '206', '99', 'ueditor/video', '0', '', '0', null, '1');

-- ----------------------------
-- Table structure for `zz_config`
-- ----------------------------
DROP TABLE IF EXISTS `zz_config`;
CREATE TABLE `zz_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `value` text COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `module` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0全部\r\n1前台\r\n2后台',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`),
  KEY `group` (`group`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zz_config
-- ----------------------------
INSERT INTO `zz_config` VALUES ('1', 'WEB_SITE_TITLE', '1', '网站标题', '1', '', '网站标题前台显示标题', '1378898976', '1588951530', '1', 'HulaCWMS-甘木包装有限公司-呼啦企业网站管理系统演示', '0', '1');
INSERT INTO `zz_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '1', '', '网站搜索引擎描述', '1378898976', '1588951534', '1', 'HulaCWMS(呼啦企业网站管理系统)是由青岛灼灼文化自主研发的一套专门用户管理企业网站的管理系统，系统特点：清爽美观，系统做减法，用户体验就很棒。', '1', '1');
INSERT INTO `zz_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '1', '', '网站搜索引擎关键字', '1378898976', '1588951539', '1', 'HulaCWMS,呼啦企业网站管理系统演示,cms,内容管理系统', '8', '1');
INSERT INTO `zz_config` VALUES ('4', 'WEB_SITE_CLOSE', '4', '关闭站点', '1', '0:关闭,1:开启', '站点关闭后用户不能访问', '1378898976', '1588951296', '1', '1', '1', '1');
INSERT INTO `zz_config` VALUES ('5', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '0', '', '主要用于数据解析和页面表单的生成', '1378898976', '1588951305', '1', '0:数字\n1:字符\n5:图片\n2:文本\n3:数组\n4:枚举', '2', '2');
INSERT INTO `zz_config` VALUES ('6', 'WEB_SITE_ICP', '1', '网站备案号', '1', '', '设置在网站底部显示的备案号，如：“鲁ICP备00000001号-1”', '1378900335', '1592625538', '1', '', '9', '1');
INSERT INTO `zz_config` VALUES ('7', 'CONFIG_MODULE', '3', '配置作用域', '0', '', '在管理配置时，可以设置该配置项的所在作用域。', '1588949815', '1588951419', '1', '0:全站作用\n1:仅前台作用\n2:仅后台作用', '0', '2');
INSERT INTO `zz_config` VALUES ('8', 'COMPANY_TEL', '1', '公司联系电话', '3', '', '公司联系电话，用于前台展示', '1571490284', '1588951334', '1', '010-123456', '0', '1');
INSERT INTO `zz_config` VALUES ('9', 'COMPANY_EMAIL', '1', '公司联系邮箱', '3', '', '公司联系邮箱，用于前台展示', '1571490326', '1588951587', '1', 'zz@zhuopro.com', '0', '1');
INSERT INTO `zz_config` VALUES ('10', 'CONFIG_GROUP_LIST', '3', '配置分组', '0', '', '配置分组', '1379228036', '1588951434', '1', '1:基本\n3:联系\n4:系统', '4', '2');
INSERT INTO `zz_config` VALUES ('11', 'LIST_ROWS', '0', '后台每页记录数', '0', '', '后台数据每页显示记录数', '1379503896', '1588951440', '1', '15', '10', '2');
INSERT INTO `zz_config` VALUES ('12', 'COMPANY_ADD', '0', '公司联系地址', '3', '', '公司联系地址，用于前台展示', '1571490386', '1588951450', '1', '青岛市黄岛区长江路街道', '0', '0');
INSERT INTO `zz_config` VALUES ('13', 'COMPANY_QQ', '1', '联系QQ', '3', '', '公司联系QQ，用于前台显示', '1574838586', '1588951607', '1', '123456', '0', '1');
INSERT INTO `zz_config` VALUES ('14', 'DATA_BACKUP_PATH', '1', '数据库备份根路径', '4', '', '路径必须以 / 结尾', '1381482411', '1588951614', '1', './databack/', '5', '2');
INSERT INTO `zz_config` VALUES ('15', 'DATA_BACKUP_PART_SIZE', '0', '数据库备份卷大小', '4', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '1381482488', '1588951620', '1', '20971520', '7', '2');
INSERT INTO `zz_config` VALUES ('16', 'DATA_BACKUP_COMPRESS', '4', '数据库备份文件是否启用压缩', '4', '0:不压缩\n1:启用压缩', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '1381713345', '1588951634', '1', '1', '9', '2');
INSERT INTO `zz_config` VALUES ('17', 'DATA_BACKUP_COMPRESS_LEVEL', '4', '数据库备份文件压缩级别', '4', '1:普通\n4:一般\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '1381713408', '1588951639', '1', '9', '10', '2');
INSERT INTO `zz_config` VALUES ('18', 'DEVELOP_MODE', '4', '开启开发者模式', '4', '0:关闭\n1:开启', '是否开启开发者模式', '1383105995', '1588951648', '1', '1', '11', '2');
INSERT INTO `zz_config` VALUES ('19', 'WEB_TEMPLATE_PATH', '0', '网站前台模板目录', '0', '', '相对路径，必须以字母或数字开头', '1571313339', '1591866150', '1', 'default', '0', '0');
INSERT INTO `zz_config` VALUES ('20', 'WEB_POWERBY', '0', '网站版权', '0', '', '网站版权，用于前台显示', '1571490683', '1588951665', '1', 'power by HulaCWMS 灼灼文化', '0', '1');
INSERT INTO `zz_config` VALUES ('21', 'WEB_REWRITE', '4', '开启伪静态', '0', '0:关闭,1:开启', '开启伪静态，url会省略入口文件index.php，但它必须依赖服务器配置。否则网站无法正常访问', '1571491840', '1592882330', '1', '1', '0', '1');
INSERT INTO `zz_config` VALUES ('22', 'WEB_TONGJI', '4', '开启网站统计', '0', '0:关闭,1:开启', '是否开始网站统计', '1587980376', '1588951709', '1', '1', '0', '0');

-- ----------------------------
-- Table structure for `zz_document`
-- ----------------------------
DROP TABLE IF EXISTS `zz_document`;
CREATE TABLE `zz_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `writer` varchar(50) NOT NULL DEFAULT '' COMMENT '作者',
  `name` char(40) NOT NULL DEFAULT '' COMMENT '标识',
  `title` char(80) NOT NULL DEFAULT '' COMMENT '标题',
  `category_id` int(10) unsigned NOT NULL COMMENT '所属分类',
  `keywords` varchar(255) DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `type` varchar(50) NOT NULL DEFAULT 'article' COMMENT '内容类型',
  `isrecommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `istop` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `link_str` varchar(255) NOT NULL DEFAULT '0' COMMENT '外链',
  `cover_path` varchar(255) NOT NULL DEFAULT '0' COMMENT '封面',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  PRIMARY KEY (`id`),
  KEY `idx_category_status` (`category_id`,`status`),
  KEY `idx_status_type_pid` (`status`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=utf8 COMMENT='文档模型基础表';

-- ----------------------------
-- Records of zz_document
-- ----------------------------
INSERT INTO `zz_document` VALUES ('121', '1', '', '', '最新力作，英伦风礼物收纳盒', '87', '', '英伦风，源自英国维多利亚时期，以自然、优雅、含蓄、高贵为特点', 'article', '0', '0', '', '/uploads/20191026/d90347044db19ff6ecd0c605e2c490a3.jpg', '1', '1', '99', '1572077123', '1572098497', '1');
INSERT INTO `zz_document` VALUES ('122', '1', '', '', '复古风格设计的Farm Fresh牛奶包装', '89', '', '相对于许多在包装设计上喜欢跟上时代步伐走简约时尚的设计师来说，台湾很多设计师都比较倾向于走原生包装设计路线。在很多台湾本土产品的包装设计上，人们经常可以看到那些别有韵味充满民族风情的包装。今天为大家带来台湾设计师的食品包装设计，特别之处尽在不言中。', 'article', '0', '0', '', '/uploads/20191026/572c2bdc3047a615bbdd49b05e539147.jpg', '1', '41', '99', '1572078882', '1591588239', '1');
INSERT INTO `zz_document` VALUES ('123', '1', '', '', 'Green Conut手工皂包装设计', '91', '', '该作品设计采用了插画形式，融入了传统徽派的黛瓦白墙元素，包装外观画面简约、画风清新。并对传统的纹样进行提炼,将手工皂的包装印染结合一身。', 'article', '0', '0', '', '/uploads/20191026/b086c6fdeaa422aa4dfc56e28dc95c53.jpg', '1', '36', '99', '1572079072', '1591588198', '1');
INSERT INTO `zz_document` VALUES ('124', '1', '', '', '国潮设计来袭! 巴巴多斯朗姆酒Mount Gay包装设计', '88', '', '随着国潮的不断复兴冲击，消费者越来越发现，会玩的老品牌，在悠长的文化传承背景下所渗透出来的味道，让人更熟悉、更舒适、更安心。', 'article', '0', '0', '', '/uploads/20191026/9cba191af0b525f69d9e596db0bb4be1.jpg', '1', '69', '99', '1572079258', '1592201798', '1');
INSERT INTO `zz_document` VALUES ('125', '1', '', '', 'On the Road to Variable图书版面设计', '90', '', '设计工作室 TwoPoints.net在最新一本名为On the Road to Variable（在变革的道路上）的书中，通过展示122位才华横溢的创意人作品，探索字体设计的未来。', 'article', '0', '0', '', '/uploads/20191026/b9ddb8de337899c2256964a0121e23b8.jpg', '1', '92', '99', '1572079377', '1591620772', '1');
INSERT INTO `zz_document` VALUES ('126', '1', '', '', '我们的服务', '85', '', '', 'article', '0', '0', '', '', '1', '4', '99', '1572081832', '1572081832', '1');
INSERT INTO `zz_document` VALUES ('127', '1', '', '', '需求沟通', '93', '', '和客户沟通需求，更好的了解客户的产品需求，对之后产品成型有更大的帮助。', 'article', '0', '0', '', '', '1', '0', '99', '1572095904', '1572096024', '1');
INSERT INTO `zz_document` VALUES ('128', '1', '', '', '设计打版', '93', '', '和客户沟通需求，更好的了解客户的产品需求，对之后产品成型有更大的帮助', 'article', '0', '0', '', '', '1', '0', '99', '1572095917', '1572096015', '1');
INSERT INTO `zz_document` VALUES ('129', '1', '', '', '成品制作', '93', '', '和客户沟通需求，更好的了解客户的产品需求，对之后产品成型有更大的帮助。', 'article', '0', '0', '', '', '1', '0', '99', '1572095927', '1572096009', '1');
INSERT INTO `zz_document` VALUES ('130', '1', '', '', '售后服务', '93', '', '和客户沟通需求，更好的了解客户的产品需求，对之后产品成型有更大的帮助。', 'article', '0', '0', '', '', '1', '0', '99', '1572095937', '1572096004', '1');
INSERT INTO `zz_document` VALUES ('131', '1', '', '', '产品总监', '94', '', '', 'article', '0', '0', '', '/uploads/20191026/ce9e808324b0b14e7c1e8d5dccd02208.jpg', '1', '1', '99', '1572097056', '1572097056', '1');
INSERT INTO `zz_document` VALUES ('132', '1', '', '', '设计总监', '94', '', '', 'article', '0', '0', '', '/uploads/20191026/71cd71f84322cb990cae8edc7bb80850.jpg', '1', '0', '99', '1572097071', '1572097071', '1');
INSERT INTO `zz_document` VALUES ('133', '1', '', '', '制作总监', '94', '', '', 'article', '0', '0', '', '/uploads/20191026/dbd942d02c76eb0dfbb5e329f6219c60.jpg', '1', '0', '99', '1572097088', '1572097088', '1');
INSERT INTO `zz_document` VALUES ('134', '1', '', '', '复古风格设计的 Farm Fresh 牛奶包装', '87', '', '简约时尚，比较倾向原生包装设计路线。', 'article', '0', '0', '', '/uploads/20191026/53b359ce66578e6fe9e39c4ce24b3b72.jpg', '1', '0', '3', '1572097549', '1572098565', '1');

-- ----------------------------
-- Table structure for `zz_document_article`
-- ----------------------------
DROP TABLE IF EXISTS `zz_document_article`;
CREATE TABLE `zz_document_article` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `content` text COMMENT '文章内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型文章表';

-- ----------------------------
-- Records of zz_document_article
-- ----------------------------
INSERT INTO `zz_document_article` VALUES ('121', '');
INSERT INTO `zz_document_article` VALUES ('122', '<p>怀着一颗对美学的初心,为品牌铸造价值,上海撼世文化拥有十多年品牌历史的品牌策划设计机构。撼世文化致力于为品牌打造价值，整合品牌营销专业全案策划服务，让品牌影响力持续发挥作用，为各行业的品牌发展贡献我们的智慧与力量。</p>');
INSERT INTO `zz_document_article` VALUES ('123', '<p><img src=\"/uploads/picture/20200608/4309929d15a86a53295355617921d4fd.jpg\" title=\"\" alt=\"\"/></p>');
INSERT INTO `zz_document_article` VALUES ('124', '<p>										</p><p><br/></p><p style=\"text-align: center;\"><br/></p><p>随着国潮的不断复兴冲击，消费者越来越发现，会玩的老品牌，在悠长的文化传承背景下所渗透出来的味道，让人更熟悉、更舒适、更安心。</p><p>消费者的审美发展速度，快到超出想象。绿伞是国内具有25年日化经验的老品牌，有一定的品牌认知基础。为此，巴巴多斯朗姆酒Mount Gay包装设计着眼于老品牌的升级改造，深度挖掘并运用了中国传统文化与最时尚的趋势相结合的构思方式，增添消费者购买信心的同时，又重新点燃了老品牌的时尚生机。让更多年轻消费群体关注并购买老品牌的产品，同时还达到了自主传播的营销目的。</p><p><br/></p><p style=\"text-align: center;\"><img src=\"/uploads/picture/20200608/9ed7f25ec68d220978ff0b3e61ac7e8a.jpg\" title=\"\" alt=\"\"/></p><p><br/></p><p><br/></p><p>									</p>');
INSERT INTO `zz_document_article` VALUES ('125', '<p>										</p><p><br/></p><p><img src=\"/uploads/picture/20200608/a780818b65eb93f20339d030dd87e8f9.jpg\" title=\"\" alt=\"\"/><br/>设计工作室&nbsp;TwoPoints.net在最新一本名为On the Road to Variable（在变革的道路上）的书中，通过展示122位才华横溢的创意人作品，探索字体设计的未来。</p><p><br/></p><p>									</p>');
INSERT INTO `zz_document_article` VALUES ('126', '<p><span style=\"color: rgb(51, 51, 51); font-family: arial; text-align: justify; background-color: rgb(255, 255, 255);\">智能物流包装“数智+”服务是以智能物流包装微粒化数据为基础，以“箱货共管”为理念的社会化物流包装循环共用服务体系，它将推动供应链的智能化、柔性化变革，并让用户低成本地获取到了实时智能、辅助决策等智能供应链服务，这将为各行各业的企业用户带来革命性的体验。</span></p>');
INSERT INTO `zz_document_article` VALUES ('127', '');
INSERT INTO `zz_document_article` VALUES ('128', '');
INSERT INTO `zz_document_article` VALUES ('129', '');
INSERT INTO `zz_document_article` VALUES ('130', '');
INSERT INTO `zz_document_article` VALUES ('131', '');
INSERT INTO `zz_document_article` VALUES ('132', '');
INSERT INTO `zz_document_article` VALUES ('133', '');
INSERT INTO `zz_document_article` VALUES ('134', '');
INSERT INTO `zz_document_article` VALUES ('135', '<p>11111111111111111111111111111</p>');
INSERT INTO `zz_document_article` VALUES ('136', '<p>111111111111111111<br/></p>');
INSERT INTO `zz_document_article` VALUES ('137', '<p>11111111111</p>');
INSERT INTO `zz_document_article` VALUES ('138', '<p>1111111111111111</p>');
INSERT INTO `zz_document_article` VALUES ('139', '<p>1111111111111111111111111111111111</p>');
INSERT INTO `zz_document_article` VALUES ('140', '<p>testa</p>');
INSERT INTO `zz_document_article` VALUES ('141', '<p>test2</p>');
INSERT INTO `zz_document_article` VALUES ('142', '<p>test3</p>');
INSERT INTO `zz_document_article` VALUES ('143', '<p>test4</p>');
INSERT INTO `zz_document_article` VALUES ('144', '<p>test5</p>');
INSERT INTO `zz_document_article` VALUES ('145', '<p>test6test6test6</p>');
INSERT INTO `zz_document_article` VALUES ('146', '<p>test7test7test7test7test7test7test7test7</p>');
INSERT INTO `zz_document_article` VALUES ('147', '<p>测试文字</p>');
INSERT INTO `zz_document_article` VALUES ('148', '<p>										</p><p>测试文字</p><p>									</p>');

-- ----------------------------
-- Table structure for `zz_document_category`
-- ----------------------------
DROP TABLE IF EXISTS `zz_document_category`;
CREATE TABLE `zz_document_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL COMMENT '标志',
  `title` varchar(50) NOT NULL COMMENT '标题',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分类类别：0列表，1单篇，2链接',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `child` varchar(255) NOT NULL DEFAULT '',
  `parent_id` varchar(255) NOT NULL DEFAULT '',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `meta_title` varchar(50) NOT NULL DEFAULT '' COMMENT 'SEO的网页标题',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '关键字',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `template_index` varchar(100) NOT NULL DEFAULT '' COMMENT '频道页模板',
  `template_lists` varchar(100) NOT NULL DEFAULT '' COMMENT '列表页模板',
  `template_detail` varchar(100) NOT NULL DEFAULT '' COMMENT '详情页模板',
  `link_str` varchar(255) NOT NULL DEFAULT '0' COMMENT '外链',
  `view` int(10) NOT NULL DEFAULT '0' COMMENT '访问数',
  `display` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '可见性',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数据状态',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '分类图标',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of zz_document_category
-- ----------------------------
INSERT INTO `zz_document_category` VALUES ('84', 'case', '案例', '0', '0', '88,89,90,91', '', '1', '', '', '', '', 'case.html', 'details.html', '', '249', '1', '1572075448', '1591844236', '1', '');
INSERT INTO `zz_document_category` VALUES ('85', 'service', '服务', '0', '0', '93', '', '2', '', '', '', '', 'service.html', 'details.html', '', '132', '1', '1572075515', '1572075515', '1', '');
INSERT INTO `zz_document_category` VALUES ('86', 'about', '关于', '1', '0', '94', '', '3', '', '', '', 'about.html', '', '', '', '94', '1', '1572075555', '1592202705', '1', '');
INSERT INTO `zz_document_category` VALUES ('87', '', '首页幻灯片', '0', '0', '', '', '4', '', '', '', '', '', '', '', '1', '0', '1572076042', '1572076042', '1', '');
INSERT INTO `zz_document_category` VALUES ('88', '', '百货包装', '0', '84', '', '84', '1', '', '', '', '', 'case.html', 'details.html', '', '16', '1', '1572076905', '1572077228', '1', '/uploads/20191026/86f88a330ebc68e8220c9bb3e213febf.jpg');
INSERT INTO `zz_document_category` VALUES ('89', '', '食品包装', '0', '84', '', '84', '3', '', '', '', '', 'case.html', 'details.html', '', '9', '1', '1572076946', '1572076946', '1', '/uploads/20191026/741d347105494f45265bfb178a6441a7.jpg');
INSERT INTO `zz_document_category` VALUES ('90', '', '书籍包装', '0', '84', '', '84', '3', '', '', '', '', 'case.html', 'details.html', '', '6', '1', '1572076959', '1572076959', '1', '/uploads/20191026/6d0f2fdc18587a3bfd09cf792ad53f83.jpg');
INSERT INTO `zz_document_category` VALUES ('91', '', '化妆品包装', '0', '84', '', '84', '4', '', '', '', '', 'case.html', 'details.html', '', '0', '1', '1572076984', '1590392063', '1', '/uploads/20191026/ae6b828088409caa0c50826522f9a425.jpg');
INSERT INTO `zz_document_category` VALUES ('93', '', '成品流程', '0', '85', '', '85', '99', '', '', '', '', '', '', '', '0', '0', '1572095994', '1590238413', '1', '');
INSERT INTO `zz_document_category` VALUES ('94', '', '核心团队', '0', '86', '', '86', '99', '', '', '有了向心力，才有可能凝聚', '', '', '', '', '1', '1', '1572096823', '1572096840', '1', '');

-- ----------------------------
-- Table structure for `zz_document_category_content`
-- ----------------------------
DROP TABLE IF EXISTS `zz_document_category_content`;
CREATE TABLE `zz_document_category_content` (
  `id` int(11) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zz_document_category_content
-- ----------------------------
INSERT INTO `zz_document_category_content` VALUES ('84', '');
INSERT INTO `zz_document_category_content` VALUES ('88', '                                                                                                                                                        ');
INSERT INTO `zz_document_category_content` VALUES ('94', '                                                                            ');
INSERT INTO `zz_document_category_content` VALUES ('86', '<p style=\"box-sizing: inherit; margin-top: 0px; margin-bottom: 0px; line-height: 2; padding: 0px; color: rgb(82, 82, 82); font-family: &quot;Helvetica Neue&quot;, NotoSansHans-Regular, AvenirNext-Regular, arial, &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei&quot;, &quot;WenQuanYi Micro Hei&quot;, serif; font-size: 15px; white-space: normal; background-color: rgb(252, 252, 252);\">呼啦企业网站管理系统专注于企业、政府单位网站建设，以免费开源的方式，帮助广大站长、个人或企业开发者大大降低了开发成本和维护成本。快速锁定意向客户，培养长线营收。目前呼啦企业网站管理系统的<a href=\"http://www.hulaxz.com/\" target=\"_blank\" style=\"box-sizing: inherit; background-color: transparent; color: rgb(65, 131, 196); text-decoration-line: none;\">资源下载站</a>已制作了上百套不同行业的网站模板，欢迎下载试用。</p><p style=\"box-sizing: inherit; margin-top: 0px; margin-bottom: 0px; line-height: 2; padding: 0px; color: rgb(82, 82, 82); font-family: &quot;Helvetica Neue&quot;, NotoSansHans-Regular, AvenirNext-Regular, arial, &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei&quot;, &quot;WenQuanYi Micro Hei&quot;, serif; font-size: 15px; white-space: normal; background-color: rgb(252, 252, 252);\">因为专注所以专业，呼啦企业网站管理系统后台界面清爽美观，自适应的布局符合新时代的审美观和用户体验。本着系统就是给客户使用的设计原则，后台菜单做减法，通俗易懂。让您不再为了培训客户如何使用后台而烦恼！</p><p><br/></p>');
INSERT INTO `zz_document_category_content` VALUES ('91', '');
INSERT INTO `zz_document_category_content` VALUES ('102', '');
INSERT INTO `zz_document_category_content` VALUES ('103', '');
INSERT INTO `zz_document_category_content` VALUES ('93', '');

-- ----------------------------
-- Table structure for `zz_document_product`
-- ----------------------------
DROP TABLE IF EXISTS `zz_document_product`;
CREATE TABLE `zz_document_product` (
  `id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文档ID',
  `piclist` text COMMENT '产品图片集',
  `content` text COMMENT '文章内容',
  `price` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '产品价格',
  `market_price` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '市场价',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档模型文章表';

-- ----------------------------
-- Records of zz_document_product
-- ----------------------------

-- ----------------------------
-- Table structure for `zz_friend_link`
-- ----------------------------
DROP TABLE IF EXISTS `zz_friend_link`;
CREATE TABLE `zz_friend_link` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(10) NOT NULL DEFAULT '1' COMMENT '添加者',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '链接网站名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片连接的图片',
  `description` text COMMENT '描述',
  `sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '状态 0禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zz_friend_link
-- ----------------------------
INSERT INTO `zz_friend_link` VALUES ('12', '1', '灼灼文化', 'http://www.zhuopro.com', '', '', '2', '1572100561', '1574651778', '1');
INSERT INTO `zz_friend_link` VALUES ('13', '1', 'HulaCWMS', 'http://www.hulaxz.com/hulacwms.html', '', '', '3', '1572100592', '1572100592', '1');
INSERT INTO `zz_friend_link` VALUES ('21', '1', '呼啦资源网', 'http://www.hulaxz.com/', '', '', '4', '1572100592', '1592202203', '1');

-- ----------------------------
-- Table structure for `zz_message_form`
-- ----------------------------
DROP TABLE IF EXISTS `zz_message_form`;
CREATE TABLE `zz_message_form` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '姓名',
  `tel` varchar(15) NOT NULL COMMENT '手机',
  `email` varchar(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `content` text NOT NULL COMMENT '留言内容',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '留言时间',
  `is_reply` int(10) DEFAULT '0' COMMENT '回复状态 0未回复',
  `reply_uid` int(10) DEFAULT NULL COMMENT '回复人',
  `reply_content` text COMMENT '回复内容',
  `status` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zz_message_form
-- ----------------------------

-- ----------------------------
-- Table structure for `zz_picture`
-- ----------------------------
DROP TABLE IF EXISTS `zz_picture`;
CREATE TABLE `zz_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id自增',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片链接',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件 sha1编码',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of zz_picture
-- ----------------------------
INSERT INTO `zz_picture` VALUES ('148', '/uploads/picture/20200102/8c25bf552d0578860f7cb872bb02bc26.jpg', '', '7ea1bd2df0d848a5dc0692fd0bf6abfa', '961fb0e30afd0ea9146f4d965d3fd715f81b4a52', '1', '1577949386');
INSERT INTO `zz_picture` VALUES ('147', '/uploads/picture/20200102/ee7a1653c9984cc4e3d5fbb7938c4225.jpg', '', 'ffc1003704e6c1c8e7e4c50c506d6b73', '2319ee209b122eb4f8723a745c1b578774cb1806', '1', '1577949378');
INSERT INTO `zz_picture` VALUES ('149', '/uploads/picture/20200102/a105c3e519e74fed13f8b08f53af383d.jpg', '', 'ff1fab17aadf02ae18c160fdb19f9c85', 'fcaf70d98b6f73c0ae6f011f54917c0fd130cfdb', '1', '1577949411');
INSERT INTO `zz_picture` VALUES ('150', '/uploads/picture/20200102/36acdc5ec8a46d89ddbbbb4540800c48.jpg', '', '11ca41510c2f0f9efae8bbabd7c8e96a', '5b18c742bfe6f460a7cf95f8a0b7fd4d032c690d', '1', '1577956071');
INSERT INTO `zz_picture` VALUES ('151', '/uploads/picture/20200102/47497f194152268a5424820852e989c2.png', '', 'f42c6c5facf531e9dc694709df8bd623', '984d21daee0f09fa558222548ce2591ad4e23530', '1', '1577956096');
INSERT INTO `zz_picture` VALUES ('152', '/uploads/picture/20200102/4287ff66730caf66615ee3891d315049.jpg', '', '19e73404adfd4b092bf5931de2de60b0', '74a3b2f4dc499364ecebed157b3c24b14459ee98', '1', '1577956114');
INSERT INTO `zz_picture` VALUES ('153', '/uploads/picture/20200102/4cee1949f53e11ed3224eb6e0731b33d.jpg', '', 'd69a6085967f6be0048908d6155c1e32', '26b968ff6df58ca888d5572356c2975a23456786', '1', '1577956134');
INSERT INTO `zz_picture` VALUES ('154', '/uploads/picture/20200103/4bb3ccaa15d8fd36ba2b4a7ed0b1e5ef.jpg', '', 'e2478bd64308a0e29b35fc263a4fbaf8', '297f49715bf0a64c13dcd491c8c967b0039c3cf2', '1', '1578021448');
INSERT INTO `zz_picture` VALUES ('155', '/uploads/picture/20200427/263c6ab66e7ed327a919375c19616be2.jpg', '', 'bfb357a65f2ddba052af82f95ec4d776', 'db023af35f5cd95773c25c72503e2447e8dd7f0a', '1', '1587987193');
INSERT INTO `zz_picture` VALUES ('156', '/uploads/picture/20200428/8260efae9f590a032cee82307214fcb2.jpg', '', '0325e78d4a0554c169c478e64e4f0384', 'e93bbf32f69c02192b21e85947f39fa1f4b50fe2', '1', '1588085629');
INSERT INTO `zz_picture` VALUES ('157', '/uploads/picture/20200428/a076f534446e463889df54c31a3674f2.jpg', '', '3a08648bc18ed5f32f85c96cac1d9976', '694cb2c0842af0a8536c66007cdfb2587caec859', '1', '1588085629');
INSERT INTO `zz_picture` VALUES ('158', '/uploads/picture/20200508/20f0fdad449a06bbbd59dcf6a0d51148.jpg', '', 'ff7ae4bc80eb88e791a07fbe488cd1b5', '1842b049eda89d0c995c947e2d42ec62f039fdb4', '1', '1588948298');
INSERT INTO `zz_picture` VALUES ('159', '/uploads/picture/20200508/255cf1784bb9b1e26b33393d3210ee07.jpg', '', 'd74f7cd18a7c6b9348aae5794ca4512c', 'c86a300fa43546e7bd8ecb094e5e4b19b2002b8c', '1', '1588948303');
INSERT INTO `zz_picture` VALUES ('160', '/uploads/picture/20200508/bdce757edbff306bda899b09dee5b39a.jpg', '', 'f9a968af36933c07c35261ed7902f133', '4bbc691fbf8d049b0887178e7e7fae3668eb5e58', '1', '1588948377');
INSERT INTO `zz_picture` VALUES ('161', '/uploads/picture/20200508/0864d46da7dfdc9afa6b1afabfbcd74b.png', '', '8b9b2735801f8c3f55db47510c6ac002', '6a4130811bb18f3fa2b56836fe9788fa116f11ba', '1', '1588948377');
INSERT INTO `zz_picture` VALUES ('162', '/uploads/picture/20200525/946e4ae4ce48e8aeceacb5558daebf0e.jpg', '', '0dd4d580de53cdcd06ced82e9babfb8f', '9a082b1bfde7df29135067ab4124d6aeb08ba992', '1', '1590410634');
INSERT INTO `zz_picture` VALUES ('163', '/uploads/picture/20200608/a780818b65eb93f20339d030dd87e8f9.jpg', '', '2d1ae16235a9817b3def6b3c161659be', '72f1bec8f384a31ea3a74211c70cbabd7cae7bbd', '1', '1591588033');
INSERT INTO `zz_picture` VALUES ('164', '/uploads/picture/20200608/63e94b7614787ced07893bfebbc4384c.jpg', '', 'cb26f5d0ce175b6c8f20df194d02346b', 'c197521b3a3fc46cb28b370c7627603fe13e8d1d', '1', '1591588116');
INSERT INTO `zz_picture` VALUES ('165', '/uploads/picture/20200608/9ed7f25ec68d220978ff0b3e61ac7e8a.jpg', '', '18947b0055a3d42e2d9318682468ed25', 'c12190e03ba6a6ae5c19c0e89457712949f24571', '1', '1591588126');
INSERT INTO `zz_picture` VALUES ('166', '/uploads/picture/20200608/4309929d15a86a53295355617921d4fd.jpg', '', 'cdb193f2005e777a380e513e5e766b1d', '7d073cd3b68022f1bab5ba555529a08ba78c8882', '1', '1591588197');

-- ----------------------------
-- Table structure for `zz_pv_log`
-- ----------------------------
DROP TABLE IF EXISTS `zz_pv_log`;
CREATE TABLE `zz_pv_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间段',
  `view` int(10) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `date` varchar(255) NOT NULL DEFAULT '' COMMENT '访问时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of zz_pv_log
-- ----------------------------

-- ----------------------------
-- Table structure for `zz_url_log`
-- ----------------------------
DROP TABLE IF EXISTS `zz_url_log`;
CREATE TABLE `zz_url_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT 'url 受访的页面url',
  `pv` int(10) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '页面名称',
  `date` varchar(255) NOT NULL DEFAULT '' COMMENT '访问时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of zz_url_log
-- ----------------------------

-- ----------------------------
-- Table structure for `zz_uv_log`
-- ----------------------------
DROP TABLE IF EXISTS `zz_uv_log`;
CREATE TABLE `zz_uv_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL DEFAULT '0' COMMENT '访问ip',
  `time` int(10) NOT NULL DEFAULT '0' COMMENT '时间',
  `date` varchar(255) NOT NULL DEFAULT '' COMMENT '访问时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of zz_uv_log
-- ----------------------------
