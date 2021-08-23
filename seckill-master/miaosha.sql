/*
Navicat MySQL Data Transfer

Source Server         : baota-bendi
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : miaosha

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2021-08-16 10:54:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for chen_goods
-- ----------------------------
DROP TABLE IF EXISTS `chen_goods`;
CREATE TABLE `chen_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL,
  `counts` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of chen_goods
-- ----------------------------
INSERT INTO `chen_goods` VALUES ('1', 'iphone7', '1');
INSERT INTO `chen_goods` VALUES ('2', 'macbook', '15');

-- ----------------------------
-- Table structure for chen_orders
-- ----------------------------
DROP TABLE IF EXISTS `chen_orders`;
CREATE TABLE `chen_orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `addtime` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=903 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of chen_orders
-- ----------------------------

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL,
  `counts` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('1', 'iphone7', '5');
INSERT INTO `goods` VALUES ('2', 'macbook', '20');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(20) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `addtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
