/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : platform

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-08-28 16:54:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pg_payment
-- ----------------------------
DROP TABLE IF EXISTS `pg_payment`;
CREATE TABLE `pg_payment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(32) NOT NULL DEFAULT '' COMMENT '订单号ID',
  `amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '金额(单位分)',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '调用支付平台类型；1：银河支付 2：Wispay支付 3：杉德支付',
  `card_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付卡类型 1:储蓄卡 2:信用卡',
  `pay_type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '支付产品类型 00:网银 01:快捷 10:微信H5 11:支付宝 12:京东H5 13:银联支付 20:QQ钱包 21:京东钱包 30:银联扫描 31:支付宝扫描',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态 0：发起支付  1：支付完成  2：支付失败',
  `from_type` varchar(50) NOT NULL DEFAULT '' COMMENT '请求来源名称',
  `trans_date` varchar(8) NOT NULL DEFAULT '' COMMENT '交易日期(yyyymmdd)',
  `trans_time` varchar(8) NOT NULL DEFAULT '' COMMENT '交易时间(HHmmss)',
  `channel` tinyint(1) NOT NULL DEFAULT '2' COMMENT '来源类型 1：PC端） 2：手机端',
  `created_at` int(11) unsigned DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COMMENT='支付记录表';
