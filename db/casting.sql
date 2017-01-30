/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.1.16-MariaDB : Database - casting
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`casting` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `casting`;

/*Table structure for table `tbl_accounts` */

DROP TABLE IF EXISTS `tbl_accounts`;

CREATE TABLE `tbl_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `balance` decimal(10,3) DEFAULT '0.000',
  `date` datetime DEFAULT NULL,
  `advance` tinyint(1) NOT NULL DEFAULT '0',
  `remaining` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_accounts` */

/*Table structure for table `tbl_advance` */

DROP TABLE IF EXISTS `tbl_advance`;

CREATE TABLE `tbl_advance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `advance_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_advance` */

insert  into `tbl_advance`(`id`,`client_id`,`date_created`,`advance_gold`) values (1,1,'2017-01-29 22:16:11','230.260'),(2,3,'2017-01-29 22:24:16','560.230'),(3,2,'2017-01-29 22:26:47','256.230'),(4,4,'2017-01-29 22:32:37','0.000'),(5,4,'2017-01-30 12:25:19','200.230'),(6,1,'2017-01-30 12:25:49','279.717'),(7,4,'2017-01-30 12:26:06','244.596');

/*Table structure for table `tbl_casting` */

DROP TABLE IF EXISTS `tbl_casting`;

CREATE TABLE `tbl_casting` (
  `casting_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `caret_type` varchar(15) DEFAULT NULL,
  `casting_weight` decimal(10,3) NOT NULL DEFAULT '0.000',
  `gold_cut` decimal(10,3) NOT NULL DEFAULT '0.000',
  `mix_iron` decimal(10,3) NOT NULL DEFAULT '0.000',
  `pure_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `casting_labour_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `after_cast_pay_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `pure_gold_with_kat` decimal(10,3) NOT NULL DEFAULT '0.000',
  `remaining_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `remaining_advance_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `casting_labour_fee_gold` int(11) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`casting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_casting` */

insert  into `tbl_casting`(`casting_id`,`client_id`,`caret_type`,`casting_weight`,`gold_cut`,`mix_iron`,`pure_gold`,`casting_labour_fee`,`after_cast_pay_gold`,`pure_gold_with_kat`,`remaining_gold`,`remaining_advance_gold`,`casting_labour_fee_gold`,`date_created`) values (1,1,'12','520.230','5.419','65.020','455.210','2.48','0.000','460.629','0.000','0.000',0,'2017-01-29 22:16:52'),(2,1,'12','520.260','5.419','65.030','455.230','1.86','0.000','460.649','0.000','0.000',0,'2017-01-29 22:23:42'),(3,3,'12','120.230','1.252','15.020','105.210','0.34','0.000','106.462','0.000','0.000',0,'2017-01-29 22:24:43'),(4,3,'12','200.000','2.083','25.000','175.000','0.57','0.000','177.083','0.000','0.000',0,'2017-01-29 22:26:28'),(5,2,'12','356.230','3.711','44.520','311.710','1.27','0.000','315.421','0.000','0.000',0,'2017-01-29 22:27:14'),(6,1,'12','250.230','2.607','31.270','218.960','0.89','0.000','221.567','317.460','0.000',0,'2017-01-29 22:30:37'),(7,4,'12','500.230','5.211','62.520','437.710','1.91','0.000','442.921','444.826','0.000',0,'2017-01-29 22:33:01'),(8,1,'12','520.230','5.419','65.020','455.210','7803.45','500.230','460.629','279.717','0.000',2,'2017-01-30 12:04:46'),(9,3,'21','120.230','1.252','26.300','93.930','1803.45','0.000','95.182','0.000','0.000',0,'2017-01-30 12:23:33'),(10,1,'12','520.230','5.419','65.020','455.210','7803.45','200.230','460.629','0.000','0.000',2,'2017-01-30 13:58:03'),(11,4,'12','520.230','5.419','65.020','455.210','7803.45','200.230','460.629','262.257','0.000',2,'2017-01-30 14:06:46');

/*Table structure for table `tbl_clients` */

DROP TABLE IF EXISTS `tbl_clients`;

CREATE TABLE `tbl_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) DEFAULT NULL,
  `shop_name` text,
  `phone` varchar(15) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_clients` */

insert  into `tbl_clients`(`client_id`,`client_name`,`shop_name`,`phone`,`date_created`) values (1,'Jawad','Test','12456','2017-01-28 11:47:10'),(2,'Sohail','Test','54546','2017-01-28 12:09:25'),(3,'Akhtar','Ghouri Lab','121312','2017-01-28 12:23:39'),(4,'Khan','test','4546546','2017-01-29 22:32:36');

/*Table structure for table `tbl_coa` */

DROP TABLE IF EXISTS `tbl_coa`;

CREATE TABLE `tbl_coa` (
  `coa_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `coa_code` int(11) NOT NULL,
  `coa_account` varchar(128) NOT NULL,
  `coa_credit` int(11) NOT NULL DEFAULT '0',
  `coa_debit` int(11) NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `coa_type` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`coa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_coa` */

