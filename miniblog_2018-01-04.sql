# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.35)
# Database: miniblog
# Generation Time: 2018-01-04 01:21:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `post_id` int(11) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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
	(1,0,'This is a title','Pastry sweet roll jelly beans ice cream. Croissant dessert gummies brownie chupa chups donut. Cheesecake soufflé danish lollipop sugar plum carrot cake muffin pie macaroon. Cheesecake caramels candy canes candy candy canes toffee. Cake lollipop halvah. Cheesecake bonbon topping lollipop cake chocolate.','this-is-a-title','2017-12-24 12:10:26','2018-01-04 01:33:49'),
	(2,0,'Candy canes biscuit','Donut pie halvah sweet gummies tart candy canes. Candy tiramisu ice cream. Oat cake pie sugar plum. Dragée biscuit pie fruitcake dragée muffin bear claw cheesecake danish. Cake danish jelly beans cookie muffin chupa chups icing pie. Powder jelly candy canes. Danish pudding gingerbread caramels. Gummies toffee croissant jelly beans. Wafer pie lemon drops.\r\n\r\nhttps://www.youtube.com/watch?v=tr8GqOzp4AA\r\n\r\nCarrot cake oat cake jelly cupcake icing sesame snaps cheesecake. Pastry icing sweet roll caramels chocolate bar gummi bears sesame snaps gingerbread pastry. Sugar plum pie halvah jelly beans. Apple pie cake candy chupa chups tootsie roll soufflé lollipop apple pie oat cake. Gingerbread macaroon gummi bears jujubes chupa chups gummies candy. Gummi bears soufflé jelly beans brownie chocolate carrot cake icing. Cookie apple pie chocolate bar gummies apple pie liquorice muffin. Pudding chocolate cake biscuit gummies pastry fruitcake gummi bears sugar plum. Gummi bears ice cream apple pie. Sugar plum cookie croissant halvah soufflé powder.','candy-canes-biscuit','2017-12-26 21:59:14','2018-01-02 00:36:58'),
	(3,0,'Liquorice tart cotton','Caramels caramels cake lollipop halvah liquorice oat cake chocolate bar croissant. Jelly-o lemon drops dragée. Jelly croissant gummies jujubes chocolate cake danish. Candy canes toffee sugar plum. Pastry jujubes pie. Cake jelly-o dessert tootsie roll carrot cake chocolate tiramisu bear claw pastry. Jelly beans lemon drops icing powder wafer lollipop cake.\n\nJujubes candy apple pie chocolate pastry jelly beans. Wafer sweet bear claw jujubes cotton candy. Chocolate bear claw cupcake. Fruitcake toffee pastry tart fruitcake tiramisu candy soufflé wafer. Tiramisu candy canes sesame snaps jelly-o marshmallow carrot cake. Jelly pastry jelly ice cream.','liquorice-tart-cotton','2017-12-26 22:01:40','2017-12-26 22:02:42'),
	(4,0,'I am New Title','I am New Post','i-am-new-title','2018-01-02 15:39:09','2018-01-02 15:39:09'),
	(5,0,'new post','very new post','new-post','2018-01-04 02:06:53','2018-01-04 02:06:53');

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
	(5,1),
	(1,2),
	(2,2),
	(4,2),
	(5,2),
	(5,3),
	(2,4),
	(4,4),
	(5,4);

/*!40000 ALTER TABLE `posts_tags` ENABLE KEYS */;
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



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
