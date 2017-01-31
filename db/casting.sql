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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tbl_advance` */

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
  `casting_labour_fee` int(11) NOT NULL DEFAULT '0',
  `casting_labour_fee_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `after_cast_pay_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `pure_gold_with_kat` decimal(10,3) NOT NULL DEFAULT '0.000',
  `remaining_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `remaining_advance_gold` decimal(10,3) NOT NULL DEFAULT '0.000',
  `date` date DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`casting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_casting` */

insert  into `tbl_casting`(`casting_id`,`client_id`,`caret_type`,`casting_weight`,`gold_cut`,`mix_iron`,`pure_gold`,`casting_labour_fee`,`casting_labour_fee_gold`,`after_cast_pay_gold`,`pure_gold_with_kat`,`remaining_gold`,`remaining_advance_gold`,`date`,`date_created`) values (1,2,NULL,'0.000','0.000','0.000','520.230',0,'0.000','0.000','0.000','0.000','0.000','2017-01-31','2017-01-31 10:57:04'),(2,2,'12','890.230','9.273','111.270','778.960',13353,'3.179','0.000','788.233','0.000','-271.182','2017-01-31','2017-01-31 10:59:55'),(3,4,NULL,'0.000','0.000','0.000','2560.230',0,'0.000','0.000','0.000','0.000','0.000','2017-01-31','2017-01-31 11:52:46'),(4,4,'21','500.520','5.214','109.480','391.040',7508,'1.787','0.000','396.254','0.000','2162.189','2017-01-31','2017-01-31 11:53:37'),(5,4,'21','1500.230','15.627','328.170','1172.060',37506,'8.928','0.000','1187.687','0.000','0.000','2017-01-31','2017-01-31 11:54:32'),(6,4,'12','520.230','5.419','65.020','455.210',7803,'1.858','0.000','460.629','0.000','503.087','2017-01-31','2017-01-31 11:58:01'),(7,4,'12','890.230','46.366','111.270','778.960',13353,'3.179','0.000','825.326','0.000','-325.418','2017-01-31','2017-01-31 11:59:19'),(8,1,NULL,'0.000','0.000','0.000','890.260',0,'0.000','0.000','0.000','0.000','0.000','2017-01-31','2017-01-31 11:59:57');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_debit_credit_gold` */

insert  into `tbl_debit_credit_gold`(`gold_id`,`client_id`,`casting_id`,`advance_id`,`desc`,`coa_code`,`debit_gold`,`credit_gold`,`is_update`,`date_created`,`is_advance`) values (1,2,1,0,'Advance gold add in inventory','100001','520.230','0.000',0,'2017-01-31 10:57:05',1),(2,2,1,0,'Advance Gold Sohail','200002','0.000','520.230',0,'2017-01-31 10:57:05',1),(3,2,2,0,'Client take gold','200002','791.412','0.000',0,'2017-01-31 10:59:55',0),(4,2,2,0,'Owner give gold','100001','0.000','791.412',0,'2017-01-31 10:59:55',0),(5,4,3,0,'Advance gold add in inventory','100001','2560.230','0.000',0,'2017-01-31 11:52:46',1),(6,4,3,0,'Advance Gold Khan','200004','0.000','2560.230',0,'2017-01-31 11:52:46',1),(7,4,4,0,'Client take gold','200004','398.041','0.000',0,'2017-01-31 11:53:37',0),(8,4,4,0,'Owner give gold','100001','0.000','398.041',0,'2017-01-31 11:53:37',0),(9,4,5,0,'Client take gold','200004','1196.615','0.000',0,'2017-01-31 11:54:32',0),(10,4,5,0,'Owner give gold','100001','0.000','1196.615',0,'2017-01-31 11:54:32',0),(11,4,6,0,'Client take gold','200004','462.487','0.000',0,'2017-01-31 11:58:01',0),(12,4,6,0,'Owner give gold','100001','0.000','462.487',0,'2017-01-31 11:58:01',0),(13,4,7,0,'Client take gold','200004','828.505','0.000',0,'2017-01-31 11:59:19',0),(14,4,7,0,'Owner give gold','100001','0.000','828.505',0,'2017-01-31 11:59:19',0),(15,1,8,0,'Advance gold add in inventory','100001','890.260','0.000',0,'2017-01-31 11:59:57',1),(16,1,8,0,'Advance Gold Jawad','200001','0.000','890.260',0,'2017-01-31 11:59:57',1);

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