insert  into `tbl_coa`(`coa_id`,`client_id`,`coa_code`,`coa_account`,`coa_credit`,`coa_debit`,`date_created`,`parent_id`,`coa_type`) values (3,1,100001,'Inventory',0,0,'2017-01-28 10:32:55',0,'a'),(4,2,100002,'Working Process',0,0,'2017-01-28 10:32:55',0,'a'),(5,3,100003,'Finish Goods',0,0,'2017-01-28 10:32:55',0,'a'),(6,4,100004,'Owner Gold',0,0,'2017-01-28 10:32:55',0,'a'),(10,1,200001,'Jawad',0,0,'2017-01-28 11:47:10',0,'c'),(11,2,200002,'Sohail',0,0,'2017-01-28 12:09:25',0,'c'),(12,3,200003,'Akhtar',0,0,'2017-01-28 12:23:39',0,'c'),(13,4,200004,'Khan',0,0,'2017-01-29 22:32:37',0,'c');

/*Table structure for table `tbl_debit_credit_gold` */

DROP TABLE IF EXISTS `tbl_debit_credit_gold`;

CREATE TABLE `tbl_debit_credit_gold` (
  `gold_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `casting_id` int(11) NOT NULL DEFAULT '0',
  `advance_id` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(255) DEFAULT NULL,
  `coa_code` varchar(10) DEFAULT NULL,
  `debit_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `credit_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `is_update` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT NULL,
  `is_advance` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gold_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_debit_credit_gold` */

insert  into `tbl_debit_credit_gold`(`gold_id`,`client_id`,`casting_id`,`advance_id`,`desc`,`coa_code`,`debit_gold`,`credit_gold`,`is_update`,`date_created`,`is_advance`) values (1,1,0,1,'Advance gold add in inventory','100001','230.260','0.000',0,'2017-01-29 22:16:11',1),(2,1,0,1,'Advance Gold Jawad','200001','0.000','230.260',0,'2017-01-29 22:16:11',1),(3,1,1,0,'Client take gold','200001','463.106','0.000',0,'2017-01-29 22:16:53',0),(4,1,1,0,'Owner give gold','100001','0.000','463.106',0,'2017-01-29 22:16:53',0),(5,1,2,0,'Client take gold','200001','462.507','0.000',0,'2017-01-29 22:23:42',0),(6,1,2,0,'Owner give gold','100001','0.000','462.507',0,'2017-01-29 22:23:42',0),(7,1,2,0,'Advance gold add in inventory','100001','600.353','0.000',0,'2017-01-29 22:23:42',0),(8,1,2,0,'Advance Gold Jawad','200001','0.000','600.353',0,'2017-01-29 22:23:42',0),(9,3,0,2,'Advance gold add in inventory','100001','560.230','0.000',0,'2017-01-29 22:24:16',1),(10,3,0,2,'Advance Gold Akhtar','200003','0.000','560.230',0,'2017-01-29 22:24:16',1),(11,3,3,0,'Client take gold','200003','106.806','0.000',0,'2017-01-29 22:24:43',0),(12,3,3,0,'Owner give gold','100001','0.000','106.806',0,'2017-01-29 22:24:43',0),(13,3,4,0,'Client take gold','200003','177.655','0.000',0,'2017-01-29 22:26:28',0),(14,3,4,0,'Owner give gold','100001','0.000','177.655',0,'2017-01-29 22:26:28',0),(15,2,0,3,'Advance gold add in inventory','100001','256.230','0.000',0,'2017-01-29 22:26:47',1),(16,2,0,3,'Advance Gold Sohail','200002','0.000','256.230',0,'2017-01-29 22:26:47',1),(17,2,5,0,'Client take gold','200002','316.693','0.000',0,'2017-01-29 22:27:14',0),(18,2,5,0,'Owner give gold','100001','0.000','316.693',0,'2017-01-29 22:27:14',0),(19,1,6,0,'Client take gold','200001','222.460','0.000',0,'2017-01-29 22:30:37',0),(20,1,6,0,'Owner give gold','100001','0.000','222.460',0,'2017-01-29 22:30:37',0),(21,4,0,4,'Advance gold add in inventory','100001','0.000','0.000',0,'2017-01-29 22:32:37',1),(22,4,0,4,'Advance Gold Khan','200004','0.000','0.000',0,'2017-01-29 22:32:37',1),(23,4,7,0,'Client take gold','200004','444.826','0.000',0,'2017-01-29 22:33:01',0),(24,4,7,0,'Owner give gold','100001','0.000','444.826',0,'2017-01-29 22:33:01',0),(25,1,8,0,'Client take gold','200001','462.487','0.000',0,'2017-01-30 12:04:47',0),(26,1,8,0,'Owner give gold','100001','0.000','462.487',0,'2017-01-30 12:04:47',0),(27,1,8,0,'Advance gold add in inventory','100001','500.230','0.000',0,'2017-01-30 12:04:47',0),(28,1,8,0,'Advance Gold Jawad','200001','0.000','500.230',0,'2017-01-30 12:04:47',0),(29,3,9,0,'Client take gold','200003','95.612','0.000',0,'2017-01-30 12:23:33',0),(30,3,9,0,'Owner give gold','100001','0.000','95.612',0,'2017-01-30 12:23:33',0),(31,4,0,5,'Advance gold add in inventory','100001','200.230','0.000',0,'2017-01-30 12:25:19',1),(32,4,0,5,'Advance Gold Khan','200004','0.000','200.230',0,'2017-01-30 12:25:19',1),(33,1,0,6,'Advance gold add in inventory','100001','279.717','0.000',0,'2017-01-30 12:25:50',1),(34,1,0,6,'Advance Gold Jawad','200001','0.000','279.717',0,'2017-01-30 12:25:50',1),(35,4,0,7,'Advance gold add in inventory','100001','244.596','0.000',0,'2017-01-30 12:26:06',1),(36,4,0,7,'Advance Gold Khan','200004','0.000','244.596',0,'2017-01-30 12:26:07',1),(37,1,10,0,'Client take gold','200001','462.487','0.000',0,'2017-01-30 13:58:03',0),(38,1,10,0,'Owner give gold','100001','0.000','462.487',0,'2017-01-30 13:58:03',0),(39,1,10,0,'Advance gold add in inventory','100001','200.230','0.000',0,'2017-01-30 13:58:03',0),(40,1,10,0,'Advance Gold Jawad','200001','0.000','200.230',0,'2017-01-30 13:58:03',0),(41,4,11,0,'Client take gold','200004','462.487','0.000',0,'2017-01-30 14:06:46',0),(42,4,11,0,'Owner give gold','100001','0.000','462.487',0,'2017-01-30 14:06:46',0),(43,4,11,0,'Advance gold add in inventory','100001','200.230','0.000',0,'2017-01-30 14:06:46',0),(44,4,11,0,'Advance Gold Khan','200004','0.000','200.230',0,'2017-01-30 14:06:46',0);

/*Table structure for table `tbl_language` */

DROP TABLE IF EXISTS `tbl_language`;

CREATE TABLE `tbl_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `urdu_name` varchar(255) DEFAULT NULL,
  `english_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`language_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_language` */

insert  into `tbl_language`(`language_id`,`urdu_name`,`english_name`) values (1,'تمام دوکاندار','All shopkeeper'),(2,'خالص سونا درج','Enter Pure Gold');

/*Table structure for table `tbl_today_gold_rate` */

DROP TABLE IF EXISTS `tbl_today_gold_rate`;

CREATE TABLE `tbl_today_gold_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `today_rate` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_today_gold_rate` */

insert  into `tbl_today_gold_rate`(`id`,`today_rate`) values (1,49000);

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` text,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`user_id`,`user_name`,`password`,`user_type`,`remember_token`,`date_created`) values (1,'admin','d033e22ae348aeb5660fc2140aec35850c4da997',1,'admin|588a334aaaaf6588a334aaaafd588a334aaaaff',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
