# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.35)
# Database: miniblog
# Generation Time: 2018-01-19 00:00:37 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table attempts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `attempts`;

CREATE TABLE `attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(39) NOT NULL,
  `expiredate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `post_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `blocked` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `setting` varchar(100) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  UNIQUE KEY `setting` (`setting`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `config` WRITE;
/*!40000 ALTER TABLE `config` DISABLE KEYS */;

INSERT INTO `config` (`setting`, `value`)
VALUES
	('attack_mitigation_time','+30 minutes'),
	('attempts_before_ban','30'),
	('attempts_before_verify','5'),
	('bcrypt_cost','10'),
	('cookie_domain',NULL),
	('cookie_forget','+30 minutes'),
	('cookie_http','0'),
	('cookie_name','authID'),
	('cookie_path','/'),
	('cookie_remember','+1 month'),
	('cookie_secure','0'),
	('emailmessage_suppress_activation','0'),
	('emailmessage_suppress_reset','0'),
	('mail_charset','UTF-8'),
	('password_min_score','3'),
	('request_key_expiration','+10 minutes'),
	('site_activation_page','activate'),
	('site_email','peppo@gmbr.sk'),
	('site_key','ahoj ako sa mas'),
	('site_name','PHPAuth'),
	('site_password_reset_page','resetpass'),
	('site_timezone','Europe/Bratislava'),
	('site_url','http://localhost:8888/blog'),
	('smtp','1'),
	('smtp_auth','1'),
	('smtp_host','smtp.websupport.sk'),
	('smtp_password','p70cS1DXdm'),
	('smtp_port','25'),
	('smtp_security',NULL),
	('smtp_username','gshop@gmbr.sk'),
	('table_attempts','attempts'),
	('table_requests','requests'),
	('table_sessions','sessions'),
	('table_users','users'),
	('verify_email_max_length','100'),
	('verify_email_min_length','5'),
	('verify_email_use_banlist','1'),
	('verify_password_min_length','3');

/*!40000 ALTER TABLE `config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `slug` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;

INSERT INTO `posts` (`id`, `user_id`, `title`, `text`, `slug`, `created_at`, `updated_at`)
VALUES
	(1,1,'This is a title','Pastry sweet roll jelly beans ice cream. Croissant dessert gummies brownie chupa chups donut. Cheesecake soufflé danish lollipop sugar plum carrot cake muffin pie macaroon. Cheesecake caramels candy canes candy candy canes toffee. Cake lollipop halvah. Cheesecake bonbon topping lollipop cake chocolate.','this-is-a-title','2017-12-24 12:10:26','2018-01-07 15:12:31'),
	(2,1,'Candy canes biscuit','Donut pie halvah sweet gummies tart candy canes. Candy tiramisu ice cream. Oat cake pie sugar plum. Dragée biscuit pie fruitcake dragée muffin bear claw cheesecake danish. Cake danish jelly beans cookie muffin chupa chups icing pie. Powder jelly candy canes. Danish pudding gingerbread caramels. Gummies toffee croissant jelly beans. Wafer pie lemon drops.\r\n\r\nhttps://www.youtube.com/watch?v=tr8GqOzp4AA\r\n\r\nCarrot cake oat cake jelly cupcake icing sesame snaps cheesecake. Pastry icing sweet roll caramels chocolate bar gummi bears sesame snaps gingerbread pastry. Sugar plum pie halvah jelly beans. Apple pie cake candy chupa chups tootsie roll soufflé lollipop apple pie oat cake. Gingerbread macaroon gummi bears jujubes chupa chups gummies candy. Gummi bears soufflé jelly beans brownie chocolate carrot cake icing. Cookie apple pie chocolate bar gummies apple pie liquorice muffin. Pudding chocolate cake biscuit gummies pastry fruitcake gummi bears sugar plum. Gummi bears ice cream apple pie. Sugar plum cookie croissant halvah soufflé powder.','candy-canes-biscuit','2017-12-26 21:59:14','2018-01-07 15:12:34'),
	(3,1,'Liquorice tart cotton','Caramels caramels cake lollipop halvah liquorice oat cake chocolate bar croissant. Jelly-o lemon drops dragée. Jelly croissant gummies jujubes chocolate cake danish. Candy canes toffee sugar plum. Pastry jujubes pie. Cake jelly-o dessert tootsie roll carrot cake chocolate tiramisu bear claw pastry. Jelly beans lemon drops icing powder wafer lollipop cake.\n\nJujubes candy apple pie chocolate pastry jelly beans. Wafer sweet bear claw jujubes cotton candy. Chocolate bear claw cupcake. Fruitcake toffee pastry tart fruitcake tiramisu candy soufflé wafer. Tiramisu candy canes sesame snaps jelly-o marshmallow carrot cake. Jelly pastry jelly ice cream.','liquorice-tart-cotton','2017-12-26 22:01:40','2018-01-07 15:12:40'),
	(7,2,'Post for deleting','Hello everybody, you are fucking assholes, dirty whores and motherfuckers.','post-for-deleting','2018-01-04 15:33:40','2018-01-07 14:31:44'),
	(9,2,'The great job of literature','Very important post for the masses, ya.','the-great-job-of-literature','2018-01-05 01:11:07','2018-01-08 19:17:58'),
	(12,3,'New post by peppo, again','Topping caramels jelly beans carrot cake jelly-o chupa chups tootsie roll gingerbread. Carrot cake bonbon chocolate marzipan powder gummies tiramisu. Candy powder pastry cheesecake. Tart caramels bear claw cupcake muffin. Fruitcake bear claw lollipop. Muffin bear claw marshmallow marshmallow carrot cake lollipop powder carrot cake. Cookie candy carrot cake toffee lollipop. Danish sugar plum gummies liquorice cotton candy powder. Cheesecake bonbon danish pudding carrot cake powder croissant apple pie gummi bears. Gingerbread cookie muffin sweet roll caramels candy jelly beans tootsie roll danish. Sweet roll sweet roll apple pie marshmallow candy canes bear claw. Gummi bears muffin dessert chocolate jelly. Bonbon sugar plum biscuit liquorice cupcake cookie muffin marzipan. Sugar plum dragée cookie liquorice jelly gingerbread.\r\n\r\nhttps://www.youtube.com/watch?v=GrC_yuzO-Ss\r\n\r\nGummi bears danish dragée tootsie roll pudding. Cupcake lemon drops cake brownie candy chocolate bar jelly-o apple pie. Toffee sweet roll fruitcake jelly gummies lemon drops candy canes icing. Gummies icing donut. Soufflé danish chocolate cake cake lollipop. Cupcake ice cream chocolate cake danish tart carrot cake dragée jelly beans wafer. Lemon drops jelly-o sugar plum macaroon. Cupcake tiramisu croissant. Danish marshmallow candy canes jelly-o. Lemon drops jujubes biscuit chocolate carrot cake. Jelly gummi bears sweet roll. Jelly-o topping jelly-o gingerbread gummies. Lemon drops sweet roll bonbon sweet croissant sweet. Marzipan candy canes croissant cotton candy caramels chocolate cake powder jujubes.','new-post-by-peppo','2018-01-08 10:34:44','2018-01-11 00:42:14');

