/*
Navicat MySQL Data Transfer

Source Server         : drlouie
Source Server Version : 9.78.2
Source Host           : 1.0.0.1
Source Database       : testdriver

Target Server Type    : MYSQL
Target Server Version : 9.78.2
File Encoding         : 65001

Date: 2018-08-29 02:09:55
*/
use thetvdb;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for thetvdb
-- ----------------------------
DROP TABLE IF EXISTS `thetvdb`;
CREATE TABLE `thetvdb` (
  `UserID` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `UID` varchar(255) NOT NULL DEFAULT '',
  `UserState` longblob,
  `Created` datetime DEFAULT NULL,
  `LastUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
SET FOREIGN_KEY_CHECKS=1;
