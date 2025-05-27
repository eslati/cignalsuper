-- --------------------------------------------------------
-- Host:                         172.31.18.245
-- Server version:               10.0.38-MariaDB-0ubuntu0.16.04.1 - Ubuntu 16.04
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table [dev]_cignalepass.badge
CREATE TABLE IF NOT EXISTS `badge` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.badge: ~9 rows (approximately)
INSERT INTO `badge` (`id`, `name`, `image`, `active`) VALUES
	(1, '1', 'cignal.png', 'Y'),
	(2, '2', 'curiosity.png', 'Y'),
	(3, '3', 'fuse.png', 'Y'),
	(4, '4', 'hallmark.png', 'Y'),
	(5, '5', 'lionsgate.png', 'Y'),
	(6, '6', 'live.png', 'Y'),
	(7, '7', 'max.png', 'Y'),
	(8, '8', 'viu.png', 'Y'),
	(9, 'prizer', 'n/a', 'N');

-- Dumping structure for table [dev]_cignalepass.claim
CREATE TABLE IF NOT EXISTS `claim` (
  `win_id` mediumint(8) unsigned NOT NULL,
  `claimtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`win_id`),
  CONSTRAINT `FK_claim_winner` FOREIGN KEY (`win_id`) REFERENCES `winner` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.claim: ~2 rows (approximately)
INSERT INTO `claim` (`win_id`, `claimtime`) VALUES
	(1, '2025-05-22 11:09:42'),
	(2, '2025-05-23 02:45:41'),
	(3, '2025-05-23 06:45:44');

-- Dumping structure for table [dev]_cignalepass.eventtime
CREATE TABLE IF NOT EXISTS `eventtime` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `desc` varchar(50) DEFAULT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `active` (`active`) USING BTREE,
  KEY `start` (`start`) USING BTREE,
  KEY `end` (`end`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.eventtime: ~0 rows (approximately)

-- Dumping structure for table [dev]_cignalepass.location
CREATE TABLE IF NOT EXISTS `location` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.location: ~0 rows (approximately)
INSERT INTO `location` (`id`, `name`, `active`) VALUES
	(1, 'BGC', 'Y');

-- Dumping structure for table [dev]_cignalepass.playbadge
CREATE TABLE IF NOT EXISTS `playbadge` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` mediumint(8) unsigned NOT NULL,
  `badge_id` tinyint(3) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `qq` (`player_id`,`badge_id`),
  KEY `FK__badge` (`badge_id`),
  KEY `FK_playbadge_user` (`user_id`),
  CONSTRAINT `FK__badge` FOREIGN KEY (`badge_id`) REFERENCES `badge` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK__player` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_playbadge_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.playbadge: ~41 rows (approximately)
INSERT INTO `playbadge` (`id`, `player_id`, `badge_id`, `user_id`, `stamp`) VALUES
	(1, 2, 1, 1, '2025-05-22 10:32:14'),
	(2, 2, 2, 2, '2025-05-22 10:32:36'),
	(3, 2, 3, 3, '2025-05-22 10:33:02'),
	(4, 2, 4, 4, '2025-05-22 10:33:22'),
	(5, 2, 5, 5, '2025-05-22 10:33:45'),
	(6, 2, 6, 6, '2025-05-22 10:38:04'),
	(7, 2, 7, 7, '2025-05-22 10:38:22'),
	(8, 2, 8, 8, '2025-05-22 10:38:43'),
	(9, 3, 1, 1, '2025-05-22 10:51:44'),
	(10, 3, 2, 2, '2025-05-22 10:52:06'),
	(11, 3, 3, 3, '2025-05-22 10:52:34'),
	(12, 3, 4, 4, '2025-05-22 10:52:52'),
	(13, 3, 5, 5, '2025-05-22 10:53:17'),
	(14, 3, 6, 6, '2025-05-22 10:53:32'),
	(15, 3, 7, 7, '2025-05-22 10:53:48'),
	(16, 3, 8, 8, '2025-05-22 10:54:16'),
	(17, 4, 8, 8, '2025-05-22 11:00:23'),
	(18, 4, 3, 3, '2025-05-22 11:00:31'),
	(19, 4, 2, 2, '2025-05-22 11:00:39'),
	(20, 4, 5, 5, '2025-05-22 11:00:47'),
	(21, 4, 7, 7, '2025-05-22 11:00:58'),
	(22, 4, 1, 1, '2025-05-22 11:01:09'),
	(23, 4, 6, 6, '2025-05-22 11:01:26'),
	(24, 4, 4, 4, '2025-05-22 11:08:42'),
	(25, 5, 1, 1, '2025-05-23 02:41:49'),
	(26, 5, 2, 2, '2025-05-23 02:42:12'),
	(27, 5, 3, 3, '2025-05-23 02:42:26'),
	(28, 5, 4, 4, '2025-05-23 02:42:46'),
	(29, 5, 5, 5, '2025-05-23 02:43:43'),
	(30, 5, 6, 6, '2025-05-23 02:44:18'),
	(31, 1, 7, 7, '2025-05-23 02:44:41'),
	(32, 5, 8, 8, '2025-05-23 02:44:59'),
	(33, 6, 1, 1, '2025-05-23 06:39:16'),
	(34, 6, 2, 2, '2025-05-23 06:40:53'),
	(35, 6, 3, 3, '2025-05-23 06:41:29'),
	(36, 6, 4, 4, '2025-05-23 06:42:24'),
	(37, 6, 5, 5, '2025-05-23 06:43:02'),
	(38, 6, 6, 6, '2025-05-23 06:43:33'),
	(39, 6, 7, 7, '2025-05-23 06:44:01'),
	(40, 7, 8, 8, '2025-05-23 06:45:00'),
	(41, 1, 8, 8, '2025-05-23 06:51:07'),
	(42, 6, 8, 8, '2025-05-23 06:52:53');

-- Dumping structure for table [dev]_cignalepass.player
CREATE TABLE IF NOT EXISTS `player` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` char(10) NOT NULL,
  `data` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `qr` varchar(40) NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.player: ~7 rows (approximately)
INSERT INTO `player` (`id`, `mobile`, `data`, `created`, `qr`, `active`) VALUES
	(1, '9171234567', 'Galexis', '2025-05-22 10:31:52', 'c4ca4238a0b923820dcc509a6f75849b.png', 'Y'),
	(2, '9178099251', 'brigette', '2025-05-22 10:44:57', 'c81e728d9d4c2f636f067f89cc14862c.png', 'Y'),
	(3, '9189121036', 'alex', '2025-05-22 10:50:29', 'eccbc87e4b5ce2fe28308fd9f2a7baf3.png', 'Y'),
	(4, '9123456789', '123', '2025-05-22 10:58:55', 'a87ff679a2f3e71d9181a67b7542122c.png', 'Y'),
	(5, '9115303387', 'Gali', '2025-05-23 02:41:25', 'e4da3b7fbbce2345d7772b0674a318d5.png', 'Y'),
	(6, '9123456677', 'name', '2025-05-23 03:39:20', '1679091c5a880faf6fb5e6087eb1b2dc.png', 'Y'),
	(7, '9161234567', 'AAA', '2025-05-23 06:35:28', '8f14e45fceea167a5a36dedd4bea2543.png', 'Y');

-- Dumping structure for table [dev]_cignalepass.prize
CREATE TABLE IF NOT EXISTS `prize` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.prize: ~5 rows (approximately)
INSERT INTO `prize` (`id`, `name`, `image`, `active`) VALUES
	(1, 'Cignal Super Golf Umbrella', 'umbrella.jpg', 'Y'),
	(2, 'Cignal Super Mobile Lanyard', 'lanyard.img', 'Y'),
	(3, 'Cignal Super Notebook', 'notebook.img', 'Y'),
	(4, 'candle', 'kandolindawin.img', 'N'),
	(5, 'kalapati', 'mababaanglipad.img', 'N');

-- Dumping structure for table [dev]_cignalepass.prizealloc
CREATE TABLE IF NOT EXISTS `prizealloc` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `loc_id` smallint(5) unsigned NOT NULL,
  `prize_id` smallint(5) unsigned NOT NULL,
  `percent` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `stock` smallint(5) unsigned NOT NULL,
  `claim` smallint(5) unsigned NOT NULL DEFAULT '0',
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`),
  KEY `FK_prizealloc_location` (`loc_id`),
  KEY `FK_prizealloc_prize` (`prize_id`),
  KEY `active` (`active`),
  KEY `stock` (`stock`),
  KEY `claim` (`claim`),
  CONSTRAINT `FK_prizealloc_location` FOREIGN KEY (`loc_id`) REFERENCES `location` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_prizealloc_prize` FOREIGN KEY (`prize_id`) REFERENCES `prize` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.prizealloc: ~5 rows (approximately)
INSERT INTO `prizealloc` (`id`, `loc_id`, `prize_id`, `percent`, `stock`, `claim`, `active`) VALUES
	(1, 1, 2, 100, 1000, 1000, 'Y'),
	(2, 1, 1, 100, 600, 600, 'Y'),
	(3, 1, 3, 100, 500, 500, 'Y'),
	(4, 1, 5, 100, 20, 3, 'N'),
	(5, 1, 4, 100, 300, 222, 'N');

-- Dumping structure for table [dev]_cignalepass.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `loc_id` smallint(5) unsigned NOT NULL,
  `badge_id` tinyint(3) unsigned NOT NULL,
  `uname` char(50) NOT NULL,
  `paswd` char(32) NOT NULL,
  `prizer` enum('Y','N') NOT NULL DEFAULT 'N',
  `active` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `uname` (`uname`),
  UNIQUE KEY `uni` (`loc_id`,`badge_id`),
  KEY `active` (`active`),
  KEY `FK_user_badge` (`badge_id`),
  CONSTRAINT `FK__location` FOREIGN KEY (`loc_id`) REFERENCES `location` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user_badge` FOREIGN KEY (`badge_id`) REFERENCES `badge` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.user: ~9 rows (approximately)
INSERT INTO `user` (`id`, `loc_id`, `badge_id`, `uname`, `paswd`, `prizer`, `active`) VALUES
	(1, 1, 1, 'here_cignal', '9fb52', 'N', 'Y'),
	(2, 1, 2, 'here_curiosity', '24bc2', 'N', 'Y'),
	(3, 1, 3, 'here_fuse', '82356', 'N', 'Y'),
	(4, 1, 4, 'here_hallmark', '559b4', 'N', 'Y'),
	(5, 1, 5, 'here_lionsgate', '4f482', 'N', 'Y'),
	(6, 1, 6, 'here_live', '32e6b', 'N', 'Y'),
	(7, 1, 7, 'here_max', 'cd7f2', 'N', 'Y'),
	(8, 1, 8, 'here_viu', 'a3aac', 'N', 'Y'),
	(12, 1, 9, 'here_prize', '8bfbd', 'Y', 'Y');

-- Dumping structure for table [dev]_cignalepass.winner
CREATE TABLE IF NOT EXISTS `winner` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `player_id` mediumint(8) unsigned NOT NULL,
  `alloc_id` mediumint(8) unsigned NOT NULL,
  `stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `player_id` (`player_id`),
  KEY `FK_winner_prizealloc` (`alloc_id`),
  CONSTRAINT `FK_winner_player` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_winner_prizealloc` FOREIGN KEY (`alloc_id`) REFERENCES `prizealloc` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table [dev]_cignalepass.winner: ~4 rows (approximately)
INSERT INTO `winner` (`id`, `player_id`, `alloc_id`, `stamp`) VALUES
	(1, 4, 5, '2025-05-22 11:08:42'),
	(2, 5, 5, '2025-05-23 02:44:59'),
	(3, 7, 3, '2025-05-23 06:45:00'),
	(4, 6, 2, '2025-05-23 06:52:53');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