/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `posts_create` BEFORE INSERT ON `posts` FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW() */;;
/*!50003 SET SESSION SQL_MODE="NO_ENGINE_SUBSTITUTION" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `posts_update` BEFORE UPDATE ON `posts` FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at */;;
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;


# Dump of table posts_tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `posts_tags`;

CREATE TABLE `posts_tags` (
  `post_id` int(11) unsigned NOT NULL DEFAULT '0',
  `tag_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`,`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `posts_tags` WRITE;
/*!40000 ALTER TABLE `posts_tags` DISABLE KEYS */;

INSERT INTO `posts_tags` (`post_id`, `tag_id`)
VALUES
	(0,1),
	(1,1),
	(7,1),
	(2,2),
	(7,2),
	(12,2),
	(1,3),
	(9,3),
	(2,4);

/*!40000 ALTER TABLE `posts_tags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table requests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `requests`;

CREATE TABLE `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `rkey` varchar(20) NOT NULL,
  `expire` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `hash` varchar(40) NOT NULL,
  `expiredate` datetime NOT NULL,
  `ip` varchar(39) NOT NULL,
  `agent` varchar(200) NOT NULL,
  `cookie_crc` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;

INSERT INTO `sessions` (`id`, `uid`, `hash`, `expiredate`, `ip`, `agent`, `cookie_crc`)
VALUES
	(69,3,'ddcc5d06d6b65b76227c8a209f049bf8cf38c1b7','2018-02-17 14:46:31','::1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36','599da50c9474a4f11bc40330c7bfdfa731c03751');

/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;

INSERT INTO `tags` (`id`, `tag`)
VALUES
	(1,'balls'),
	(2,'tits'),
	(3,'judicial branch'),
	(4,'trippin');

/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('user','mod','admin','') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `isactive`, `dt`, `role`)
VALUES
	(1,'Dimitry','dimitry@email.ru','$2y$10$aS64G1l.nU1DTIE.9MlMB.n6rT36aSBDG24KcEjBWnXtu9nwqxAnK',1,'2018-01-07 00:18:37','user'),
	(2,'Sergei','sergei@centrum.sk','$2y$10$Iul60Su6sqGMhbzIGta3sembS4X9ZFWu4UovPCZpwJHEG0cVztIDm',1,'2018-01-07 01:52:12','user'),
	(3,'Jimmy','james@bush.sk','$2y$10$WHozrVwNesuooqx5DUXvMuqf7PgeyL9/FmHeG00iEzzbV5DHxoWyK',1,'2018-01-08 10:32:02','admin'),
	(4,'Anakin','dart.vader@death-star.com','$2y$10$X.d34XQ/y4xfjkTQgzk8JemNSwnyNGub29s9JxuNwJAHDz7ZGcEMy',1,'2018-01-08 10:51:21','mod'),
	(5,'demo','dtrump@lenon.sk','$2y$10$uIvyJJ4GaHjMh.gSbYfm4uKsJy4Qm2j5S1dPBk9tUcqCZBsKwQx2.',1,'2018-01-17 13:43:12','user');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
