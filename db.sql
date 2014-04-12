-- --------------------------------------------------------
-- Host:                         database.diymsclub.com
-- Server version:               5.1.56-log - MySQL Server
-- Server OS:                    pc-linux-gnu
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table kehadiran.kehadiran
CREATE TABLE IF NOT EXISTS `kehadiran` (
  `kehadiran_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` int(10) unsigned DEFAULT NULL,
  `pelajar_id` int(10) unsigned DEFAULT NULL,
  `hadir` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`kehadiran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Dumping data for table kehadiran.kehadiran: ~0 rows (approximately)
/*!40000 ALTER TABLE `kehadiran` DISABLE KEYS */;
/*!40000 ALTER TABLE `kehadiran` ENABLE KEYS */;


-- Dumping structure for table kehadiran.kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `kelas_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kursus_id` int(10) unsigned DEFAULT NULL,
  `tarikh_masa` datetime DEFAULT NULL,
  PRIMARY KEY (`kelas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table kehadiran.kelas: ~0 rows (approximately)
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` (`kelas_id`, `kursus_id`, `tarikh_masa`) VALUES
	(2, 1, '2014-04-04 09:00:00'),
	(7, 1, '2014-04-15 14:00:00'),
	(9, 1, '2014-04-12 15:00:00');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;


-- Dumping structure for table kehadiran.kursus
CREATE TABLE IF NOT EXISTS `kursus` (
  `kursus_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pensyarah_id` int(10) unsigned DEFAULT NULL,
  `kod_kursus` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`kursus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table kehadiran.kursus: ~0 rows (approximately)
/*!40000 ALTER TABLE `kursus` DISABLE KEYS */;
INSERT INTO `kursus` (`kursus_id`, `pensyarah_id`, `kod_kursus`) VALUES
	(1, 1, 'SUBJ01-201');
/*!40000 ALTER TABLE `kursus` ENABLE KEYS */;


-- Dumping structure for table kehadiran.kursus_pelajar
CREATE TABLE IF NOT EXISTS `kursus_pelajar` (
  `kpid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kursus_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pelajar_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`kpid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table kehadiran.kursus_pelajar: ~0 rows (approximately)
/*!40000 ALTER TABLE `kursus_pelajar` DISABLE KEYS */;
INSERT INTO `kursus_pelajar` (`kpid`, `kursus_id`, `pelajar_id`) VALUES
	(1, 1, 1),
	(5, 1, 2);
/*!40000 ALTER TABLE `kursus_pelajar` ENABLE KEYS */;


-- Dumping structure for table kehadiran.pelajar
CREATE TABLE IF NOT EXISTS `pelajar` (
  `pelajar_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `no_matrik` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`pelajar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table kehadiran.pelajar: ~0 rows (approximately)
/*!40000 ALTER TABLE `pelajar` DISABLE KEYS */;
INSERT INTO `pelajar` (`pelajar_id`, `nama`, `no_matrik`) VALUES
	(1, 'Dino', 'MA000001'),
	(2, 'Liza binti Husin', 'MA000002'),
	(4, 'Malikul bin Kareem', 'MA000003'),
	(5, 'Hasanul Hasyim', 'MA000004'),
	(6, 'Letchumi Lakhiani', 'MA000005');
/*!40000 ALTER TABLE `pelajar` ENABLE KEYS */;


-- Dumping structure for table kehadiran.pensyarah
CREATE TABLE IF NOT EXISTS `pensyarah` (
  `pensyarah_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) DEFAULT NULL,
  `no_staf` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`pensyarah_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table kehadiran.pensyarah: ~0 rows (approximately)
/*!40000 ALTER TABLE `pensyarah` DISABLE KEYS */;
INSERT INTO `pensyarah` (`pensyarah_id`, `nama`, `no_staf`) VALUES
	(1, 'Ustaz Halim Othman', 'STAF001');
/*!40000 ALTER TABLE `pensyarah` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
