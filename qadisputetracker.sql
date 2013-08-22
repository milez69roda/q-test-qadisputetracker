/*
SQLyog Enterprise - MySQL GUI v8.05 RC 
MySQL - 5.5.8-log : Database - qadisputetracker_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `accesstypes` */

DROP TABLE IF EXISTS `accesstypes`;

CREATE TABLE `accesstypes` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_name` varchar(80) DEFAULT NULL,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `access_abbr` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`access_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Table structure for table `centers` */

DROP TABLE IF EXISTS `centers`;

CREATE TABLE `centers` (
  `center_id` int(11) NOT NULL AUTO_INCREMENT,
  `center_desc` varchar(100) DEFAULT NULL,
  `center_address` varchar(255) DEFAULT NULL,
  `center_disabled` tinyint(4) DEFAULT '0',
  `center_acronym` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`center_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `dispute` */

DROP TABLE IF EXISTS `dispute`;

CREATE TABLE `dispute` (
  `dispute_id` int(11) NOT NULL AUTO_INCREMENT,
  `dispute_idlink` int(11) DEFAULT NULL,
  `dispute_registeredate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `center_id` int(11) DEFAULT NULL,
  `disputer_id` varchar(100) DEFAULT NULL,
  `evaldate` int(11) DEFAULT NULL,
  `auditcontno` varchar(20) DEFAULT NULL,
  `agentname` varchar(70) DEFAULT NULL,
  `login_id` varchar(30) DEFAULT NULL,
  `pagenofilename` varchar(60) DEFAULT NULL,
  `evalform_attachment` text,
  `original_score` int(11) DEFAULT '0',
  `current_score` int(11) DEFAULT '0',
  `score_changedcounter` int(11) DEFAULT '1',
  `last_update` int(11) DEFAULT NULL,
  `dispute_type` smallint(6) DEFAULT NULL COMMENT '0:Dispute 1:redispute #1, 2:redispute #2',
  `dispute_type_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `dispute_process` int(11) DEFAULT '1',
  `dispute_process_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `dispute_comment` text,
  `cqarnew_score` int(11) DEFAULT '0',
  `cqarnew_score_changed` smallint(6) DEFAULT '0',
  `cqardispute_text` text,
  `cqardispute_date` int(11) DEFAULT NULL,
  `cqardispute_userid` varchar(60) DEFAULT NULL,
  `cqardispute_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute1_text` text,
  `redispute1_date` int(11) DEFAULT NULL,
  `redispute1_userid` varchar(60) DEFAULT NULL COMMENT '0:Pending 1:Completed',
  `redispute1_status` smallint(6) DEFAULT '0',
  `cqarnew_score2` int(11) DEFAULT '0',
  `cqarnew_score2_changed` smallint(6) DEFAULT '0',
  `cqarredispute1_text` text,
  `cqarredispute1_date` int(11) DEFAULT NULL,
  `cqarredispute1_userid` varchar(60) DEFAULT NULL,
  `cqarredispute1_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute2_text` text,
  `redispute2_date` int(11) DEFAULT NULL,
  `redispute2_userid` varchar(60) DEFAULT NULL,
  `redispute2_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute21_text` text,
  `redispute21_date` int(11) DEFAULT NULL,
  `redispute21_userid` varchar(60) DEFAULT NULL,
  `redispute21_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `snew_score3` int(11) DEFAULT '0',
  `snew_score3_changed` smallint(6) DEFAULT '0',
  `redispute22_text` text,
  `redispute22_date` int(11) DEFAULT NULL,
  `redispute22_userid` varchar(60) DEFAULT NULL,
  `redispute22_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `cqardispute_attachment` text,
  `cqarredispute1_attachment` text,
  `drpd_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`dispute_id`),
  KEY `cqardispute_userid` (`cqardispute_userid`),
  KEY `redispute1_userid` (`redispute1_userid`),
  KEY `cqarredispute1_userid` (`cqarredispute1_userid`),
  KEY `fk_dispute_center_id` (`center_id`),
  KEY `fk_dispute_disputer_id` (`disputer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46644 DEFAULT CHARSET=latin1;

/*Table structure for table `dispute_20110630` */

DROP TABLE IF EXISTS `dispute_20110630`;

CREATE TABLE `dispute_20110630` (
  `dispute_id` int(11) NOT NULL AUTO_INCREMENT,
  `dispute_idlink` int(11) DEFAULT NULL,
  `dispute_registeredate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `center_id` int(11) DEFAULT NULL,
  `disputer_id` varchar(100) DEFAULT NULL,
  `evaldate` int(11) DEFAULT NULL,
  `auditcontno` varchar(20) DEFAULT NULL,
  `agentname` varchar(70) DEFAULT NULL,
  `login_id` varchar(30) DEFAULT NULL,
  `pagenofilename` varchar(60) DEFAULT NULL,
  `evalform_attachment` text,
  `original_score` int(11) DEFAULT '0',
  `current_score` int(11) DEFAULT '0',
  `score_changedcounter` int(11) DEFAULT '1',
  `last_update` int(11) DEFAULT NULL,
  `dispute_type` smallint(6) DEFAULT NULL COMMENT '0:Dispute 1:redispute #1, 2:redispute #2',
  `dispute_type_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `dispute_process` int(11) DEFAULT '1',
  `dispute_process_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `dispute_comment` text,
  `cqarnew_score` int(11) DEFAULT '0',
  `cqarnew_score_changed` smallint(6) DEFAULT '0',
  `cqardispute_text` text,
  `cqardispute_date` int(11) DEFAULT NULL,
  `cqardispute_userid` varchar(60) DEFAULT NULL,
  `cqardispute_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute1_text` text,
  `redispute1_date` int(11) DEFAULT NULL,
  `redispute1_userid` varchar(60) DEFAULT NULL COMMENT '0:Pending 1:Completed',
  `redispute1_status` smallint(6) DEFAULT '0',
  `cqarnew_score2` int(11) DEFAULT '0',
  `cqarnew_score2_changed` smallint(6) DEFAULT '0',
  `cqarredispute1_text` text,
  `cqarredispute1_date` int(11) DEFAULT NULL,
  `cqarredispute1_userid` varchar(60) DEFAULT NULL,
  `cqarredispute1_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute2_text` text,
  `redispute2_date` int(11) DEFAULT NULL,
  `redispute2_userid` varchar(60) DEFAULT NULL,
  `redispute2_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute21_text` text,
  `redispute21_date` int(11) DEFAULT NULL,
  `redispute21_userid` varchar(60) DEFAULT NULL,
  `redispute21_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `snew_score3` int(11) DEFAULT '0',
  `snew_score3_changed` smallint(6) DEFAULT '0',
  `redispute22_text` text,
  `redispute22_date` int(11) DEFAULT NULL,
  `redispute22_userid` varchar(60) DEFAULT NULL,
  `redispute22_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `cqardispute_attachment` text,
  `cqarredispute1_attachment` text,
  `drpd_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`dispute_id`),
  KEY `cqardispute_userid` (`cqardispute_userid`),
  KEY `redispute1_userid` (`redispute1_userid`),
  KEY `cqarredispute1_userid` (`cqarredispute1_userid`)
) ENGINE=MyISAM AUTO_INCREMENT=16277 DEFAULT CHARSET=latin1;

