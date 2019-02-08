/*
Navicat MySQL Data Transfer

Source Server         : vUX2
Source Server Version : 50560
Source Host           : 45.77.210.88:3306
Source Database       : vpsnetcom

Target Server Type    : MYSQL
Target Server Version : 50560
File Encoding         : 65001

Date: 2019-02-07 22:17:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `Fontastic`
-- ----------------------------
DROP TABLE IF EXISTS `Fontastic`;
CREATE TABLE `Fontastic` (
  `FID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FontName` varchar(150) DEFAULT NULL,
  `FileName` varchar(100) DEFAULT NULL,
  `PointSize` int(2) DEFAULT NULL,
  `HighSecurity` int(2) DEFAULT NULL,
  PRIMARY KEY (`FID`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of Fontastic
-- ----------------------------
INSERT INTO `Fontastic` VALUES ('3', 'Albino', 'ALBINO_.TTF', '30', null);
INSERT INTO `Fontastic` VALUES ('5', 'Amphion', 'AMPHI.TTF', '26', null);
INSERT INTO `Fontastic` VALUES ('6', 'Angelican', 'ANGLIC.TTF', '30', null);
INSERT INTO `Fontastic` VALUES ('7', 'Aquaduct Warp', 'Aquawrp.ttf', '27', null);
INSERT INTO `Fontastic` VALUES ('8', 'Army', 'Army.ttf', '32', null);
INSERT INTO `Fontastic` VALUES ('9', 'Art Brush', 'Artbrush.ttf', '32', null);
INSERT INTO `Fontastic` VALUES ('11', 'Augie', 'augie.ttf', '24', null);
INSERT INTO `Fontastic` VALUES ('12', 'Balogna Bold', 'BALGNAB.TTF', '40', null);
INSERT INTO `Fontastic` VALUES ('13', 'Barrel', 'barrel.ttf', '30', null);
INSERT INTO `Fontastic` VALUES ('14', 'Basketcase Roman', 'BASKR__.TTF', '22', null);
INSERT INTO `Fontastic` VALUES ('15', 'Baskerville Old Face', 'BASKVILL.TTF', '26', null);
INSERT INTO `Fontastic` VALUES ('16', 'Batik', 'batik.TTF', '32', null);
INSERT INTO `Fontastic` VALUES ('17', 'Beccaria', 'Beccaria.ttf', '38', null);
INSERT INTO `Fontastic` VALUES ('18', 'Benjamin Franklin', 'BenjaminFranklin.ttf', '25', null);
INSERT INTO `Fontastic` VALUES ('20', 'Bleeding Cowboys', 'Bleeding_Cowboys.ttf', '22', null);
INSERT INTO `Fontastic` VALUES ('21', 'Blue Century', 'BlueCentury.ttf', '30', null);
INSERT INTO `Fontastic` VALUES ('22', 'Blue Global', 'BlueGlobal.ttf', '28', null);
INSERT INTO `Fontastic` VALUES ('23', 'Blue Type', 'BlueType.ttf', '28', null);
INSERT INTO `Fontastic` VALUES ('25', 'Brankovic', 'brankovic.ttf', '30', null);
INSERT INTO `Fontastic` VALUES ('28', 'Chantal Light', 'Chantal_Light.ttf', '34', null);
INSERT INTO `Fontastic` VALUES ('29', 'Chiller', 'CHILLER.TTF', '38', null);
INSERT INTO `Fontastic` VALUES ('32', 'Dead Alive', 'DEADA__.TTF', '40', null);
INSERT INTO `Fontastic` VALUES ('36', 'Due Date', 'DUE.TTF', '26', null);
INSERT INTO `Fontastic` VALUES ('37', 'Festus', 'festus.ttf', '30', null);
INSERT INTO `Fontastic` VALUES ('38', 'First Grader', 'FIRSTGR.TTF', '30', null);
INSERT INTO `Fontastic` VALUES ('39', 'Fossil', 'FOSSIL.TTF', '30', null);
INSERT INTO `Fontastic` VALUES ('40', 'Fuzzy Xmas', 'Fuzzxmas.TTF', '25', null);
INSERT INTO `Fontastic` VALUES ('41', 'PP Handwriting Normal', 'hand.ttf', '34', null);
INSERT INTO `Fontastic` VALUES ('42', 'Harrington', 'HARNGTON.TTF', '30', null);
INSERT INTO `Fontastic` VALUES ('43', 'Interdimensional', 'INTERDIM.TTF', '15', null);
INSERT INTO `Fontastic` VALUES ('44', 'Jayne Print Hand', 'Jayneprint.ttf', '30', null);
INSERT INTO `Fontastic` VALUES ('45', 'Jenkins v2.0', 'JENKINSV.TTF', '50', null);
INSERT INTO `Fontastic` VALUES ('46', 'Joe Hand', 'JOEHAND.TTF', '50', null);
INSERT INTO `Fontastic` VALUES ('47', 'Jotterscript Medium', 'jttrscrt.TTF', '28', null);
INSERT INTO `Fontastic` VALUES ('50', 'Mandingo', 'MANDINGO.TTF', '32', null);
INSERT INTO `Fontastic` VALUES ('52', 'Nails', 'NAILS__.TTF', '27', null);
INSERT INTO `Fontastic` VALUES ('54', 'Nyala', 'nyala.ttf', '34', null);
INSERT INTO `Fontastic` VALUES ('56', 'Perisphere', 'PERISPHE.TTF', '34', null);
INSERT INTO `Fontastic` VALUES ('57', 'Pickabilly', 'PICKABIL.TTF', '48', null);
INSERT INTO `Fontastic` VALUES ('58', 'Roman Acid', 'ROMAA__.TTF', '28', null);
INSERT INTO `Fontastic` VALUES ('59', 'Roughage Serif', 'roughage.TTF', '24', null);
INSERT INTO `Fontastic` VALUES ('63', 'Scrawl Of The Chief', 'SCRAOTC.TTF', '20', null);
INSERT INTO `Fontastic` VALUES ('64', 'Seaweed Fire AOE', 'SEAWFA_.TTF', '37', null);
INSERT INTO `Fontastic` VALUES ('65', 'SF Grunge Sans', 'SF_Grunge_Sans.ttf', '40', null);
INSERT INTO `Fontastic` VALUES ('67', 'Stencil', 'STENCIL.TTF', '30', null);
INSERT INTO `Fontastic` VALUES ('68', 'Yataghan', 'yataghan.ttf', '28', null);
