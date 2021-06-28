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

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `account_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'USER',
  `token` text COLLATE utf8mb4_unicode_ci,
  `token_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_EMAIL` (`email`),
  UNIQUE KEY `UQ_USERNAME` (`username`),
  KEY `account_type_id` (`account_type`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `accounts` */

insert  into `accounts`(`id`,`name`,`email`,`username`,`password`,`status`,`created_at`,`account_type`,`token`,`token_created_at`) values 
(1,'Nihad Šuvalija',NULL,'alpha','$2y$10$KOG8BDaRI3R4CpdJ.udXX.N4z6e/cTc8YCX3XAN7gpGTTB9Z1sIrS','ACTIVE',NULL,'USER',NULL,NULL),
(43,'Niho Nihoni','nihadsuvalija@gmail.com','nihadsuvalija','$2y$10$.K0tGWPZvhqv7DFeh2tCk.8.PDilsJvGLe8g8/D7feYYKt2ijNxvy','ACTIVE',NULL,'ADMIN','7d94ae0f2ff88235627b598bcad0aae9','2021-05-19 15:56:42'),
(67,NULL,'nihad.suvalija@stu.ibu.edu.ba','nihozini','$2y$10$WwrA8aKXf5sSESuT2.LIc.9ij961PRfkkuqzIMJaumXdCaPvycCgq','ACTIVE',NULL,'ADMIN',NULL,'2021-06-28 20:30:25');

/*Table structure for table `albums` */

DROP TABLE IF EXISTS `albums`;

CREATE TABLE `albums` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `album_genre` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `artist_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `artist_id` (`artist_id`),
  CONSTRAINT `albums_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `albums` */

insert  into `albums`(`id`,`name`,`album_genre`,`artist_id`) values 
(1,'MMLP2','Rap',4),
(2,'The Beginning','Rap',1),
(3,'The Eminem Show','Rap',NULL),
(4,'MMLP',NULL,NULL),
(5,'Shake the Snowglobe',NULL,NULL),
(6,'YSIV','Hip Hop',7);

/*Table structure for table `artists` */

DROP TABLE IF EXISTS `artists`;

CREATE TABLE `artists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_url` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'https://song-storage.fra1.digitaloceanspaces.com/template.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `artists` */

insert  into `artists`(`id`,`name`,`description`,`cover_url`) values 
(1,'Alpha','Ovaj artist sam ja.','https://song-storage.fra1.digitaloceanspaces.com/template.jpg'),
(2,'Vinnie Paz',NULL,'https://song-storage.fra1.digitaloceanspaces.com/template.jpg'),
(3,'Evil Ebenezer',NULL,'https://song-storage.fra1.digitaloceanspaces.com/template.jpg'),
(4,'Eminem',NULL,'https://song-storage.fra1.digitaloceanspaces.com/template.jpg'),
(5,'Method Man',NULL,'https://song-storage.fra1.digitaloceanspaces.com/template.jpg'),
(6,'Wu Tang Clan',NULL,'https://song-storage.fra1.digitaloceanspaces.com/template.jpg'),
(7,'Logic',NULL,'https://song-storage.fra1.digitaloceanspaces.com/template.jpg'),
(8,'Alicia Keys',NULL,'https://song-storage.fra1.digitaloceanspaces.com/template.jpg');

/*Table structure for table `playlists` */

DROP TABLE IF EXISTS `playlists`;

CREATE TABLE `playlists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `account_id` int DEFAULT NULL,
  `name` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account_id` (`account_id`),
  CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `playlists` */

insert  into `playlists`(`id`,`account_id`,`name`,`picture`) values 
(1,43,'Storytelling Hip Hop',NULL),
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
  CONSTRAINT `playlist_fk` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`),
  CONSTRAINT `songs_fk` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `playlists_songs` */

insert  into `playlists_songs`(`id`,`playlist_id`,`song_id`) values 
(1,1,3);

/*Table structure for table `songs` */

DROP TABLE IF EXISTS `songs`;

CREATE TABLE `songs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `song_genre` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `artist_id` int DEFAULT NULL,
  `album_id` int DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci,
  `cover_url` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`),
  KEY `account_id` (`artist_id`),
  CONSTRAINT `songs_ibfk_2` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`),
  CONSTRAINT `songs_ibfk_3` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `songs` */

insert  into `songs`(`id`,`name`,`song_genre`,`artist_id`,`album_id`,`url`,`cover_url`) values 
(1,'Headed for the top','Hip Hop',1,2,NULL,NULL),
(2,'Keep on Calling','Hip Hop',1,NULL,NULL,NULL),
(3,'Sunshine','Hip Hop',3,NULL,NULL,NULL),
(4,'Hannibal','Rap',2,NULL,NULL,NULL),
(5,'Pull the Trigger',NULL,NULL,NULL,NULL,NULL),
(6,'Guess What','Rap',NULL,5,NULL,NULL),
(7,'Phenomenal',NULL,NULL,NULL,NULL,NULL),
(8,'YSIV','Hip Hop',7,NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