/*Table structure for table `dispute_2011_0401_1230` */

DROP TABLE IF EXISTS `dispute_2011_0401_1230`;

CREATE TABLE `dispute_2011_0401_1230` (
  `dispute_id` int(11) NOT NULL AUTO_INCREMENT,
  `dispute_idlink` int(11) DEFAULT NULL,
  `dispute_registeredate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `center_id` int(11) DEFAULT NULL,
  `disputer_id` varchar(100) DEFAULT NULL,
  `evaldate` int(11) DEFAULT NULL,
  `auditcontno` varchar(20) DEFAULT NULL,
  `agentname` varchar(70) DEFAULT NULL,
  `login_id` varchar(30) DEFAULT NULL,
  `pagenofilename` varchar(60) DEFAULT NULL,
  `evalform_attachment` text,
  `original_score` int(11) DEFAULT '0',
  `current_score` int(11) DEFAULT '0',
  `score_changedcounter` int(11) DEFAULT '1',
  `last_update` int(11) DEFAULT NULL,
  `dispute_type` smallint(6) DEFAULT NULL COMMENT '0:Dispute 1:redispute #1, 2:redispute #2',
  `dispute_type_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `dispute_process` int(11) DEFAULT '1',
  `dispute_process_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `dispute_comment` text,
  `cqarnew_score` int(11) DEFAULT '0',
  `cqarnew_score_changed` smallint(6) DEFAULT '0',
  `cqardispute_text` text,
  `cqardispute_date` int(11) DEFAULT NULL,
  `cqardispute_userid` varchar(60) DEFAULT NULL,
  `cqardispute_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute1_text` text,
  `redispute1_date` int(11) DEFAULT NULL,
  `redispute1_userid` varchar(60) DEFAULT NULL COMMENT '0:Pending 1:Completed',
  `redispute1_status` smallint(6) DEFAULT '0',
  `cqarnew_score2` int(11) DEFAULT '0',
  `cqarnew_score2_changed` smallint(6) DEFAULT '0',
  `cqarredispute1_text` text,
  `cqarredispute1_date` int(11) DEFAULT NULL,
  `cqarredispute1_userid` varchar(60) DEFAULT NULL,
  `cqarredispute1_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute2_text` text,
  `redispute2_date` int(11) DEFAULT NULL,
  `redispute2_userid` varchar(60) DEFAULT NULL,
  `redispute2_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `redispute21_text` text,
  `redispute21_date` int(11) DEFAULT NULL,
  `redispute21_userid` varchar(60) DEFAULT NULL,
  `redispute21_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `snew_score3` int(11) DEFAULT '0',
  `snew_score3_changed` smallint(6) DEFAULT '0',
  `redispute22_text` text,
  `redispute22_date` int(11) DEFAULT NULL,
  `redispute22_userid` varchar(60) DEFAULT NULL,
  `redispute22_status` smallint(6) DEFAULT '0' COMMENT '0:Pending 1:Completed',
  `cqardispute_attachment` text,
  `cqarredispute1_attachment` text,
  `drpd_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`dispute_id`),
  KEY `cqardispute_userid` (`cqardispute_userid`),
  KEY `redispute1_userid` (`redispute1_userid`),
  KEY `cqarredispute1_userid` (`cqarredispute1_userid`),
  KEY `fk_dispute_center_id` (`center_id`),
  KEY `fk_dispute_disputer_id` (`disputer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26704 DEFAULT CHARSET=latin1;

/*Table structure for table `dropdowns` */

DROP TABLE IF EXISTS `dropdowns`;

CREATE TABLE `dropdowns` (
  `drpd_id` int(11) NOT NULL AUTO_INCREMENT,
  `dp_cat` double DEFAULT NULL,
  `dp_desc` varchar(150) DEFAULT NULL,
  `dp_status` int(11) DEFAULT '0',
  PRIMARY KEY (`drpd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

/*Table structure for table `login_attempts` */

DROP TABLE IF EXISTS `login_attempts`;

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=981 DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_name` varchar(20) NOT NULL,
  `user_password` varchar(200) DEFAULT NULL,
  `user_firstname` varchar(30) DEFAULT NULL,
  `user_lastname` varchar(30) DEFAULT NULL,
  `user_avaya` varchar(6) DEFAULT NULL,
  `user_qarno` int(11) DEFAULT NULL,
  `user_email` varchar(80) DEFAULT NULL,
  `user_ext` varchar(80) DEFAULT NULL,
  `center_id` int(11) DEFAULT NULL,
  `access_id` int(11) DEFAULT NULL,
  `user_dateregistered` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_registeredby` int(11) DEFAULT NULL COMMENT 'reference of user who added',
  `user_status` smallint(6) DEFAULT '0' COMMENT '0:Active, 1:Inactive',
  PRIMARY KEY (`user_name`),
  KEY `access_id` (`access_id`),
  KEY `center_id` (`center_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/* Trigger structure for table `dispute` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `dispute_last_update` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `dispute_last_update` BEFORE UPDATE ON `dispute` FOR EACH ROW BEGIN
	SET NEW.last_update = UNIX_TIMESTAMP();
    END */$$


DELIMITER ;

/* Trigger structure for table `dispute_20110630` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `dispute_last_update_copy` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `dispute_last_update_copy` BEFORE UPDATE ON `dispute_20110630` FOR EACH ROW BEGIN
	SET NEW.last_update = UNIX_TIMESTAMP();
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;