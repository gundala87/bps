/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.1.39-MariaDB : Database - db_bps
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `cari_kab` */

DROP TABLE IF EXISTS `cari_kab`;

CREATE TABLE `cari_kab` (
  `kode` varchar(4) NOT NULL,
  `kodePro` varchar(2) DEFAULT NULL,
  `kodeKab` varchar(2) DEFAULT NULL,
  `namaPro` varchar(100) DEFAULT NULL,
  `namaKab` varchar(100) DEFAULT NULL,
  `url` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cari_kec` */

DROP TABLE IF EXISTS `cari_kec`;

CREATE TABLE `cari_kec` (
  `kode` varchar(7) NOT NULL,
  `kodePro` varchar(2) DEFAULT NULL,
  `kodeKab` varchar(2) DEFAULT NULL,
  `kodeKec` varchar(3) DEFAULT NULL,
  `namaPro` varchar(100) DEFAULT NULL,
  `namaKab` varchar(100) DEFAULT NULL,
  `namaKec` varchar(100) DEFAULT NULL,
  `url` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cari_kel` */

DROP TABLE IF EXISTS `cari_kel`;

CREATE TABLE `cari_kel` (
  `kode` varchar(10) NOT NULL,
  `kodePro` varchar(2) DEFAULT NULL,
  `kodeKab` varchar(2) DEFAULT NULL,
  `kodeKec` varchar(3) DEFAULT NULL,
  `kodeKel` varchar(3) DEFAULT NULL,
  `namaPro` varchar(100) DEFAULT NULL,
  `namaKab` varchar(100) DEFAULT NULL,
  `namaKec` varchar(100) DEFAULT NULL,
  `namaKel` varchar(100) DEFAULT NULL,
  `url` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `cari_pro` */

DROP TABLE IF EXISTS `cari_pro`;

CREATE TABLE `cari_pro` (
  `kodePro` varchar(2) NOT NULL,
  `namaPro` varchar(100) DEFAULT NULL,
  `url` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`kodePro`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
