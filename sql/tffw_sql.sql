# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.5.8
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3603
# Date/time:                    2011-02-02 18:57:19
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping structure for table tffw.ban_list
DROP TABLE IF EXISTS `ban_list`;
CREATE TABLE IF NOT EXISTS `ban_list` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL DEFAULT '0',
  `reason` mediumtext,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table tffw.errors
DROP TABLE IF EXISTS `errors`;
CREATE TABLE IF NOT EXISTS `errors` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `time` varchar(50) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `message` varchar(50) NOT NULL,
  `file` varchar(50) NOT NULL,
  `line` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table tffw.forums
DROP TABLE IF EXISTS `forums`;
CREATE TABLE IF NOT EXISTS `forums` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` mediumtext NOT NULL,
  `parent` int(10) DEFAULT NULL,
  `explanation` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table tffw.posts
DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `thread` int(10) NOT NULL,
  `poster` int(10) NOT NULL,
  `subject` mediumtext NOT NULL,
  `body` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table tffw.threads
DROP TABLE IF EXISTS `threads`;
CREATE TABLE IF NOT EXISTS `threads` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `forum` int(10) NOT NULL,
  `poster` int(10) NOT NULL,
  `subject` mediumtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(10) NOT NULL DEFAULT '0',
  `type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Data exporting was unselected.


# Dumping structure for table tffw.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(50) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID',
  `username` varchar(64) DEFAULT NULL COMMENT 'Username',
  `password` varchar(64) DEFAULT NULL COMMENT 'MD5 of Password',
  `email` varchar(64) DEFAULT NULL COMMENT 'Email Address',
  `first_name` varchar(64) DEFAULT NULL COMMENT 'First Name',
  `last_name` varchar(64) DEFAULT NULL COMMENT 'Last Name',
  `city` varchar(64) DEFAULT NULL COMMENT 'City',
  `country` varchar(64) DEFAULT NULL COMMENT 'County',
  `registration_ip` varchar(64) DEFAULT NULL COMMENT 'IP user registered from',
  `last_ip` varchar(64) DEFAULT NULL COMMENT 'IP user last used',
  `last_access` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Timesamp user last accessed account',
  `type` varchar(64) DEFAULT '0' COMMENT '0:Normal 1:Admin',
  `banned` int(1) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='StoreForge Users';

# Data exporting was unselected.
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
