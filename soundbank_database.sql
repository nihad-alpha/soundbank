/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 8.0.23 : Database - soundbank
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`soundbank` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `soundbank`;

/*Table structure for table `account_types` */

DROP TABLE IF EXISTS `account_types`;

CREATE TABLE `account_types` (
  `account_type_id` int NOT NULL,
  `desc` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`account_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `account_types` */

insert  into `account_types`(`account_type_id`,`desc`) values 
(0,'admin'),
(1,'ARTIST'),
(2,'LISTENER'),
(3,'GUEST'),
(4,'PREMIUM_USER');

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `account_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type_id` int DEFAULT '3',
  `email` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVE',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`account_id`),
  UNIQUE KEY `UQ_EMAIL` (`email`),
  UNIQUE KEY `UQ_USERNAME` (`username`),
  KEY `account_type_id` (`account_type_id`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`account_type_id`) REFERENCES `account_types` (`account_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `accounts` */

insert  into `accounts`(`account_id`,`username`,`password`,`account_type_id`,`email`,`status`,`name`) values 
(1,'alpha','123',0,NULL,'ACTIVE','Nihad Šuvalija'),
(3,'asdas','123444',1,NULL,'ACTIVE','Nihad dva'),
(4,'Eminem','71210',1,NULL,'ACTIVE','NO_NAME'),
(14,'cokosmoki',NULL,NULL,NULL,'ACTIVE','NO_NAME'),
(19,'neznaskosam','manemasanse',1,NULL,'ACTIVE','NO_NAME'),
(20,'axr','supercool123',3,NULL,'ACTIVE','NO_NAME'),
(22,'baltazar','baltblatazar',3,'baltazar@cartoons.com','ACTIVE','NO_NAME'),
(23,'harry potter',NULL,3,NULL,'ACTIVE','NO_NAME');

/*Table structure for table `albums` */

DROP TABLE IF EXISTS `albums`;

CREATE TABLE `albums` (
  `album_id` int NOT NULL AUTO_INCREMENT,
  `album_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `album_genre` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `artist_id` int DEFAULT NULL,
  PRIMARY KEY (`album_id`),
  KEY `artist_id` (`artist_id`),
  CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `albums` */

insert  into `albums`(`album_id`,`album_name`,`album_genre`,`artist_id`) values 
(1,'MMLP2','Rap',4),
(2,'The Beginning','Rap',1),
(3,'The Eminem Show','Rap',NULL),
(4,'MMLP',NULL,NULL),
(5,'Shake the Snowglobe',NULL,NULL);

/*Table structure for table `artists` */

DROP TABLE IF EXISTS `artists`;

CREATE TABLE `artists` (
  `artist_id` int NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `artists` */

insert  into `artists`(`artist_id`,`artist_name`) values 
(1,'Alpha'),
(2,'Vinnie Paz'),
(3,'Evil Ebenezer'),
(4,'Eminem'),
(5,'Method Man'),
(6,'Wu Tang Clan');

/*Table structure for table `playlists` */

DROP TABLE IF EXISTS `playlists`;

CREATE TABLE `playlists` (
  `playlist_id` int NOT NULL AUTO_INCREMENT,
  `account_id` int DEFAULT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`playlist_id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `playlists` */

insert  into `playlists`(`playlist_id`,`account_id`,`name`,`picture`) values 
(1,1,'Storytelling Hip Hop',NULL),
(2,1,'Chill Music',NULL);

/*Table structure for table `playlists_songs` */

DROP TABLE IF EXISTS `playlists_songs`;

CREATE TABLE `playlists_songs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `playlist_id` int DEFAULT NULL,
  `song_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `playlist_fk` (`playlist_id`),
  KEY `songs_fk` (`song_id`),
  CONSTRAINT `playlist_fk` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`playlist_id`),
  CONSTRAINT `songs_fk` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `playlists_songs` */

insert  into `playlists_songs`(`id`,`playlist_id`,`song_id`) values 
(1,1,3);

/*Table structure for table `songs` */

DROP TABLE IF EXISTS `songs`;

CREATE TABLE `songs` (
  `song_id` int NOT NULL AUTO_INCREMENT,
  `song_name` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `song_genre` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `artist_id` int DEFAULT NULL,
  `album_id` int DEFAULT NULL,
  PRIMARY KEY (`song_id`),
  KEY `album_id` (`album_id`),
  KEY `account_id` (`artist_id`),
  CONSTRAINT `songs_ibfk_2` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`),
  CONSTRAINT `songs_ibfk_3` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `songs` */

insert  into `songs`(`song_id`,`song_name`,`song_genre`,`artist_id`,`album_id`) values 
(1,'Headed for the top','Hip Hop',1,2),
(2,'Keep on Calling','Hip Hop',1,NULL),
(3,'Sunshine','Hip Hop',3,NULL),
(4,'Hannibal','Rap',2,NULL),
(5,'Pull the Trigger',NULL,NULL,NULL),
(6,'Guess What','Rap',NULL,5),
(7,'Phenomenal',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
