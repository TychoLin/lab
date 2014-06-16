-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.37-0ubuntu0.12.04.1 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table labdb.tblCategory
DROP TABLE IF EXISTS `tblCategory`;
CREATE TABLE IF NOT EXISTS `tblCategory` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_parent_id` int(10) unsigned NOT NULL,
  `category_name` varchar(32) NOT NULL,
  `category_rank` int(10) unsigned NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table labdb.tblCategory: ~12 rows (approximately)
/*!40000 ALTER TABLE `tblCategory` DISABLE KEYS */;
INSERT INTO `tblCategory` (`category_id`, `category_parent_id`, `category_name`, `category_rank`) VALUES
	(1, 0, 'A', 1),
	(2, 0, 'B', 1),
	(3, 0, 'C', 1),
	(4, 1, 'a1', 1),
	(5, 1, 'a2', 1),
	(6, 1, 'a3', 1),
	(7, 2, 'b1', 1),
	(8, 2, 'b2', 1),
	(9, 2, 'b3', 1),
	(10, 3, 'c1', 1),
	(11, 3, 'c2', 1),
	(12, 3, 'c3', 1);
/*!40000 ALTER TABLE `tblCategory` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
